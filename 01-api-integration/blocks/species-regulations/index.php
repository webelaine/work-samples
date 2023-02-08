<?php
/**
 * Handle the server-side registration of the block.
 *
 * @package fish-rules-api-integration
 */

namespace FishRulesAPIIntegration\Blocks\SpeciesRegulations;

add_action( 'init', __NAMESPACE__ . '\register' );

/**
 * Register the block on the server.
 */
function register() {
	register_block_type_from_metadata(
		__DIR__,
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);
}

/**
 * Filter attribute content for display while allowing some
 * HTML tags from the upstream API.
 *
 * @param string $content Content to display.
 * @param string $heading Heading to prepend, if any.
 * @return string Filtered content.
 */
function filter_for_display( $content, $heading = '' ) {
	if ( '' !== $heading ) {
		$content = $heading . ': ' . $content;
	}

	$content = wpautop( $content );
	$content = wp_kses(
		$content,
		array(
			'a'      => array(
				'href' => true,
			),
			'b'      => array(),
			'li'     => array(),
			'ul'     => array(),
			'ol'     => array(),
			'p'      => array(),
			'strong' => array(),
		)
	);

	return $content;
}

/**
 * Render the block in PHP.
 *
 * @param array $attributes The block attributes.
 *
 * @return string HTML
 */
function render( $attributes ) {
	// Use the specified species CPT, or fall back to the current post.
	if ( $attributes['species'] && $attributes['species'] > 0 ) {
		$post = get_post( $attributes['species'] );
	} else {
		$post = get_post();
	}

	$reg_type = empty( $attributes['type'] ) ? 'recreational' : $attributes['type'];
	$output   = '<div ' . get_block_wrapper_attributes() . '>';

	if ( 'recreational' === $reg_type ) {
		$regulations = get_post_meta( $post->ID, 'rec_regs', true );

		if ( $regulations ) {
			foreach ( $regulations as $regulation ) {
				// Groups of regulations.
				$output .= '<h3>' . esc_html( implode( ', ', $regulation['locations'] ) ) . '</h3>';
				$output .= '<ul class="rec-regs">';

				$size_measurement = esc_html( $regulation['details']->measurement_unit . ' ' . $regulation['details']->measurement_name );

				// Use the first location in this regulation to determine if the season is open or closed.
				if ( has_term( array_pop( $regulation['locations'] ), 'rec_open', $post ) ) {
					$output .= '<li class="species_current"><span class="season-open"></span>Season is currently open.</li>';
				} else {
					$output .= '<li class="species_current"><span class="season-closed"></span>Season is currently closed.</li>';
				}

				// If we have season data, display it.
				if ( count( $regulation['details']->seasons ) > 0 ) {
					foreach ( $regulation['details']->seasons as $season ) {
						if ( ! empty( $season->starts_at->date ) ) {
							$output .= '<li class="species_season">Season Closed: ' . date_format( date_create( $season->starts_at->date ), 'F d, Y' ) . ' - ' . date_format( date_create( $season->ends_at->date ), 'F d, Y' ) . '</li>';
						}
					}
				}

				foreach ( $regulation['details'] as $key => $value ) {
					// Individual regulations.
					if ( ! empty( $value ) ) {
						if ( 'bag_limit' === $key ) {
							$output .= '<li class="bag_limit"><span class="value">' . esc_html( $value ) . '</span> Bag Limit</li>';
						} elseif ( 'aggregate_limit' === $key ) {
							$output .= '<li class="agg_limit"><span class="value">' . esc_html( $value ) . '</span> Aggregate Limit</li>';
						} elseif ( 'vessel_limit' === $key ) {
							$output .= '<li class="ves_limit"><span class="value">' . esc_html( $value ) . '</span> Vessel Limit</li>';
						} elseif ( 'trophy_limit' === $key && $value > 0 ) {
							$output .= '<li class="tro_limit"><span class="value">' . esc_html( $value ) . ' > ' . esc_html( $regulation['details']->trophy_size ) . '</span> Trophy Limit</li>';
						} elseif ( 'min_size' === $key ) {
							$output .= '<li class="min_size">Min. Size: ' . esc_html( $value ) . " $size_measurement</li>";
						} elseif ( 'max_size' === $key ) {
							$output .= '<li class="max_size">Max. Size: ' . esc_html( $value ) . " $size_measurement</li>";
						} elseif ( 'additional_licenses_required' === $key ) {
							$output .= '<li class="licenses">Additional Licenses Required: ' . esc_html( $value ) . '</li>';
						} elseif ( 'gear_description' === $key ) {
							$output .= '<li class="gear">' . filter_for_display( $value, 'Gear Description' ) . '</li>';
						} elseif ( 'notes' === $key ) {
							$output .= '<li class="notes">' . filter_for_display( $value, 'Notes' ) . '</li>';
						}
					}
				}
				$output .= '</ul>';
			}
		} else {
			// If no regulations were found, display a fallback message.
			$output .= '<p>' . __( 'No recreational regulations were found.', 'fish-rules-api-integration' ) . '</p>';
		}
	} elseif ( 'commercial' === $reg_type ) {
		// Check this council for unregulated species.
		$council     = get_option( 'fishrules_council' ) ?? false;
		$unregulated = array();
		if ( 'south-atlantic' === $council ) {
			$unregulated = array( '406', '407', '1009', '1103', '1204', '1301', '1302' );
		}

		// Display commercial regulations.
		$regulations  = get_post_meta( $post->ID, 'com_regs', true );
		$fishrules_id = get_post_meta( $post->ID, 'fish_rules_id', true );
		if ( $regulations ) {
			foreach ( $regulations as $regulation ) {
				// Groups of regulations.
				$output .= '<h3>' . esc_html( $regulation['heading'] ) . '</h3>';
				$output .= '<ul class="com-regs">';

				$size_measurement = esc_html( $regulation['details']->size_measurement_unit . ' ' . $regulation['details']->size_measurement_name );
				$trip_measurement = esc_html( $regulation['details']->trip_measurement_unit . ' ' . $regulation['details']->trip_measurement_name );
				$quota_details    = esc_html( $regulation['details']->quota_limit . ' ' . $regulation['details']->quota_measurement_unit . ' ' . $regulation['details']->quota_measurement_name ) . '<br/>' . $regulation['details']->quota_harvested . '% harvested';
				// Display whether the current permit is open or closed.
				if ( has_term( $regulation['heading'], 'com_open', $post ) ) {
					$output .= '<li class="species_current"><span class="season-open"></span>Season is currently open.</li>';
				} else {
					$output .= '<li class="species_current"><span class="season-closed"></span>Season is currently closed.</li>';
				}
				// If we have season data, display it.
				if ( count( $regulation['details']->seasons ) > 0 ) {
					foreach ( $regulation['details']->seasons as $season ) {
						if ( ! empty( $season->starts_at ) ) {
							$output .= '<li class="species_season">Season Closed: ' . date_format( date_create( $season->starts_at ), 'F d, Y' ) . ' - ' . date_format( date_create( $season->ends_at ), 'F d, Y' ) . '</li>';
						}
					}
				}
				foreach ( $regulation['details'] as $key => $value ) {
					// Individual Regulations.
					if ( ! empty( $value ) ) {
						if ( 'fishing_year' === $key ) {
							$output .= '<li class="fishing_year">Fishing Year: ' . esc_html( $value ) . '</li>';
						} elseif ( 'min_size' === $key ) {
							$output .= '<li class="min_size">Min. Size: ' . esc_html( $value ) . " $size_measurement</li>";
						} elseif ( 'max_size' === $key ) {
							$output .= '<li class="max_size">Max. Size: ' . esc_html( $value ) . " $size_measurement</li>";
						} elseif ( 'trip_limit' === $key ) {
							$output .= '<li class="trip_limit"><span class="value">' . esc_html( $value ) . "</span> $trip_measurement Trip Limit</li>";
						} elseif ( 'quota_type' === $key ) {
							$output .= '<li class="quota_limit">Quota: ' . esc_html( $value ) . "- $quota_details</li>";
						} elseif ( 'quota_individual_description' === $key ) {
							$output .= '<li class="individual_quota_limit">Individual Quota: ' . esc_html( wp_strip_all_tags( $value ) ) . '</li>';
						} elseif ( 'notes' === $key ) {
							$output .= '<li class="notes">' . filter_for_display( $value, 'Notes' ) . '</li>';
						}
					}
				}
				$output .= '</ul>';
				// If Areas are present, output them.
				if ( count( $regulation['areas'] ) > 0 ) {
					$output .= '<div class="wp-block-happyprime-show-hide-group"><details id="com-areas" class="wp-block-happyprime-show-hide-section">';
					$output .= '<summary><h4>Areas</h4></summary>';
					foreach ( $regulation['areas'] as $key => $array ) {
						// Individual Areas.
						if ( ! empty( $array['description'] ) ) {
							$output .= '<details><summary>' . esc_html( $array['name'] ) . '</summary>';
							$output .= '<p class="com-area">' . esc_html( wp_strip_all_tags( $array['description'] ) ) . '</p></details>';
						}
					}
					$output .= '</details></div>';
				}
				// If Conditions are present, output them.
				if ( count( $regulation['conditions'] ) > 0 ) {
					$output .= '<h4>Conditions</h4>';
					foreach ( $regulations['conditions'] as $key => $array ) {
						// Individual Conditions.
						if ( ! empty( $array['description'] ) ) {
							$output .= '<details><summary>' . esc_html( $array['name'] ) . '</summary>';
							$output .= '<p class="com-condition">' . esc_html( wp_strip_all_tags( $array['description'] ) ) . '</p></details>';
						}
					}
				}
			}
		} elseif ( in_array( $fishrules_id, $unregulated, true ) ) {
			// Some species aren't regulated, but the fishery monitors them. Check by Fish Rules ID, not WP Post ID.
			$output .= '<p>' . __( 'Ecosystem Component species are species that do not require conservation and management under a federal fishery management plan, but are included in order to achieve ecosystem management objectives.', 'fish-rules-api-integration' ) . '</p>';
		} else {
			// If this isn't an Ecosystem Component species, and there are no regs, display a fallback message.
			$output .= '<p>' . __( 'No commercial regulations were found.', 'fish-rules-api-integration' ) . '</p>';
		}
	}

	$output .= '</div>';
	return $output;
}
