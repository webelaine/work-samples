<?php
/**
 * Create a plugin options page.
 *
 * @package fish-rules-api-integration
 */

namespace FishRulesAPIIntegration\Options;

add_action( 'admin_menu', __NAMESPACE__ . '\add_options_page' );
add_action( 'admin_init', __NAMESPACE__ . '\build_settings_sections' );
add_action( 'wp_ajax_fishrules_api_refresh', __NAMESPACE__ . '\api_refresh' );
add_action( 'wp_ajax_nopriv_fishrules_api_refresh', __NAMESPACE__ . '\api_refresh' );
add_action( 'update_option_fishrules_locations', __NAMESPACE__ . '\sync_location_terms', 10, 2 );

/**
 * Add the options page.
 */
function add_options_page() {
	$my_page = \add_options_page( 'Fish Rules API Settings', 'Fish Rules API', 'manage_options', 'fish-rules-integration', __NAMESPACE__ . '\display_admin_page' );
	add_action( 'load-' . $my_page, __NAMESPACE__ . '\load_admin_js' );
}

/**
 * This function is only called when this options page loads - but it's too early to enqueue.
 */
function load_admin_js() {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_admin_js' );
}

/**
 * Once we can enqueue, we do - so the scripts only output on this options page.
 */
function enqueue_admin_js() {

	// Save import options.
	$asset_data = require dirname( __DIR__ ) . '/build/options-fish-import.asset.php';
	wp_enqueue_script(
		'options-fish-import',
		plugins_url( '../build/options-fish-import.js', __FILE__ ),
		array(),
		$asset_data['version'],
		true,
	);

	// AJAX for manual refresh buttons.
	$asset_data = require_once dirname( __DIR__, 1 ) . '/build/api-refresh.asset.php';
	wp_enqueue_script(
		'api-refresh',
		plugins_url( '../build/api-refresh.js', __FILE__ ),
		$asset_data['dependencies'],
		$asset_data['version'],
		true
	);
	wp_localize_script(
		'api-refresh',
		'ajaxData',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'ajax-api-nonce' ),
		),
	);
}

/**
 * Display the options page.
 */
function display_admin_page() {
	?>
	<div class="wrap">
		<h1>Fish Rules API Integration Options</h1>
		<form method="post" action="options.php">
			<?php
				do_settings_sections( 'fish-rules-integration' );
				settings_fields( 'fish-rules-settings' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Register the sections, settings, and fields.
 */
function build_settings_sections() {
	// SECTION: Manual refresh buttons.
	add_settings_section(
		'manual_refresh_buttons',
		'Manual Refresh',
		__NAMESPACE__ . '\manual_refresh_info',
		'fish-rules-integration',
	);

	// SECTION: Fish Rules API credentials.
	add_settings_section(
		'fish_rules_creds',
		'Fish Rules API Credentials',
		__NAMESPACE__ . '\fishrules_api_info',
		'fish-rules-integration',
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_clientid',
		__NAMESPACE__ . '\sanitize_credential',
	);

	add_settings_field(
		'fishrules_clientid',
		'Client ID',
		__NAMESPACE__ . '\fishrules_clientid_field',
		'fish-rules-integration',
		'fish_rules_creds',
		array(
			'label_for' => 'fishrules_clientid',
		),
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_apikey',
		__NAMESPACE__ . '\sanitize_credential',
	);

	add_settings_field(
		'fishrules_apikey',
		'API Key',
		__NAMESPACE__ . '\fishrules_apikey_field',
		'fish-rules-integration',
		'fish_rules_creds',
		array(
			'label_for' => 'fishrules_apikey',
		),
	);

	// SECTION: Council.
	add_settings_section(
		'fishery',
		'Fishery Management Council',
		__NAMESPACE__ . '\fishrules_council_info',
		'fish-rules-integration'
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_council',
		__NAMESPACE__ . '\sanitize_credential',
	);

	add_settings_field(
		'fishrules_council',
		'Council',
		__NAMESPACE__ . '\fishrules_council_field',
		'fish-rules-integration',
		'fishery',
		array(
			'label_for' => 'fishrules_council',
		),
	);

	// SECTION: Locations (for all species, required).
	add_settings_section(
		'locations',
		'Locations for All Species',
		__NAMESPACE__ . '\locations_info',
		'fish-rules-integration',
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_locations',
		__NAMESPACE__ . '\sanitize_input',
	);

	// Add a variable number of fields (name and coords).
	$options = get_option( 'fishrules_locations', array() );
	$maxnum  = is_array( $options ) ? count( $options ) : 0;
	for ( $i = 0; $i < $maxnum; $i++ ) {
		add_settings_field(
			'locations_name_' . $i,
			'Location ' . ( $i + 1 ) . ' Name',
			__NAMESPACE__ . '\combined_callback',
			'fish-rules-integration',
			'locations',
			array(
				'fieldnum' => $i,
				'fieldkey' => 'name',
				'optname'  => 'fishrules_locations',
			),
		);
		add_settings_field(
			'locations_coords_' . $i,
			'Location ' . ( $i + 1 ) . ' Coordinates',
			__NAMESPACE__ . '\combined_callback',
			'fish-rules-integration',
			'locations',
			array(
				'fieldnum' => $i,
				'fieldkey' => 'coords',
				'optname'  => 'fishrules_locations',
			),
		);
	}

	// SECTION: Regions (one per species, optional).
	add_settings_section(
		'regions',
		'Regions for Specific Species',
		__NAMESPACE__ . '\regions_info',
		'fish-rules-integration',
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_regions',
		__NAMESPACE__ . '\sanitize_input',
	);

	// Add a variable number of region fields (name, coords, and species_id).
	$options = get_option( 'safmc_regions', array() );
	$maxnum  = is_array( $options ) ? count( $options ) : 0;
	for ( $i = 0; $i < $maxnum; $i++ ) {
		add_settings_field(
			'name_' . $i,
			'Region ' . ( $i + 1 ) . ' Name',
			__NAMESPACE__ . '\combined_callback',
			'fish-rules-integration',
			'regions_section',
			array(
				'fieldnum' => $i,
				'fieldkey' => 'name',
				'optname'  => 'fishrules_regions',
			),
		);
		add_settings_field(
			'coords_' . $i,
			'Region ' . ( $i + 1 ) . ' Coordinates',
			__NAMESPACE__ . '\combined_callback',
			'fish-rules-integration',
			'regions_section',
			array(
				'fieldnum' => $i,
				'fieldkey' => 'coords',
				'optname'  => 'fishrules_regions',
			),
		);
		add_settings_field(
			'species_' . $i,
			'Region ' . ( $i + 1 ) . ' Species ID',
			__NAMESPACE__ . '\combined_callback',
			'fish-rules-settings',
			'regions_section',
			array(
				'fieldnum' => $i,
				'fieldkey' => 'species_id',
				'optname'  => 'fishrules_regions',
			),
		);
	}

	// SECTION: All Regulations options.
	add_settings_section(
		'fish_rules_all',
		'All Regulations options',
		__NAMESPACE__ . '\fishrules_allregs_info',
		'fish-rules-integration',
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_hideloc',
		__NAMESPACE__ . '\sanitize_credential',
	);

	add_settings_field(
		'fishrules_hideloc',
		'Hide location column',
		__NAMESPACE__ . '\fishrules_location_field',
		'fish-rules-integration',
		'fish_rules_all',
		array(
			'label_for' => 'fishrules_clientid',
		),
	);

	register_setting(
		'fish-rules-settings',
		'fishrules_open',
		__NAMESPACE__ . '\sanitize_credential',
	);

	add_settings_field(
		'fishrules_open',
		'Open* Text',
		__NAMESPACE__ . '\fishrules_open_field',
		'fish-rules-integration',
		'fish_rules_all',
		array(
			'label_for' => 'fishrules_open',
		),
	);
}

/**
 * Show Manual Refresh section intro.
 */
function manual_refresh_info() {
	?>
	<p>Pull data from the Fish Rules API onto this WordPress site. Please wait for the confirmation message, which may take a minute or two. You do not need to press "Save Changes" when using these three buttons.</p>

	<?php
	// If the regulations versions aren't saved, make sure the user knows to publish some species.
	if ( false === get_option( 'fishrules_versions' ) ) {
		$species = new \WP_Query(
			array(
				'post_type'   => 'fish_species',
				'post_status' => 'publish',
			)
		);

		if ( $species->have_posts() ) {
			?>
			<p>When you refresh regulations, they will be applied to any species that are currently published. Any species still in draft mode will be ignored.</p>
			<?php
		} else {
			// Check whether species have been imported at all.
			$draft_species = new \WP_Query(
				array(
					'post_type'   => 'fish_species',
					'post_status' => 'draft',
				)
			);

			if ( $draft_species->have_posts() ) {
				// No species are published. Tell the user to publish some.
				?>
				<p>None of the species are published. Please visit the <a href="/wp-admin/edit.php?post_type=fish_species">Species Listing</a>, publish the species for which you want to display regulations, and then return to this page to refresh the regulations.</p>
				<?php
			} else {
				// Species have not been imported to the site.
				?>
				<p>Please run "Refresh Species" first to import species from Fish Rules.</p>
				<?php
			}
		}
	}
	?>

	<button type="button" class="manualrefresh" id="species" value="species">Refresh Species</button>
	<button type="button" class="manualrefresh" id="comregs" value="comregs">Refresh Commercial Regs</button>
	<button type="button" class="manualrefresh" id="recregs" value="recregs">Refresh Recreational Regs</button>
	<hr/>
	<p>For all the fields below, make sure to press "Save Changes" when you are done.</p>
	<?php
}

/**
 * Show the API section intro.
 */
function fishrules_api_info() {
	?>
	<p>You'll need to obtain these from Fish Rules. Once saved, it's unlikely you'll need to change them.</p>
	<?php
}

/**
 * Show the API Client ID field.
 */
function fishrules_clientid_field() {
	$client_id = get_option( 'fishrules_clientid' );
	printf(
		'<input type="text" id="fishrules_clientid" name="fishrules_clientid" value="%s" />',
		esc_attr( $client_id )
	);
}

/**
 * Show the API Key field.
 */
function fishrules_apikey_field() {
	$api_key = get_option( 'fishrules_apikey' );
	printf(
		'<input type="text" id="fishrules_apikey" name="fishrules_apikey" value="%s" />',
		esc_attr( $api_key )
	);
}

/**
 * Show the Fishery Council section intro.
 */
function fishrules_council_info() {
	?>
	<p>This setting ensures the regulations are for this council's waters.</p>
	<?php
}

/**
 * Show the Fishery Council field.
 */
function fishrules_council_field() {
	$council = get_option( 'fishrules_council' ) ?? false;
	?>
	<select id="fishrules_council" name="fishrules_council">
		<option value="caribbean" <?php selected( $council, 'caribbean' ); ?>>Caribbean</option>
		<option value="gulf" <?php selected( $council, 'gulf' ); ?>>Gulf of Mexico</option>
		<option value="mid-atlantic" <?php selected( $council, 'mid-atlantic' ); ?>>Mid-Atlantic</option>
		<option value="new-england" <?php selected( $council, 'new-england' ); ?>>New England</option>
		<option value="north-pacific" <?php selected( $council, 'north-pacific' ); ?>>North Pacific</option>
		<option value="pacific" <?php selected( $council, 'pacific' ); ?>>Pacific</option>
		<option value="south-atlantic" <?php selected( $council, 'south-atlantic' ); ?>>South Atlantic</option>
		<option value="western-pacific" <?php selected( $council, 'western-pacific' ); ?>>Western Pacific</option>
	</select>
	<?php
}

/**
 * Show Locations section intro.
 */
function locations_info() {
	?>
	<p>These locations will be used to pull regulations for all species.</p>
	<button type="button" class="add" data-field="locations">Add a Location</button>
	<?php
}

/**
 * Show Regions section intro.
 */
function regions_info() {
	?>
	<p>These locations will be used only for the assigned species.</p>
	<button type="button" class="add" data-field="regions">Add a Region</button>
	<?php
}

/**
 * Show the All Regulations section intro.
 */
function fishrules_allregs_info() {
	?>
	<p>These settings affect what is displayed in the All Regulations block.</p>
	<p>If anything is entered as "Open* Text", this text will display in the Season column if the species is subject to a total quota that has not yet been closed.</p>
	<?php
}

/**
 * Show the Hide Location option field.
 */
function fishrules_location_field() {
	$option = get_option( 'fishrules_hideloc' );
	echo '<input type="checkbox" id="fishrules_hideloc" name="fishrules_hideloc" ' . checked( 'on', $option, false ) . ' />';
}

/**
 * Show the Open option field.
 */
function fishrules_open_field() {
	$option = get_option( 'fishrules_open' );
	printf(
		'<input type="text" id="fishrules_open" name="fishrules_open" value="%s" />',
		esc_attr( $option )
	);
}

/**
 * Get the settings option array and display all the current values.
 *
 * @param array $args The options array.
 */
function combined_callback( $args ) {
	$optname   = $args['optname'];
	$fieldnum  = $args['fieldnum'];
	$fieldkey  = $args['fieldkey'];
	$fieldname = $optname . "[$fieldnum][$fieldkey]";
	$options   = get_option( $optname );
	printf(
		'<input type="text" id="%s" name="%s" value="%s" />',
		$fieldname,
		$fieldname,
		isset( $options[ "$fieldnum" ][ "$fieldkey" ] ) ? esc_attr( $options[ "$fieldnum" ][ "$fieldkey" ] ) : ''
	);
	if ( 'name' === $fieldkey ) {
		$label = 'Location';
		$field = 'fishrules_locations[' . $fieldnum . ']';
		if ( 'fishrules_regions' === $optname ) {
			$label = 'Region';
			$field = 'fishrules_regions[' . $fieldnum . ']';
		}
		?>
		<button type="button" class="remove" data-field="<?php echo esc_attr( $field ); ?>">Remove <?php echo esc_attr( $label . ' ' . ( $fieldnum + 1 ) ); ?></button>
		<?php
	}
}

/**
 * Sanitize credential input.
 *
 * @param string $input the input being sanitized.
 */
function sanitize_credential( $input ) {
	$sanitized = sanitize_text_field( $input );
	return $sanitized;
}

/**
 * Call the API functions via AJAX.
 */
function api_refresh() {
	check_ajax_referer( 'ajax-api-nonce' );
	if ( isset( $_POST['type'] ) ) {
		if ( 'comregs' === $_POST['type'] ) {
			\FishRulesAPIIntegration\Sync\import_commercial();
			echo 'Commercial regulations updated.';
		} elseif ( 'recregs' === $_POST['type'] ) {
			\FishRulesAPIIntegration\Sync\import_recreational();
			echo 'Recreational regulations updated.';
		} elseif ( 'species' === $_POST['type'] ) {
			\FishRulesAPIIntegration\Sync\import_species();
			echo 'Species updated.';
		}
		wp_die();
	}
}

/**
 * When locations are updated, keep the com_open, com_closed,
 * rec_open, and rec_closed terms up to date.
 *
 * @param array $old_values The option's value before the update.
 * @param array $new_values The option's value after the update.
 */
function sync_location_terms( $old_values, $new_values ) {
	// Do nothing if the option didn't change.
	if ( $old_values === $new_values ) {
		return;
	}

	// Find out what changed.
	$changed           = compare_arrays( $old_values, $new_values );
	$season_taxonomies = array(
		'rec_open',
		'rec_closed',
	);

	// Remove locations that were in old values, but not in new values.
	if ( count( $changed['first'] ) > 0 ) {
		// Loop through each old location.
		foreach ( $changed['first'] as $removed ) {
			// Remove the location from both taxonomies - `rec_open` and `rec_closed`.
			foreach ( $season_taxonomies as $season_taxonomy ) {
				// Find the term ID with a slug matching the old value's location name.
				$term = get_term_by( 'slug', strtolower( $removed['name'] ), $season_taxonomy );
				wp_delete_term( $term->term_id, $season_taxonomy );
			}
		}
	}

	// Add locations that are in new values, but were not in old values.
	if ( count( $changed['second'] ) > 0 ) {
		// Loop through each new location.
		foreach ( $changed['second'] as $added ) {
			// Add the location to both taxonomies - `rec_open` and `rec_closed`.
			foreach ( $season_taxonomies as $season_taxonomy ) {
				wp_insert_term( strtoupper( $added['name'] ), $season_taxonomy );
			}
		}
	}

	// Update locations that are present but different in old and new values.
	if ( count( $changed['different'] ) > 0 ) {
		// Loop through each old location.
		foreach ( $changed['different'] as $changed ) {
			// Update the location in both taxonomies - `rec_open` and `rec_closed`.
			foreach ( $season_taxonomies as $season_taxonomy ) {
				// Find the term ID with a slug matching the old value's location name.
				$term = get_term_by( 'slug', strtolower( $changed['name'] ), $season_taxonomy );
				wp_update_term( $term->term_id, $season_taxonomy );
			}
		}
	}
}

/**
 * Compare two multidimensional arrays.
 *
 * @param array $array1 The first array to compare.
 * @param array $array2 The second array to compare.
 * @return array $results A multidimensional array:
 *              $results['first'] Items that are in array1 but not array2.
 *              $results['second'] Items that are in array2 but not array1.
 *              $results['different'] Items that differ between array1 and array2.
 */
function compare_arrays( $array1, $array2 ) {
	$result = array(
		'first'     => array(),
		'second'    => array(),
		'different' => array(),
	);
	foreach ( $array1 as $k => $v ) {
		if ( is_array( $v ) && isset( $array2[ $k ] ) && is_array( $array2[ $k ] ) ) {
			$sub_result = compare_arrays( $v, $array2[ $k ] );
			foreach ( array_keys( $sub_result ) as $key ) {
				if ( ! empty( $sub_result[ $key ] ) ) {
					$result[ $key ] = array_merge_recursive( $result[ $key ], array( $k => $sub_result[ $key ] ) );
				}
			}
		} else {
			if ( isset( $array2[ $k ] ) ) {
				if ( $v !== $array2[ $k ] ) {
					$result['different'][ $k ] = array(
						'from' => $v,
						'to'   => $array2[ $k ],
					);
				}
			} else {
				$result['first'][ $k ] = $v;
			}
		}
	}
	foreach ( $array2 as $k => $v ) {
		if ( ! isset( $array1[ $k ] ) ) {
			$result['second'][ $k ] = $v;
		}
	}
	return $result;
}
