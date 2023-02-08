<?php
/**
 * Create the Species custom post type and its taxonomies.
 *
 * @package fish-rules-api-integration
 */

namespace FishRulesAPIIntegration\Species;

add_action( 'init', __NAMESPACE__ . '\register_post_type' );
add_action( 'init', __NAMESPACE__ . '\register_meta' );
add_action( 'init', __NAMESPACE__ . '\register_taxonomies' );
add_action( 'aggregate_add_form_fields', __NAMESPACE__ . '\add_aggregate_fields' );
add_action( 'aggregate_edit_form_fields', __NAMESPACE__ . '\add_aggregate_fields' );
add_action( 'created_aggregate', __NAMESPACE__ . '\save_aggregate_fields' );
add_action( 'edited_aggregate', __NAMESPACE__ . '\save_aggregate_fields' );
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );

/**
 * Register a post type for Species.
 */
function register_post_type() {
	$icon = file_get_contents( plugin_dir_path( __FILE__ ) . '/../assets/fish.svg' );

	$labels = array(
		'name'               => 'Fish Species',
		'singular_name'      => 'Fish Species',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Fish Species',
		'edit_item'          => 'Edit Fish Species',
		'new_item'           => 'New Fish Species',
		'all_items'          => 'All Fish Species',
		'view_item'          => 'View Fish Species',
		'search_items'       => 'Search Fish Species',
		'not_found'          => 'No fish species found',
		'not_found_in_trash' => 'No fish species found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Fish Species',
	);
	$args   = array(
		'labels'          => $labels,
		'public'          => true,
		'rewrite'         => array(
			'slug'       => 'species',
			'with_front' => false,
		),
		'capability_type' => 'post',
		'has_archive'     => false,
		'hierarchical'    => false,
		'menu_position'   => 29,
		'supports'        => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'show_in_rest'    => true,
		'rest_base'       => 'species',
		'menu_icon'          => 'data:image/svg+xml;base64,' . base64_encode( $icon ), // PHPCS:ignore WordPress
	);
	\register_post_type( 'fish_species', $args );
}

/**
 * Register postmeta fields for Species.
 */
function register_meta() {
	// Fish Rules ID.
	register_post_meta(
		'fish_species',
		'fish_rules_id',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'absint',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'number',
		),
	);

	// Fish Edibility.
	register_post_meta(
		'fish_species',
		'fish_edibility',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
		),
	);

	// Fish Shape.
	register_post_meta(
		'fish_species',
		'fish_shape',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
		),
	);

	// Fish Species Report.
	register_post_meta(
		'fish_species',
		'fish_species_report',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'absint',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'number',
		),
	);

	// Fish Synonyms.
	register_post_meta(
		'fish_species',
		'fish_synonyms',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_or_array_field',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'array',
		),
	);

	// Commercial Regulations.
	register_post_meta(
		'fish_species',
		'com_regs',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_or_array_field',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'array',
		),
	);

	// Recreational Regulations.
	register_post_meta(
		'fish_species',
		'rec_regs',
		array(
			'auth_callback'     => function() {
				return current_user_can( 'edit_posts' );
			},
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_or_array_field',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'array',
		),
	);

	// Hide Table: if true, excludes the species from displaying in the All Regulations block.
	register_post_meta(
		'fish_species',
		'hide_table',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'boolean',
			'default'      => false,
		),
	);
}

/**
 * Register custom taxonomies for Species.
 */
function register_taxonomies() {
	// Recreational Open: holds location abbreviations for all areas where this species' season is open.
	$args = array(
		'hierarchical'      => false,
		'label'             => 'Rec Open',
		'public'            => true,
		'query_var'         => 'rec-open',
		'rewrite'           => false,
		'show_admin_column' => true,
		'show_in_menu'      => false,
		'show_in_rest'      => true,
		'show_ui'           => false,
	);
	\register_taxonomy( 'rec_open', 'fish_species', $args );

	// Recreational Closed: holds location abbreviations for all areas where this species' season is closed.
	$args = array(
		'hierarchical'      => false,
		'label'             => 'Rec Closed',
		'public'            => true,
		'query_var'         => 'rec-closed',
		'rewrite'           => false,
		'show_admin_column' => true,
		'show_in_menu'      => false,
		'show_in_rest'      => true,
		'show_ui'           => false,
	);
	\register_taxonomy( 'rec_closed', 'fish_species', $args );

	// Commercial Open: holds location abbreviations for all areas where this species' season is open.
	$args = array(
		'hierarchical'      => false,
		'label'             => 'Com Open',
		'public'            => true,
		'query_var'         => 'com-open',
		'rewrite'           => false,
		'show_admin_column' => true,
		'show_in_menu'      => false,
		'show_in_rest'      => true,
		'show_ui'           => false,
	);
	\register_taxonomy( 'com_open', 'fish_species', $args );

	// Commercial Closed: holds location abbreviations for all areas where this species' season is closed.
	$args = array(
		'hierarchical'      => false,
		'label'             => 'Com Closed',
		'public'            => true,
		'query_var'         => 'com-closed',
		'rewrite'           => false,
		'show_admin_column' => true,
		'show_in_menu'      => false,
		'show_in_rest'      => true,
		'show_ui'           => false,
	);
	\register_taxonomy( 'com_closed', 'fish_species', $args );

	// Aggregate: groups species that share a limit.
	$args = array(
		'hierarchical'      => false,
		'label'             => 'Aggregates',
		'public'            => true,
		'query_var'         => 'aggregate',
		'rewrite'           => false,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	);
	\register_taxonomy( 'aggregate', 'fish_species', $args );
}

/**
 * Add custom fields to Aggregate terms.
 *
 * @param object $term The term object.
 */
function add_aggregate_fields( $term ) {
	if ( is_object( $term ) ) {
		$aggregate_color = get_term_meta( $term->term_id, 'aggregate_color', true );
	} else {
		$aggregate_color = 0;
	}
	?>
		<div class="form-field">
			<?php wp_nonce_field( 'save_aggregate_meta', 'aggregate_meta' ); ?>
			<label for="aggregate_color">Background color</label>
			<select name="aggregate_color" id="aggregate_color" class="postform" aria-describedby="color-description">
				<option value="0" <?php selected( $aggregate_color, '0' ); ?>>None</option>
				<option value="bee" <?php selected( $aggregate_color, 'bee' ); ?>>Cyan 1</option>
				<option value="dff" <?php selected( $aggregate_color, 'dff' ); ?>>Cyan 2</option>
				<option value="def" <?php selected( $aggregate_color, 'def' ); ?>>Blue 1</option>
				<option value="cde" <?php selected( $aggregate_color, 'cde' ); ?>>Blue 2</option>
			</select>
			<p id="color-description">The background color used to visually group this aggregate.</p>
		</div>
	<?php
}

/**
 * Save Aggregate term custom fields.
 *
 * @param int $term_id The term ID.
 */
function save_aggregate_fields( $term_id ) {
	if ( ! isset( $_POST['aggregate_meta'] ) || ! wp_verify_nonce( $_POST['aggregate_meta'], 'save_aggregate_meta' ) ) {
		return;
	}

	update_term_meta(
		$term_id,
		'aggregate_color',
		sanitize_text_field( $_POST['aggregate_color'] ),
	);
}

/**
 * Retrieve a list of synonyms for a given species.
 *
 * @param int $post_id The WordPress ID of the species.
 * @return string[] A list of synonyms.
 */
function get_synonyms( $post_id ) {
	$synonyms = get_post_meta( $post_id, 'fish_synonyms', true );

	if ( ! $synonyms ) {
		return array();
	}

	return $synonyms;
}

/**
 * Retrieve a list of areas and statuses for a given fish species.
 *
 * @param int $post_id The fish species ID.
 * @return array A list of statuses.
 */
function get_area_statuses( $post_id ) {
	$open_recreational_areas   = wp_get_object_terms( $post_id, 'rec_open', array( 'fields' => 'names' ) );
	$closed_recreational_areas = wp_get_object_terms( $post_id, 'rec_closed', array( 'fields' => 'names' ) );
	$open_commercial_areas     = wp_get_object_terms( $post_id, 'com_open', array( 'fields' => 'names' ) );
	$closed_commercial_areas   = wp_get_object_terms( $post_id, 'com_closed', array( 'fields' => 'names' ) );

	$open_recreational_areas = implode( ', ', $open_recreational_areas );

	$closed_recreational_areas = implode( ', ', $closed_recreational_areas );

	$open_commercial_areas = implode( ', ', $open_commercial_areas );

	$closed_commercial_areas = implode( ', ', $closed_commercial_areas );

	return array(
		'open_recreational'   => $open_recreational_areas,
		'closed_recreational' => $closed_recreational_areas,
		'open_commercial'     => $open_commercial_areas,
		'closed_commercial'   => $closed_commercial_areas,
	);
}

/**
 * Display recreational and commercial season statuses for a given fish species.
 *
 * @param int     $post_id The fish species ID.
 * @param boolean $labels Whether or not to display Recreational and Commercial labels.
 */
function display_seasonal_statuses( $post_id, $labels = false ) {
	$area_statuses = get_area_statuses( $post_id );
	?>

	<div class="season-status recreational-season-status">
		<?php
		if ( true === $labels ) {
			echo '<span class="season-type">Recreational</span>';
		}
		?>
		<div class="open-closed-wrap">
			<?php
			if ( '' !== $area_statuses['closed_recreational'] && '' !== $area_statuses['open_recreational'] ) {
				// A mix of states with open/closed status, show the split.
				?>
				<span class="season-closed"><?php echo esc_html( $area_statuses['closed_recreational'] ); ?></span>
				<span class="season-open"><?php echo esc_html( $area_statuses['open_recreational'] ); ?></span>
				<?php
			} elseif ( '' === $area_statuses['closed_recreational'] ) {
				?>
				<span class="season-open"><span class="screen-reader-text">All areas are open for recreational fishing.</span></span>
				<?php
			} elseif ( '' === $area_statuses['open_recreational'] ) {
				?>
				<span class="season-closed"><span class="screen-reader-text">All areas are closed for recreational fishing.</span></span>
				<?php
			}
			?>
		</div>
	</div>

	<div class="season-status commercial-season-status">
		<?php
		if ( true === $labels ) {
			echo '<span class="season-type">Commercial</span>';
		}
		?>
		<div class="open-closed-wrap">
			<?php
			if ( '' !== $area_statuses['closed_commercial'] && '' !== $area_statuses['open_commercial'] ) {
				// A mix of states with open/closed status, show the split.
				?>
				<span class="season-closed"></span>
				<span class="season-open"></span>
				<span class="mixed-permits">Check permits</span>
				<?php
			} elseif ( '' === $area_statuses['closed_commercial'] ) {
				?>
				<span class="season-open"><span class="screen-reader-text">All areas are open for commercial fishing.</span></span>
				<?php
			} elseif ( '' === $area_statuses['open_commercial'] ) {
				?>
				<span class="season-closed"><span class="screen-reader-text">All areas are closed for commercial fishing.</span></span>
				<?php
			}
			?>
		</div>
	</div>

	<?php
}

/**
 * Enqueue assets for the block editor.
 */
function enqueue_block_editor_assets() {
	if ( 'fish_species' === get_current_screen()->id ) {
		$asset_data = require_once dirname( __DIR__ ) . '/build/exclude-species.asset.php';

		wp_enqueue_script(
			'exclude-species',
			plugins_url( '/build/exclude-species.js', __DIR__ ),
			$asset_data['dependencies'],
			$asset_data['version'],
			true
		);
	}
}
