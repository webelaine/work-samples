<?php
/**
 * Handle the server-side registration of the block.
 *
 * @package fish-rules-api-integration
 */

namespace FishRulesAPIIntegrationpyPrime\Blocks\AllRegulations;

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
	$reg_type       = empty( $attributes['type'] ) ? 'recreational' : $attributes['type'];
	$hide_locations = get_option( 'fishrules_hideloc', 'off' );
	$output         = '<div ' . get_block_wrapper_attributes() . '>';
	if ( 'recreational' === $reg_type ) {
		if ( true === $attributes['details'] ) {

			// Recreational table top.
			$output .= '<table>';
			$output .= '<thead><tr>
				<th scope="col">Species</th>';
			if ( 'on' !== $hide_locations ) {
				$output .= '
				<th scope="col">Location</th>';
			}
			$output .= '
				<th scope="col">Season</th>
				<th scope="col">Size</th>
				<th scope="col">Bag Limit</th>
				<th scope="col">Aggregate</th>
			</tr></thead>';

			// Get all aggregate terms.
			$aggregates = get_terms(
				array(
					'taxonomy' => 'aggregate',
					'fields'   => 'ids',
					'orderby'  => 'name',
					'order'    => 'ASC',
				)
			);

			// Display each aggregate group of species.
			foreach ( $aggregates as $aggregate ) {
				// Get all published Species.
				$args = array(
					'no_found_rows'  => true,
					'post_type'      => 'fish_species',
					'posts_per_page' => -1,
					'orderby'        => 'post_title',
					'order'          => 'ASC',

					// Make sure the species do not have "hide_table" meta set to true.
					'meta_query'     => array(
						'relation' => 'OR',
						array(
							'key'   => 'hide_table',
							'value' => false,
							'type'  => 'BOOLEAN',
						),
						array(
							'key'     => 'hide_table',
							'compare' => 'NOT EXISTS',
						),
					),

					// Only get species in the current aggregate.
					'tax_query'      => array(
						array(
							'taxonomy' => 'aggregate',
							'field'    => 'id',
							'terms'    => $aggregate,
						),
					),
				);

				$background = get_term_meta( $aggregate, 'aggregate_color', true );
				$species    = new \WP_Query( $args );
				if ( $species->have_posts() ) {
					while ( $species->have_posts() ) {
						$species->the_post();
						$post_id = get_the_ID();

						if ( true === $attributes['details'] ) {
							$output .= render_species_row( $post_id, $reg_type, $background, $hide_locations );
						} else {
							$output .= render_species_card( $post_id, $reg_type );
						}
					}
				}
				wp_reset_postdata();
			}

			// Get all published Species that are not assigned to any aggregate term.
			$args = array(
				'no_found_rows'  => true,
				'post_type'      => 'fish_species',
				'posts_per_page' => -1,
				'orderby'        => 'post_title',
				'order'          => 'ASC',

				// Make sure the species do not have "hide_table" meta set to true.
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'   => 'hide_table',
						'value' => false,
						'type'  => 'BOOLEAN',
					),
					array(
						'key'     => 'hide_table',
						'compare' => 'NOT EXISTS',
					),
				),

				// Specify no aggregate.
				'tax_query'      => array(
					array(
						'taxonomy' => 'aggregate',
						'field'    => 'term_id',
						'terms'    => get_terms(
							array(
								'taxonomy' => 'aggregate',
								'fields'   => 'ids',
							)
						),
						'operator' => 'NOT IN',
					),
				),
			);

			$species = new \WP_Query( $args );
			if ( $species->have_posts() ) {
				while ( $species->have_posts() ) {
					$species->the_post();
					$post_id = get_the_ID();

					if ( true === $attributes['details'] ) {
						$output .= render_species_row( $post_id, $reg_type );
					} else {
						$output .= render_species_card( $post_id, $reg_type );
					}
				}
			}
			wp_reset_postdata();

			// Recreational table bottom.
			$output .= '</table>';
		} else {
			// Render as cards, in alphabetical order, ignoring aggregates.
			// Get all published Species.
			$args = array(
				'no_found_rows'  => true,
				'post_type'      => 'fish_species',
				'posts_per_page' => -1,
				'orderby'        => 'post_title',
				'order'          => 'ASC',

				// Make sure the species do not have "hide_table" meta set to true.
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'   => 'hide_table',
						'value' => false,
						'type'  => 'BOOLEAN',
					),
					array(
						'key'     => 'hide_table',
						'compare' => 'NOT EXISTS',
					),
				),
			);

			$species = new \WP_Query( $args );
			if ( $species->have_posts() ) {
				while ( $species->have_posts() ) {
					$species->the_post();
					$post_id = get_the_ID();
					$output .= render_species_card( $post_id, $reg_type );
				}
			}
			wp_reset_postdata();
		}
	} else {
		// Commercial table top.
		if ( true === $attributes['details'] ) {
			$output .= '<table>';
			$output .= '<thead><tr>
				<th scope="col">Species</th>
				<th scope="col">Permit</th>
				<th scope="col">Season</th>
				<th scope="col">Quota</th>
				<th scope="col">Size</th>
				<th scope="col">Trip Limit</th>
			</tr></thead>';
		}

		// Get all published Species.
		$args = array(
			'no_found_rows'  => true,
			'post_type'      => 'fish_species',
			'posts_per_page' => -1,
			'orderby'        => 'post_title',
			'order'          => 'ASC',

			// Make sure the species do not have "hide_table" meta set to true.
			'meta_query'     => array(
				'relation' => 'OR',
				array(
					'key'   => 'hide_table',
					'value' => false,
					'type'  => 'BOOLEAN',
				),
				array(
					'key'     => 'hide_table',
					'compare' => 'NOT EXISTS',
				),
			),
		);

		$species = new \WP_Query( $args );
		if ( $species->have_posts() ) {
			while ( $species->have_posts() ) {
				$species->the_post();
				$post_id = get_the_ID();
				if ( true === $attributes['details'] ) {
					$output .= render_species_row( $post_id, $reg_type );
				} else {
					$output .= render_species_card( $post_id, $reg_type );
				}
			}
		}
		wp_reset_postdata();

		// Commercial table bottom.
		if ( true === $attributes['details'] ) {
			$output .= '</table>';
		}
	}

	// Close the outer block wrapper div.
	$output .= '</div>';
	return $output;
}

/**
 * Display species as a card.
 *
 * @param int    $post_id    The WordPress species post ID.
 * @param string $reg_type   Commercial or Recreational.
 * @param string $background Optional hexadecimal background color.
 *
 * @return string HTML to display.
 */
function render_species_card( $post_id, $reg_type, $background = '' ) {
	$synonyms = \FishRulesAPIIntegration\Species\get_synonyms( $post_id );
	$synonyms = implode( ', ', $synonyms );

	$area_statuses      = \FishRulesAPIIntegration\Species\get_area_statuses( $post_id );
	$split_recreational = '' !== $area_statuses['closed_recreational'] && '' !== $area_statuses['open_recreational'];
	$split_commercial   = '' !== $area_statuses['closed_commercial'] && '' !== $area_statuses['open_commercial'];

	$card_class  = 'species-card';
	$card_class .= $split_recreational ? ' split-recreational-season-status' : '';
	$card_class .= $split_commercial ? ' split-commercial-season-status' : '';

	ob_start();
	?>
	<div class="<?php echo esc_attr( $card_class ); ?>">
	<?php if ( has_post_thumbnail( $post_id ) ) { ?>
		<figure class="post-thumbnail">
			<a href="<?php the_permalink( $post_id ); ?>">
				<img src="<?php the_post_thumbnail_url( $post_id ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" />
			</a>
		</figure>
	<?php } ?>

	<div class="card-content">
		<a href="<?php the_permalink( $post_id ); ?>">
			<h2 class="species-name"><?php echo esc_html( get_the_title( $post_id ) ); ?></h2>
		</a>
		<span class="also-known-as"><?php echo esc_html( $synonyms ); ?></span>
	</div>
	<?php

	\FishRulesAPIIntegration\Species\display_seasonal_statuses( $post_id );

	$output = ob_get_clean();
	return $output;
}

/**
 * Display species as a table row.
 *
 * @param int    $post_id    The WordPress species post ID.
 * @param string $reg_type   commercial || recreational.
 * @param string $background Optional hexadecimal background color.
 * @param string $hide_locations Whether to remove location column data.
 *
 * @return string HTML to display.
 */
function render_species_row( $post_id, $reg_type, $background = '', $hide_locations = 'off' ) {

	// Start the output buffer.
	ob_start();

	// Apply background color selected in the Aggregate taxonomy term add/edit screen, if applicable.
	if ( ! empty( $background ) ) {
		echo '<tr bgcolor="#' . esc_attr( $background ) . '">';
	} else {
		echo '<tr>';
	}

	// Get regulations and open/closed status for each area (recreational) or permit (commercial).
	$count = 0;
	if ( 'recreational' === $reg_type ) {
		// Recreational regulations.
		$regulations = get_post_meta( $post_id, 'rec_regs', true );

		// Loop through regulations.
		foreach ( $regulations as $regulation ) {
			if ( 0 === $count ) {
				?>
				<td rowspan="<?php echo count( $regulations ); ?>">
					<a href="<?php the_permalink( $post_id ); ?>">
						<?php if ( has_post_thumbnail() ) { ?>
							<figure class="post-thumbnail">
								<img src="<?php the_post_thumbnail_url( $post_id ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" />
							</figure>
						<?php } ?>
						<?php echo esc_html( get_the_title( $post_id ) ); ?>
					</a>
				</td>
				<?php
			}
			$count++;

			// Display locations unless the "hide locations" option is checked.
			if ( 'on' !== $hide_locations ) {
				?>
				<td><?php echo esc_html( implode( ', ', $regulation['locations'] ) ); ?></td>
				<?php
			}

			?>
			<td>
				<?php // Show season status icon. ?>
				<div class="species-current">
					<?php
					if ( has_term( array_pop( $regulation['locations'] ), 'rec_open', $post_id ) ) {
						?>
						<span class="season-open"></span>
						<?php
					} else {
						?>
						<span class="season-closed"></span>
						<?php
					}
					?>
				</div>

				<?php
				// If we have season dates, display them.
				if ( count( $regulation['details']->seasons ) > 0 ) {
					foreach ( $regulation['details']->seasons as $season ) {
						if ( ! empty( $season->starts_at->date ) ) {
							echo '<p class="species_season season_closed">Season Closed: ' . esc_html( date_format( date_create( $season->starts_at->date ), 'F d, Y' ) ) . ' - ' . esc_html( date_format( date_create( $season->ends_at->date ), 'F d, Y' ) ) . '</p>';
						}
					}
				} else {
					echo '<p class="species_season season_open">Open</p>';
				}
				?>
			</td>
			<td>
				<?php
				if ( ! empty( $regulation['details']->min_size ) ) {
					echo esc_html( $regulation['details']->min_size ) . ' ' . esc_html( $regulation['details']->measurement_unit ) . ' ' . esc_html( $regulation['details']->measurement_abbreviation );
				}
				?>
			</td>
			<td><?php echo esc_html( $regulation['details']->bag_limit ); ?></td>
			<td>
				<?php
				if ( ! empty( esc_html( $regulation['details']->aggregate_limit ) ) ) {
					echo esc_html( $regulation['details']->aggregate_limit ) . ' ' . esc_html( $regulation['details']->aggregate_name ) . ' combined total';
				}
				?>
			</td>
			</tr>
			<?php
		}
	} else {
		// Commercial regulations.
		$regulations = get_post_meta( $post_id, 'com_regs', true );

		// Loop through regulations.
		$count = 0;
		foreach ( $regulations as $regulation ) {
			if ( 0 === $count ) {
				?>
				<td rowspan="<?php echo count( $regulations ); ?>">
					<a href="<?php the_permalink( $post_id ); ?>">
						<?php if ( has_post_thumbnail() ) { ?>
							<figure class="post-thumbnail">
								<img src="<?php the_post_thumbnail_url( $post_id ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" />
							</figure>
						<?php } ?>
						<?php echo esc_html( get_the_title( $post_id ) ); ?>
					</a>
				</td>
				<?php
			}
			$count++;
			?>
			<td><?php echo esc_html( $regulation['heading'] ); ?></td>
			<td>
				<?php // Show season status icon. ?>
				<div class="species-current">
					<?php
					if ( has_term( array_pop( $regulation['locations'] ), 'com_open', $post_id ) ) {
						?>
						<span class="season-open"></span>
						<?php
					} else {
						?>
						<span class="season-closed"></span>
						<?php
					}
					?>
				</div>

				<?php
				// If we have season dates, display them.
				if ( count( $regulation['details']->seasons ) > 0 ) {
					foreach ( $regulation['details']->seasons as $season ) {
						if ( ! empty( $season->starts_at ) ) {
							echo '<p class="species_season season_closed">Season Closed: ' . esc_html( date_format( date_create( $season->starts_at ), 'F d, Y' ) ) . ' - ' . esc_html( date_format( date_create( $season->ends_at ), 'F d, Y' ) ) . '</p>';
						}
					}
				} else {
					$custom_open_text = get_option( 'fishrules_open', '' );
					if ( ! empty( $custom_open_text ) && ( ! empty( $regulation['details']->quota_limit ) ) ) {
						// If custom text is specified, and this species has a quota, display the custom text.
						echo '<p class="species_season season_open">' . esc_html( $custom_open_text ) . '</p>';
					} else {
						// Otherwise, just display Open.
						echo '<p class="species_season season_open">Open</p>';
					}
				}
				?>
			</td>
			<td>
				<?php
				if ( ! empty( $regulation['details']->quota_limit ) ) {
					echo esc_html( $regulation['details']->quota_limit ) . ' ' . esc_html( $regulation['details']->quota_measurement_abbreviation ) . '<br/>' . esc_html( $regulation['details']->quota_harvested ) . '% harvested';
				}
				?>
			</td>
			<td>
				<?php
				if ( ! empty( $regulation['details']->min_size ) ) {
					echo esc_html( $regulation['details']->min_size ) . ' ' . esc_html( $regulation['details']->size_measurement_unit ) . ' ' . esc_html( $regulation['details']->size_measurement_abbreviation );
				}
				?>
			</td>
			<td>
				<?php
				if ( ! empty( $regulation['details']->trip_limit ) ) {
					echo esc_html( $regulation['details']->trip_limit ) . ' ' . esc_html( $regulation['details']->trip_measurement_unit ) . ' ' . esc_html( $regulation['details']->trip_measurement_abbreviation );
				}
				?>
			</td>
			</tr>
			<?php
		}
	}

	// Return everything we just output.
	$output = ob_get_clean();
	return $output;
}
