<?php
/**
 * Sync Fish Rules API data.
 *
 * @package fish-rules-api-integration
 */

namespace FishRulesAPIIntegration\Sync;

add_action( 'init', __NAMESPACE__ . '\add_crons' );
add_action( 'fishrules_versions', __NAMESPACE__ . '\check_versions' );
add_action( 'fishrules_seasons', __NAMESPACE__ . '\apply_seasons' );

/**
 * Set up cron jobs to automatically pull data from the API.
 */
function add_crons() {
	if ( '1' === get_option( 'fishrules_crons' ) ) {
		return;
	}

	// Check regulations versions every day.
	if ( ! wp_next_scheduled( 'fishrules_versions' ) ) {
		// 7:01 a.m. UTC = 2:01 a.m. Eastern.
		wp_schedule_event( strtotime( 'tomorrow 07:01' ), 'daily', 'fishrules_versions' );
	}

	// Check seasons every day.
	if ( ! wp_next_scheduled( 'fishrules_seasons' ) ) {
		// 8:01 a.m. UTC = 3:01 a.m. Eastern.
		wp_schedule_event( strtotime( 'tomorrow 08:01' ), 'daily', 'fishrules_seasons' );
	}

	// Confirm that crons are set up.
	update_option( 'fishrules_crons', '1' );
}

/**
 * Check both recreational and commercial regulation API versions.
 * If they have changed, run imports.
 */
function check_versions() {
	// If the versions aren't saved, run the initial species import.
	if ( false === get_option( 'fishrules_versions' ) ) {
		import_species();
		/**
		 * Species are all imported as drafts. They must be published manually
		 * in order for any regulations to be saved to the site.
		 */
	}

	// See which versions the site currently has.
	$saved_versions = get_option( 'fishrules_versions' );

	// Get current API versions.
	$api_versions = get_versions();

	// Versions can be in multiple formats - i.e. 0.0.12 and 5.20 - so just compare equality, not greater/less than.
	if ( $api_versions ) {
		// If commercial version has changed, re-import (which also updates the commercial version).
		if ( 0 !== version_compare( $api_versions->commercial->version, $saved_versions['com'] ) ) {
			import_commercial();
		}
		// If recreational version has changed, re-import (which also updates the recreational version).
		if ( 0 !== version_compare( $api_versions->recreational->version, $saved_versions['rec'] ) ) {
			import_recreational();
		}
	}
}

/**
 * Get the currently-published API versions from Fish Rules.
 *
 * @return object Versions of the Recreational API and the Commercial API.
 */
function get_versions() {
	$url     = 'https://app.fishrulesapp.com/api/info/regulations';
	$results = get_api_results( $url );
	return $results;
}

/**
 * Add or update version tracker as a WP option.
 *
 * @param string $com Commercial regulations version.
 * @param string $rec Recreational regulations version.
 */
function update_versions( $com = '0.0.0', $rec = '0.0' ) {
	update_option(
		'fishrules_versions',
		array(
			'com' => $com,
			'rec' => $rec,
		),
	);
}

/**
 * Import commercial regulations.
 */
function import_commercial() {
	$council = get_option( 'fishrules_council' );

	// Get all Fish Rules `Areas` that apply to this council's waters.
	$url     = 'https://app.fishrulesapp.com/api/commercial/areas';
	$results = get_api_results( $url );
	if ( is_array( $results ) ) {
		$areas = array();
		foreach ( $results as $area ) {
			// Check whether the currently looped Area applies to this council's waters.
			$applies = 0;

			// If applicable states are a substring of any of the currently looped area->regions, proceed.
			switch ( $council ) {
				case 'gulf':
					$states = array( 'TX', 'LA', 'MS', 'AL', 'FL' );
					break;
				case 'pacific':
					$states = array( 'WA', 'OR', 'CA' );
					break;
				case 'safmc':
					$states = array( 'NC', 'SC', 'GA', 'FL' );
					break;
			}

			foreach ( $area->regions as $region ) {
				if (
					in_array( substr( $region, 0, 2 ), $states, true )
				) {
					$applies = 1;
					break;
				}
			}

			if ( 1 === $applies ) {
				$areas[ $area->id ] = array(
					'name'        => $area->name,
					'description' => $area->description,
				);
			}
		}
	}

	// Get all Fish Rules `Conditions`.
	$url     = 'https://app.fishrulesapp.com/api/commercial/conditions';
	$results = get_api_results( $url );
	if ( is_array( $results ) ) {
		$conditions = array();
		foreach ( $results as $condition ) {
			$conditions[ $condition->id ] = array(
				'name'        => $condition->name,
				'description' => $condition->description,
			);
		}
	}

	/**
	 * Get all Fish Rules `Permits` that apply to this council's waters.
	 * Save them as both `com_open` and `com_closed` terms.
	 * Note: this does not use the Permits API because it doesn't include `Zone Name`.
	 * One Permit can have multiple Zones with different regulations and seasons.
	 */
	$url     = 'https://app.fishrulesapp.com/api/commercial/regulations';
	$results = get_api_results( $url );
	if ( is_array( $results ) ) {

		// Get the current `com_open` taxonomy terms.
		$open_terms = get_terms(
			array(
				'taxonomy'   => 'com_open',
				'hide_empty' => false,
				'fields'     => 'id=>name',
			)
		);

		// Get the current `com_closed` taxonomy terms.
		$closed_terms = get_terms(
			array(
				'taxonomy'   => 'com_closed',
				'hide_empty' => false,
				'fields'     => 'id=>name',
			)
		);

		// Identify councils by Fish Rules abbreviations, and set exclusions.
		switch ( $council ) {
			case 'gulf':
				$council = 'GMFMC';
				$exclude = '';
				break;
			case 'pacific':
				$council = 'PFMC';
				$exclude = '';
				break;
			case 'safmc':
				$council = 'SAFMC';
				$exclude = 'Gulf of Mexico';
				break;
		}

		// For each API item.
		foreach ( $results as $regulation ) {
			// Check whether the currently looped `Permit` applies to this council's waters.
			if ( in_array( $council, $regulation->permit_agencies, true ) && false === strpos( $regulation->zone_name, $exclude ) ) {
				$permit_name = $regulation->permit_name . ' - ' . $regulation->zone_name;

				// If this `Permit` does not have a `com_open` term, create one.
				if ( ! in_array( $permit_name, $open_terms, true ) ) {
					wp_insert_term( $permit_name, 'com_open' );
				}

				// If this `Permit` does not have a `com_closed` term, create one.
				if ( ! in_array( $permit_name, $closed_terms, true ) ) {
					wp_insert_term( $permit_name, 'com_closed' );
				}
			}
		}

		// Remove all previous commercial regulation data.
		global $wpdb;
		$wpdb->get_results( "DELETE FROM $wpdb->postmeta WHERE meta_key = 'com_regs'" );

		// Get all published `fish_species` posts.
		$species_by_fishrules_id = get_species();

		// Get all Commercial Regulations that apply to this council's waters, reusing the results we already got above.
		if ( is_array( $results ) ) {
			// For each API item.
			foreach ( $results as $regulation ) {
				// Check whether the currently looped Regulation applies to this council's waters.
				if ( in_array( $council, $regulation->permit_agencies, true ) && false === strpos( $regulation->zone_name, $exclude ) ) {

					// Find the matching Fish Species CPT in WP.
					$species_post_id = '';

					if ( array_key_exists( intval( $regulation->fish_id ), $species_by_fishrules_id ) ) {
						$species_post_id = $species_by_fishrules_id[ intval( $regulation->fish_id ) ];
					}

					if ( $species_post_id ) {

						// Get the existing commercial regulation postmeta, if any.
						$current_regs = get_post_meta( $species_post_id, 'com_regs', true );

						// If none were found, create an empty array.
						if ( ! is_array( $current_regs ) ) {
							$current_regs = array();
						}

						// Add `Areas` that apply to this `Permit`.
						$this_species_areas = array();
						foreach ( $regulation->permit_areas as $api_area ) {
							if ( ! empty( $areas[ $api_area ]['description'] ) ) {
								$this_species_areas[] = array(
									'name'        => $areas[ $api_area ]['name'],
									'description' => $areas[ $api_area ]['description'],
								);
							}
						}

						// Add `Conditions` that apply to this `Permit`.
						$this_species_conditions = array();
						foreach ( $regulation->permit_conditions as $api_condition ) {
							if ( ! empty( $conditions[ $api_condition ]->description ) ) {
								$this_species_conditions[] = array(
									'name'        => $conditions[ $api_condition ]['name'],
									'description' => $conditions[ $api_condition ]['description'],
								);
							}
						}

						// Add the current looped API regulation.
						$current_regs[ $regulation->id ] = array(
							'heading'    => $regulation->permit_name . ' - ' . $regulation->zone_name,
							'details'    => $regulation,
							'areas'      => $this_species_areas,
							'conditions' => $this_species_conditions,
						);

						// Save the regulations as postmeta on the `fish_species`.
						update_post_meta( $species_post_id, 'com_regs', $current_regs );
					}
				}
			}

			// Update the version option.
			$saved_versions = get_option( 'fishrules_versions' );
			$api_versions   = get_versions();
			if ( $api_versions ) {
				update_versions( $api_versions->commercial->version, $saved_versions['rec'] );
			}

			// Set Commercial Season taxonomy for each Species (whether it's currently open or closed).
			apply_seasons( true, false );
		}
	}
}

/**
 * Import recreational regulations.
 */
function import_recreational() {
	global $wpdb;

	// Remove all previous recreational regulation data.
	// (There might be a different number of locations to check this time).
	$wpdb->get_results( "DELETE FROM $wpdb->postmeta WHERE meta_key = 'rec_regs'" );

	// Get all published `fish_species` posts, Locations, and Regions.
	$species_by_fishrules_id = get_species();
	$locations               = get_option( 'fishrules_locations' );
	$regions                 = get_option( 'fishrules_regions' );

	// Get the current `rec_open` taxonomy terms.
	$open_terms = get_terms(
		array(
			'taxonomy'   => 'rec_open',
			'hide_empty' => false,
			'fields'     => 'names',
		)
	);
	// Get the current `rec_closed` taxonomy terms.
	$closed_terms = get_terms(
		array(
			'taxonomy'   => 'rec_closed',
			'hide_empty' => false,
			'fields'     => 'names',
		)
	);

	// Make sure `rec_open` and `rec_closed` taxonomy terms exist.
	foreach ( $locations as $key => $values ) {
		// If this Location does not have a `rec_open` term, create one.
		if ( ! in_array( $values['name'], $open_terms, true ) ) {
			wp_insert_term( $values['name'], 'rec_open' );
		}
		// If this Location does not have a `rec_closed` term, create one.
		if ( ! in_array( $values['name'], $closed_terms, true ) ) {
			wp_insert_term( $values['name'], 'rec_closed' );
		}
	}

	// Prepare Location data to send to API function.
	$base_url = 'https://app.fishrulesapp.com/api/regulations/location/';

	foreach ( $locations as $key => $values ) {

		// Retrieve recreational regulations from each location API URL.
		get_rec_regs(
			array(
				'url'  => $base_url . $values['coords'] . '?expand=true',
				'name' => $values['name'],
			),
			$species_by_fishrules_id
		);
	}

	// Prepare Region data to send to API function.
	$base_url = 'https://app.fishrulesapp.com/api/regulations/species/'; // 'fish_id/latitude/longitude'

	foreach ( $regions as $key => $values ) {

		// Retrieve recreational regulations from each regional API URL.
		get_rec_regs(
			array(
				'url'  => $base_url . $values['species_id'] . '/' . $values['coords'],
				'name' => $values['name'],
			),
			$species_by_fishrules_id
		);
	}

	// Update the version option.
	$saved_versions = get_option( 'fishrules_versions' );
	$api_versions   = get_versions();
	if ( $api_versions ) {
		update_versions( $saved_versions['com'], $api_versions->recreational->version );
	}

	// Set Season taxonomy for each Species (whether it's currently open or closed) - only Recreational.
	apply_seasons( false, true );
}

/**
 * Retrieve recreational regulations from the Fish Rules API and apply
 * them to individual fish species.
 *
 * The rec_regs metadata is stored as an array keyed by regulation ID. Each
 * regulation contains an array of locations it applies to and the details
 * of the regulation.
 *
 * @param array $data                    The API URL and (region or location) name.
 * @param array $species_by_fishrules_id Array of published species post IDs.
 */
function get_rec_regs( $data, $species_by_fishrules_id ) {
	$results = get_api_results( $data['url'] );

	if ( ! is_array( $results ) ) {
		return;
	}

	foreach ( $results as $regulation ) {
		// Make sure the array key exists - meaning this species is published. Any in draft mode won't import regulations.
		if ( ! array_key_exists( (int) $regulation->fish_id, $species_by_fishrules_id ) ) {
			continue;
		}

		$species_post_id = $species_by_fishrules_id[ (int) $regulation->fish_id ];

		// Retrieve the data stored for this regulation on this species.
		$regulations = get_post_meta( $species_post_id, 'rec_regs', true );

		if ( ! $regulations ) {
			$regulations = array();
		}

		if ( ! isset( $regulations[ $regulation->id ] ) ) {
			$regulation_data = array(
				'locations' => array(),
				'details'   => '',
			);
		} else {
			$regulation_data = $regulations[ $regulation->id ];
		}

		// Replace the stored regulation details with the most recent.
		$regulation_data['details'] = $regulation;

		// Ensure the location name exists.
		if ( ! in_array( $data['name'], $regulation_data['locations'], true ) ) {
			$regulation_data['locations'][] = $data['name'];
		}

		$regulations[ $regulation->id ] = $regulation_data;

		update_post_meta( $species_post_id, 'rec_regs', $regulations );
	}
}

/**
 * Import fish species.
 */
function import_species() {
	// Access the Species API.
	$url     = 'https://app.fishrulesapp.com/api/species';
	$results = get_api_results( $url );
	if ( is_array( $results ) ) {
		// For each API item.
		foreach ( $results as $fish ) {
			// Check to see if it exists as CPT (explicitly request all statuses, since we don't want to duplicate Drafts).
			$species = get_posts(
				array(
					'post_type'   => 'fish_species',
					'post_status' => 'any',
					'meta_key'    => 'fish_rules_id',
					'meta_value'  => (int) $fish->fish_id,
				)
			);
			// If not, create it and associate it to the shadow taxonomy.
			if ( 0 === count( $species ) ) {
				// Create the post.
				$fish_details = array(
					'post_type'   => 'fish_species',
					'post_title'  => sanitize_text_field( $fish->species ),
					'post_status' => 'draft',
					'meta_input'  => array(
						'fish_rules_id'       => (int) $fish->fish_id,
						'fish_shape'          => sanitize_text_field( $fish->shape ),
						'fish_edibility'      => wp_kses_post( $fish->edibility ),
						'fish_species_report' => (int) $fish->species_report_only,
						'fish_synonyms'       => sanitize_array( $fish->synonyms ),
					),
				);

				wp_insert_post( $fish_details );
			}
		}
	}
}

/**
 * Apply season terms to species.
 *
 * @param bool $com Whether to apply commercial seasons.
 * @param bool $rec Whether to apply recreational seasons.
 */
function apply_seasons( $com = true, $rec = true ) {
	// TODO: test all import types thoroughly.
	// Get all published `fish_species` posts.
	$species_by_fishrules_id = get_species();
	$today                   = gmdate( 'Y-m-d H:i:s.u' );

	// Loop through species.
	foreach ( $species_by_fishrules_id as $species_post_id ) {
		if ( true === $com ) {
			// Remove commercial season terms.
			wp_set_object_terms( $species_post_id, '', 'com_open' );
			wp_set_object_terms( $species_post_id, '', 'com_closed' );

			// Extract commercial season data, removing `Permit`s as we set terms.
			$com_regs = get_post_meta( $species_post_id, 'com_regs', true );

			// Check each commercial regulation for prohibited flag or season info.
			$open_permits   = array();
			$closed_permits = array();

			if ( $com_regs ) {
				foreach ( $com_regs as $com_reg ) {
					if ( 1 === $com_reg['details']->prohibited ) {
						// If prohibited, set to closed.
						$closed_permit    = get_term_by( 'name', $com_reg['heading'], 'com_closed' );
						$closed_permits[] = $closed_permit->slug;
					} elseif ( count( $com_reg['details']->seasons ) > 0 ) {
						// Default to open, then loop through each season.
						$season_status = 'open';
						foreach ( $com_reg['details']->seasons as $season ) {
							if ( ! empty( $season->starts_at ) ) {
								if ( $today >= $season->starts_at . '00:00:00.000000' && $today <= $season->ends_at . '00:00:00.000000' ) {
									$season_status = 'closed';
								}
							}
						}
						// Save the final status after checking all seasons.
						if ( 'open' === $season_status ) {
							$open_permit    = get_term_by( 'name', $com_reg['heading'], 'com_open' );
							$open_permits[] = $open_permit->slug;
						} else {
							$closed_permit    = get_term_by( 'name', $com_reg['heading'], 'com_closed' );
							$closed_permits[] = $closed_permit->slug;
						}
					} else {
						// If not prohibited and no season, season is open.
						$open_permit    = get_term_by( 'name', $com_reg['heading'], 'com_open' );
						$open_permits[] = $open_permit->slug;
					}
				}
			}

			// Set open `Permit`s (that apply to this species, which were found in com_regs).
			if ( count( $open_permits ) > 0 ) {
				wp_set_object_terms( $species_post_id, $open_permits, 'com_open' );
			}

			// Set closed `Permit`s (that apply to this species, which were found in com_regs).
			if ( count( $closed_permits ) > 0 ) {
				wp_set_object_terms( $species_post_id, $closed_permits, 'com_closed' );
			}
		}

		if ( true === $rec ) {
			// Remove recreational season terms.
			wp_set_object_terms( $species_post_id, '', 'rec_open' );
			wp_set_object_terms( $species_post_id, '', 'rec_closed' );

			// Extract recreational season data, removing `Locations` as we set terms.
			$all_locations = get_locations();

			// Check each recreational regulation for prohibited flag or season info.
			$rec_regs         = get_post_meta( $species_post_id, 'rec_regs', true );
			$open_locations   = array();
			$closed_locations = array();

			if ( $rec_regs ) {
				foreach ( $rec_regs as $rec_reg ) {
					// Identify the `Locations` this regulation set applies to.
					$lowercase_locations = array_map( 'strtolower', $rec_reg['locations'] );

					if ( 1 === $rec_reg['details']->prohibited ) {
						// If prohibited, set to closed.
						$closed_locations = array_merge( $closed_locations, $lowercase_locations );
					} elseif ( count( $rec_reg['details']->seasons ) > 0 ) {
						// Default to open, then loop through each season.
						$season_status = 'open';
						foreach ( $rec_reg['details']->seasons as $season ) {
							if ( ! empty( $season->starts_at->date ) ) {
								if ( $today >= $season->starts_at->date && $today <= $season->ends_at->date ) {
									// If today is between start and end dates, season is *closed*.
									$season_status = 'closed';
								}
							}
						}
						// Save the final status after checking all seasons.
						if ( 'open' === $season_status ) {
							$open_locations = array_merge( $open_locations, $lowercase_locations );
						} else {
							$closed_locations = array_merge( $closed_locations, $lowercase_locations );
						}
					} else {
						// If not prohibited and no season, season is open.
						$open_locations = array_merge( $open_locations, $lowercase_locations );
					}

					// Remove `Locations` that have been set.
					foreach ( $lowercase_locations as $set_location ) {
						foreach ( array_keys( $all_locations, $set_location, true ) as $key ) {
							unset( $all_locations[ $key ] );
						}
					}
				}
			}

			// For any remaining `Locations` (for which regulations were not found), set the season to open.
			if ( count( $all_locations ) > 0 ) {
				$open_locations = array_merge( $open_locations, $all_locations );
			}

			// Set open `Locations` (where rec_regs were found-and-open AND where rec_regs were not found).
			if ( count( $open_locations ) > 0 ) {
				wp_set_object_terms( $species_post_id, $open_locations, 'rec_open' );
			}

			// Set closed `Locations` (where rec_regs were found-and-closed).
			if ( count( $closed_locations ) > 0 ) {
				wp_set_object_terms( $species_post_id, $closed_locations, 'rec_closed' );
			}
		}
	}
}

/**
 * Set up the token information used when making API requests.
 *
 * The client ID and API key should be stored manually with
 * `wp option add` or similar and cleared once complete.
 *
 * @return array API credentials.
 */
function get_creds() {
	$creds = array(
		'client_id' => get_option( 'fishrules_clientid' ),
		'api_key'   => get_option( 'fishrules_apikey' ),
	);
	return $creds;
}

/**
 * Make an API request.
 *
 * @param string $url The API endpoint URL.
 * @return array || boolean API results, or false.
 */
function get_api_results( $url ) {
	$creds    = get_creds();
	$api_data = wp_remote_get(
		$url,
		array(
			'headers' => array(
				'x-client-id' => $creds['client_id'],
				'x-api-key'   => $creds['api_key'],
			),
			'timeout' => 10,
		),
	);
	if ( is_wp_error( $api_data ) ) {
		die();
	}
	$api_response = json_decode( $api_data['body'] );
	if ( $api_response->results ) {
		return( $api_response->results );
	}
	return false;
}

/**
 * Retrieve Locations (the places that affect all Species).
 * Does not include Regions (places that affect individual Species).
 *
 * @return array An array of lowercase location names (state abbreviations).
 */
function get_locations() {
	// Get the full list of Locations - or, if none are saved, one default.
	$default       = array(
		array(
			'coords' => '29.5/-78',
			'name'   => 'FL',
		),
	);
	$locations     = get_option( 'fishrules_locations', '' );
	$locations     = $locations ? $locations : $default;
	$all_locations = array();
	foreach ( $locations as $location ) {
		$all_locations[] = strtolower( $location['name'] );
	}
	return $all_locations;
}

/**
 * Get all published `fish_species` posts.
 *
 * @return array Array of `fish_species` post IDs.
 */
function get_species() {
	$species_post_ids = get_posts(
		array(
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'post_type'              => 'fish_species',
			'post_status'            => 'publish',
			'posts_per_page'         => '-1',
			'update_post_meta_cache' => true, // Be confident regulation metadata is clear after manual WPDB delete.
		)
	);

	// Build a new array for the species, with Fish Rules ID as the key, for faster parsing.
	$species_by_fishrules_id = array();

	foreach ( $species_post_ids as $species_post_id ) {
		// Add the Fish Rules "Species ID" from postmeta as the array key.
		$fishrules_id                                       = get_post_meta( $species_post_id, 'fish_rules_id', true );
		$species_by_fishrules_id[ intval( $fishrules_id ) ] = $species_post_id;
	}

	return $species_by_fishrules_id;
}

/**
 * Sanitize arrays (like the incoming Fish Edibility field).
 *
 * @param array $array An array of text entries to be santitized.
 * @return array Sanitized array.
 */
function sanitize_array( $array ) {
	foreach ( $array as $key => $value ) {
		$value = sanitize_text_field( $value );
	}
	return $array;
}
