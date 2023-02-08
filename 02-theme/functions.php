<?php
/**
 * StMU Parent functions
 *
 * @package WordPress
 */

/**
 * Save subdomain as an option.
 */
function stmu_set_subdomain() {
	$siteurl = site_url();
	if ( substr( $siteurl, 8, 3 ) == 'www' || substr( $siteurl, 7, 6 ) == 's28507' || substr( $siteurl, 7, 6 ) == 's29372' ) {
		// WWW-Production or WWW-Staging or Policy-staging get "www".
		$subdomain = 'www';
	} elseif ( substr( $siteurl, 8, 10 ) == 'law.alumni' ) {
		// Law Alumni gets "law.alumni".
		$subdomain = 'law.alumni';
	} elseif ( substr( $siteurl, 8, 3 ) == 'law' || substr( $siteurl, 7, 6 ) == 's28508' ) {
		// Law-Production or Law-Staging gets "law".
		$subdomain = 'law';
	} elseif ( substr( $siteurl, 8, 6 ) == 'alumni' ) {
		// Main Alumni gets "alumni".
		$subdomain = 'alumni';
	} else {
		// Other gets "other".
		$subdomain = 'other';
	}
	update_option( 'stmu_subdomain', $subdomain, 'no' );
}
add_action( 'after_switch_theme', 'stmu_set_subdomain' );
$subdomain = get_option( 'stmu_subdomain' );
/**
 * Prefetch resources for site speed.
 *
 * @param     array  $hints An array of domains to prefetch.
 * @param     string $relation_type Prefetch.
 */
function stmu_resource_hints( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		if ( substr( $siteurl, 8, 3 ) == 'www' ) {
			$hints[] = '//cdn.stmarytx.edu/';
			$hints[] = '//apply.stmarytx.edu/';
		}
		$hints[] = '//s.swiftypecdn.com/';
		$hints[] = '//cc.swiftypecdn.com/';
		$hints[] = '//www.googletagmanager.com/';
		$hints[] = '//www.google-analytics.com/';
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'stmu_resource_hints', 10, 2 );
/**
 * Preload font css to speed loading of key resources.
 */
add_filter( 'wp_head', 'stmu_preload_webfonts' );
function stmu_preload_webfonts() {
	echo '<link rel="preload" href="/wp-content/themes/stmu-parent/fonts/mukta-mahee-v2-latin-regular.woff2" as="font" crossorigin>';
	echo '<link rel="preload" href="/wp-content/themes/stmu-parent/fonts/font-awesome-4.min.css" as="style">';
}
/**
 * Block Editor: disable colors and gradients, and force all editor font sizes to 21px "normal".
 */
function stmu_remove_custom_colors() {
	// Disable color palette.
	add_theme_support( 'editor-color-palette' );
	add_theme_support( 'disable-custom-colors' );
	// Disable gradients.
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'editor-gradient-presets', array() );
	// Remove a text box where users can enter custom pixel sizes.
	add_theme_support( 'disable-custom-font-sizes' );
	// Remove the font size dropdown.
	add_theme_support( 'editor-font-sizes' );
}
add_action( 'after_setup_theme', 'stmu_remove_custom_colors' );
/**
 * Block Editor: filter on front end - add wrapper divs around every block.
 */
add_filter(
	'render_block',
	function( $block_content, $block ) {
		// If the block has at least one tag - Core seems to process hard returns between blocks as extra blocks if this check isn't in place.
		// (also, exclude Core Button, Core Column, our Bordered Box, our Program Locations, and our Related Pages from getting extra divs.
		if ( stripos( $block_content, '<' ) != false && 'core/button' != $block['blockName'] && 'core/column' != $block['blockName'] && 'stmu/bordered-box-item' != $block['blockName'] && 'stmu/program-locations' != $block['blockName'] && 'stmu/related-pages' != $block['blockName'] ) {
			$block_content = sprintf( '<div class="stmu-single-block"><div class="max-width">%s</div></div>', $block_content );
		}
		return $block_content;
	},
	10,
	2
);
/**
 * Block Editor: add Page Template body class for ghostweave stripes, and adjust Core block Styles.
 */
function stmu_block_enqueues() {
	$version = filemtime( get_template_directory() . '/editor.js' );
	wp_enqueue_script( 'stmu-parent-block-editor', get_template_directory_uri() . '/editor.js', array( 'wp-edit-post', 'wp-blocks', 'wp-dom-ready', 'jquery' ), $version, true );
}
add_action( 'enqueue_block_editor_assets', 'stmu_block_enqueues' );
// query optimization
if($subdomain == 'www' || $subdomain == 'law' || $subdomain == 'alumni' || $subdomain == 'law.alumni') {
	add_action('pre_get_posts', 'stmu_modify_queries');
	function stmu_modify_queries($query) {
		// replace main query on homepage - it used to query all posts' wp_terms and wp_postmeta for no reason
		if($query->is_main_query() && !is_admin() && $query->is_home()) {
			$query->set('posts_per_page', '3');	// only get 3 posts
			$query->query_vars['cat'] = 1;				// only from News category
		// replace main query on faculty archive
		} elseif($query->is_main_query() && !is_admin() && $query->is_post_type_archive('faculty')) {
			$meta_query = array(
				array(
					'key' => 'faculty_type',
					'value' => 'faculty',
					'compare' => '=',
				)
			);
			$query->set('meta_query',$meta_query);
			$query->set('posts_per_page', 500);				// don't limit the number displayed
			$query->set('meta_key', 'faculty_last');		// grab last name
			$query->set('order', 'ASC');					// start at beginning of alphabet
			$query->set('orderby', 'meta_value');			// order by last name
		} elseif($query->is_main_query() && !is_admin() && $query->is_post_type_archive('center')) {
			$query->set('posts_per_page', 500);				// don't limit the number displayed
			$query->set('post_parent', 0);					// only get top-level centers, not children
			$query->set('orderby', 'title');				// order by title
			$query->set('order', 'asc');					// ascending
			$query->set('post_parent', 0);					// only get top-level, not children
		// law 'profile' order by title not date
		} elseif($query->is_main_query() && !is_admin() && ($query->is_post_type_archive('aprofile') || $query->is_post_type_archive('sprofile'))) {
			$query->set('orderby', 'title');				// order by title
			$query->set('order', 'asc');					// ascending
		// school homepages - prevent /page/#/ urls
		} elseif($query->is_main_query() && !is_admin() && ($query->is_post_type_archive('business') || $query->is_post_type_archive('humanities') || $query->is_post_type_archive('set'))) {
			$query->set('paged', 'false');
		// exclude "announcements" category from recent posts widget
		} elseif($subdomain == 'www' && !is_admin()) {
			$excluded = array(188);
			$wp_query->set('category__not_in', $excluded);
		}
	}
}
// force rss feeds to update more often - every hour
add_filter('wp_feed_cache_transient_lifetime', create_function('$a', 'return 3600;'));
// remove header links
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
// remove Yoast site search link
add_filter( 'wpseo_json_ld_output', '__return_false' );
// enqueue files
add_action('wp_enqueue_scripts', 'stmu_enqueues');
function stmu_enqueues() {
	global $subdomain;
	$version = filemtime(get_template_directory() . '/style.css');
	wp_enqueue_style('stmu-parent', get_template_directory_uri() . '/style.css', array(), "$version", 'screen');
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/jquery-2.2.2.min.js', false);
	$version = filemtime(get_template_directory() . '/scripts.min.js');
	wp_enqueue_script('stmu-scripts', get_template_directory_uri() . '/scripts.min.js', array('jquery'), "$version", true);
	wp_add_inline_script('stmu-scripts', '	jQuery(".gallery-icon a").swipebox();
	jQuery(".blocks-gallery-item a").swipebox({ loopAtEnd: true });');
	// Employee Directory: only 1 www page
	if ( 'www' == $subdomain && is_page( 'employees' ) ) {
		wp_enqueue_script( 'stmu-dir-data', plugins_url( '/stmu-www/employee-list.js' ), array( 'jquery' ), '2.0' );
		wp_enqueue_script( 'stmu-dir-functions', plugins_url( '/stmu-www/employee-dir.js' ), array( 'jquery', 'stmu-dir-data' ), '2.0' );
	}
	// Swiftype - everywhere except explore & discover
	if ( 'other' != $subdomain ) {
		// Part 1: include the universally required js
		wp_add_inline_script('stmu-scripts', "	(function(w,d,t,u,n,s,e){w['SwiftypeObject']=n;w[n]=w[n]||function(){
			(w[n].q=w[n].q||[]).push(arguments);};s=d.createElement(t);
			e=d.getElementsByTagName(t)[0];s.async=1;s.src=u;e.parentNode.insertBefore(s,e);
		})(window,document,'script','//s.swiftypecdn.com/install/v2/st.js','_st');"
		);
		// Part 2: identify which engine(s) to use
		if ( 'www' == $subdomain && is_page( 'programs' ) ) {
			// Program search
			wp_add_inline_script('stmu-scripts',
				"	(function($) {
			$(document).ready(function(){
				_st('install','xTxbyUaoBzaWdR_g62Cs','2.0.0', {
					install: {
						web: {
						ui: {
							search: {
							results_display: {
								disable_anchor_hash_params: true
							},
							query_composer: {
								disable_anchor_hash_params: true
							}
							}
						}
						}
					}
				});
			})
		})(jQuery);"
			);
		} elseif ( 'www' == $subdomain && is_category( array( 'news', 'magazine' ) ) ) {
			// Post search
			wp_add_inline_script('stmu-scripts',
				"	(function($) {
			$(document).ready(function(){
				_st('install','HRGTzKaHX_Z-1ZZPwusc','2.0.0', {
					install: {
						web: {
						ui: {
							search: {
							results_display: {
								disable_anchor_hash_params: true
							},
							query_composer: {
								disable_anchor_hash_params: true
							}
							}
						}
						}
					}
				});
			})
		})(jQuery);"
			);
		}
		// Part 2: Main search everywhere
		wp_add_inline_script('stmu-scripts', "	_st('install','xr6FS4Lto2zJTUiQFbm7','2.0.0');");
	}
	// YouVisit: only 3 www pages
	if( 'www' == $subdomain && is_page( array( 'admission', 'graduate-admission', 'visit-campus' ) ) ) {
		wp_enqueue_script( 'youvisit', 'https://www.youvisit.com/tour/Embed/js3', array( 'jquery' ), '1.0');
	}
}
// Force YouVisit to include "async" and "defer" attributes
add_filter( 'script_loader_tag', 'stmu_async_youvisit', 10, 3 );
function stmu_async_youvisit( $tag, $handle, $src ) {
	if ( 'youvisit' === $handle ) {
		if ( false === stripos( $tag, 'async' ) ) {
			$tag = str_replace(' src', ' async="async" src', $tag);
		}
		if ( false === stripos( $tag, 'defer' ) ) {
			$tag = str_replace('<script ', '<script defer ', $tag);
		}
	}
	return $tag;
}
// dequeue files
add_action('wp_print_styles', 'stmu_dequeue_plugin_css');
function stmu_dequeue_plugin_css() {
	wp_dequeue_style('authorizer-public-css');
	wp_deregister_style('authorizer-public-css');
}
add_action('wp_print_scripts', 'stmu_dequeue_plugin_js');
function stmu_dequeue_plugin_js() {
	if($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
		wp_dequeue_script('auth_public_scripts');
	}
}
// enqueue admin - WP Help override
add_action('admin_head', 'override_wp_help');
function override_wp_help() {
	echo '<style>
		#cws-wp-help-document { max-width:none; }
	</style>';
}
// enqueue admin - theme-specific Block Editor styles
add_action('enqueue_block_editor_assets', 'stmu_editor_styles');
function stmu_editor_styles() {
	$version = filemtime(get_template_directory() . '/editor.css');
	wp_enqueue_style('stmu-parent-editor', get_template_directory_uri() . '/editor.css', array('wp-edit-blocks'), "$version");
}
// enqueue admin - force media editor to default to "link to none"
add_action('load-post.php', 'stmu_media_popup_init');
add_action('load-post-new.php', 'stmu_media_popup_init');
function stmu_media_popup_init() {
	global $post;
	if($post && $post->post_type) {
		if(post_type_supports($post->post_type, 'thumbnail') != false) {
			wp_enqueue_script('stmu_media_popup_init', get_template_directory_uri() . '/media.js', array('media-editor'));
		}
	}
}
// disable emojis	
remove_action('wp_head', 'print_emoji_detection_script', 7);	
remove_action('wp_print_styles', 'print_emoji_styles');
// add theme support
add_action('after_setup_theme', 'stmu_add_theme_support');
function stmu_add_theme_support() {
	add_theme_support('title-tag');
	add_theme_support('menus');
	// featured images
	add_theme_support('post-thumbnails', array('post', 'page', 'abroad', 'aprofile', 'business', 'center', 'department', 'employee', 'faculty', 'hall', 'humanities', 'program', 'set', 'specialprogram', 'sprofile'));
	add_theme_support('custom-logo', array('width' => 340));
	add_theme_support('automatic-feed-links');
	add_theme_support('yoast-seo-breadcrumbs');
}
// Add featured images to REST API
add_action('rest_api_init', 'register_rest_images' );
function register_rest_images(){
	// This is the "thumbnail" size featured image, for the MyStMU App.
    register_rest_field( array('post'),
        'fimg_url',
        array(
            'get_callback'    => 'get_rest_featured_image_thumb',
            'update_callback' => null,
            'schema'          => null,
        )
    );
	// This is the "spotlight" (300x300) size featured image, for the REST API (law homepage & alumni homepage).
	register_rest_field( array('post'),
		'fimg_300_url',
		array(
			'get_callback'	=> 'get_rest_featured_image',
			'update_callback' => null,
			'schema'		=> null
		)
	);
}
function get_rest_featured_image_thumb( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'thumbnail' );
        return $img[0];
    }
    return false;
}
function get_rest_featured_image( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'spotlight' );
        return $img[0];
    }
    return false;
}
// Gravity Forms disable tabindex
add_filter('gform_tabindex', function($tabindex, $form) {
	return false;
}, 10, 2);
// Gravity Forms disable IP address everywhere except alumni sites, relies on line 32 to already have the subdomain option loaded as a variable
if($subdomain != 'alumni' && $subdomain != 'law.alumni') {
	add_filter( 'gform_ip_address', '__return_empty_string' );
}
// Gravity Forms - force email contact form's honeypot to be labeled "cell"
add_filter( 'gform_honeypot_labels_pre_render', function ( $honeypot_labels ) {
    return array( 'Cell', 'Cell', 'Cell', 'Cell' );
});
// Gravity Forms - email contact form
add_action('gform_after_submission_131', 'stmu_email_through_flow', 10, 2);
function stmu_email_through_flow($entry) {

	// set fields to post as an array
	$fields['firstName'] = $entry['1.3'];
	$fields['lastName'] = $entry['1.6'];
	$fields['email'] = $entry['2'];
	$fields['subject'] = $entry['3'];
	$fields['message'] = $entry['4'];
	$fields['id'] = $entry['5'];
	$fields = json_encode($fields);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://prod-12.westus.logic.azure.com/workflows/7546d38ecb2a4964947d4e6b144eaf2a/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=60QBHLZtvvzY5IIZhS9861vjq0ulBvKADljoPxMd75c",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $fields,
		CURLOPT_HTTPHEADER => array(
		"Content-Type: application/json",
		"Postman-Token: 0c66ee52-a426-440f-ac5c-7f8c26a5ee23",
		"cache-control: no-cache",
		"secret: Dtp=Nvp9rb#R&SvV!TDnq#+FfjVQrsc7"
		),
	));
	$response = curl_exec($curl);	
	$err = curl_error($curl);
	
	// delete entry from GF (after the request is sent to Flow)
	GFAPI::delete_entry($entry['id']);
	
}
// content width
if(!isset($content_width)) { $content_width = 1170; }
// strip itemprop from logo
add_filter('get_custom_logo', 'stmu_remove_logo_itemprop');
function stmu_remove_logo_itemprop() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'custom-logo',
            ) )
        );
    return $html;   
}
if($subdomain == 'www' || $subdomain == 'law') {
	add_image_size('program', 200, 200, array('center', 'center'));
	add_image_size('spotlight', 300, 300, array('center', 'center')); // This is no longer used for "spotlights". It was in use for so many other things it was unwise to change this size.
	add_image_size('large-square', 600, 600, array('center', 'center')); // This is the new "spotlight" size.
	add_image_size('horizontal', 450, 300, array('center', 'center'));
	add_image_size('vertical', 300, 450, array('center', 'center'));
	// Make the horizontal and vertical sizes available when adding an image from the Media Library
	add_filter('image_size_names_choose', 'stmu_media_sizes');
	function stmu_media_sizes($sizes) {
		return array_merge($sizes, array(
			'horizontal' => 'Horizontal',
			'vertical' => 'Vertical'
		));
	}
}
// add menus
add_action('init', 'stmu_menus');
if($subdomain == 'www') {
	function stmu_menus() {
		register_nav_menus(
		[
			'topnav'	=> __('Topnav', 'stmu-parent'),
			'business-nav'	=> __('GSB Navigation', 'stmu-parent'),
			'humanities-nav'=> __('HSS Navigation', 'stmu-parent'),
			'set-nav'		=> __('SET Navigation', 'stmu-parent'),
			'footer'		=> __('Footer', 'stmu-parent')
		]
		);
	}
} else {
	function stmu_menus() {
		register_nav_menus(
		[
			'topnav'	=> __('Topnav', 'stmu-parent'),
			'footer'		=> __('Footer', 'stmu-parent')
		]
		);
	}
}
// topnav walker - still needed for School nav menus
class stmuTopnavWalker extends Walker_Nav_Menu {
	// This affects all LI levels.
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		// Add "top-level" class to top level LIs
		if($depth == 0) {
			$output .= sprintf("\n<li class='top-level'><a href='%s'>%s</a>\n", $item->url, $item->title);
		} else {
			if (array_search('menu-item-has-children', $item->classes)) {
				$output .= sprintf("\n<li class='%s'><a href='%s'>%s</a>\n", ( array_search('current-menu-item', $item->classes) || array_search('current-page-parent', $item->classes) ) ? 'active' : '', $item->url, $item->title
				);
			} else {
				$output .= sprintf("\n<li><a href='%s'>%s</a>\n", $item->url, $item->title);
			}
		}
	}
}
// childnav walker
class childNav_walker extends Walker_page {
	public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {
		$post_type = get_query_var( 'post_type' );
		if($depth)
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';
		extract($args, EXTR_SKIP);
		$css_class = array('page_item');
		if(!empty($current_page)) {
			$_current_page = get_page( $current_page );
			
			$children = get_children('post_type='.$post_type.'&post_status=publish&post_parent='.$page->ID);
			if(count($children) != 0) {
				$css_class[] = 'page_item_has_children';
			}
			if(isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors))
				$css_class[] = 'current_page_ancestor';
			if($page->ID == $current_page)
				$css_class[] = 'current_page_item';
			elseif($_current_page && $page->ID == $_current_page->post_parent)
				$css_class[] = 'current_page_parent';
		} elseif($page->ID == get_option('page_for_posts')) {
			$css_class[] = 'current_page_parent';
		}
		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
		$output .= $indent .'<li class="' . $css_class . '"><a href="' . get_permalink($page->ID) . '">' . $page->post_title .'</a>';
    }
}
// button walker
class stmuButtonWalker extends Walker_Nav_Menu {
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$output .= sprintf("\n<a class=\"ghost-btn\" href='%s'>%s</a>\n", $item->url, $item->title);
	}
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= '';
	}
}
// don't make links rel="noopener noreferrer"
add_filter('tiny_mce_before_init','tinymce_allow_unsafe_link_target');
function tinymce_allow_unsafe_link_target( $mceInit ) {
	$mceInit['allow_unsafe_link_target']=true;
	return $mceInit;
}
// restrict file uploads to the Media Library
add_filter('upload_mimes','stmu_limit_mimes');
function stmu_limit_mimes($mimes) {
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png' => 'image/png',
		'pdf' => 'application/pdf',
		'mp4' => 'video/mp4'
	);
	return $mimes;
}
// shuffle for WP_Query: grab X random posts from original query, allowing us to get X random spotlights from the Y latest
add_filter('the_posts', function($posts, \WP_Query $query) {
	if( $pick = $query->get( '_shuffle_and_pick' ) ) {
		shuffle($posts);
		$posts = array_slice($posts, 0, (int) $pick);
	}
	return $posts;
}, 10, 2);
// featured images on back end
function stmu_add_thumb_column($columns) {
	unset($columns['comments']);
	unset($columns['restricted']);
	unset($columns['objroles']);
	return array_merge($columns, array('post_thumbnail_column' => 'Image'));
}
function stmu_display_thumb_column($column, $post_id) {
	if($column == 'post_thumbnail_column') {
		if(has_post_thumbnail()) {
			the_post_thumbnail('thumbnail');
		}
	}
}
add_filter('wpseo_use_page_analysis', '__return_false');
add_filter('manage_business_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_business_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
add_filter('manage_center_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_center_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
add_filter('manage_humanities_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_humanities_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
add_filter('manage_page_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_page_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
add_filter('manage_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
add_filter('manage_program_posts_columns' , 'stmu_add_thumb_column', 9);
add_action('manage_program_posts_custom_column' , 'stmu_display_thumb_column', 9, 2);
add_filter('manage_set_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_set_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
add_filter('manage_specialprogram_posts_columns' , 'stmu_add_thumb_column', 10);
add_action('manage_specialprogram_posts_custom_column' , 'stmu_display_thumb_column', 10, 2);
// more link in automatic excerpt & manual excerpt
add_filter('excerpt_more', 'stmu_excerpt_more');
function stmu_excerpt_more($more) {
	global $post;
	return ' ...';
}
// shorten excerpt
add_filter('excerpt_length', 'stmu_excerpt_length');
function stmu_excerpt_length($length) {
	return 37;
}
// add clearfix class to excerpt p
add_filter('the_excerpt', 'stmu_excerpt_class');
function stmu_excerpt_class($excerpt) {
	$excerpt = str_replace('<p', '<p class="clearfix"', $excerpt);
	return $excerpt;
}
// remove 'category' from h1s in category archives
add_filter('get_the_archive_title', function($title) {
	if(is_category()) {
		$title = single_cat_title('', false);
	} elseif(is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	}
	return $title;
});
// move Yoast to bottom on edit screen
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
// ACF fallback
if(!class_exists('acf')) {
	function have_rows() { return false; }
	function get_field() { return false; }
	function the_field() { return false; }
	function get_sub_field() { return false; }
	function the_sub_field() { return false; }
}
// WWW and LAW-specific
if($subdomain == 'www' || $subdomain == 'law') {
	// hide author on AMP posts
	add_filter( 'amp_post_article_header_meta', 'stmu_hide_amp_author' );
	function stmu_hide_amp_author( $parts ) {
		// Remove author from the header meta parts array
		unset( $parts[array_search( 'meta-author', $parts )] );
		return $parts;
	}
	// autogenerate meta descriptions for single "faculty" and single "department"
	add_filter('wpseo_metadesc', 'stmu_add_missing_metas', 100, 1);
	function stmu_add_missing_metas($metadesc) {
		if(is_singular('faculty') && empty($metadesc)) {
			$metadesc = get_field('faculty_staff_bio');
		} elseif(is_singular('department') && empty($metadesc)) {
			$rows = get_field('department_information_repeater');
			$first_row = $rows[0];
			$metadesc = $first_row['department_information_content'];
		}
		// trim the descripton to 150 characters, then trim any partial words off
		$metadesc = strip_tags($metadesc);
		if(strlen($metadesc) > 150) {
			$metadesc = substr($metadesc, 0, 150);
			$metadesc = substr($metadesc, 0, strripos($metadesc, " "));
			$metadesc = trim(preg_replace( '/\s+/', ' ', $metadesc));
		}
		// always return the value whether we changed it or not
		return $metadesc;
	}
	// Event title trimming for homepage
	function trimTitle($eventTitle) {	
		if(strlen($eventTitle) > 70) {	
			$eventTitle = substr($eventTitle, 0, 50);	
			$eventTitle = substr($eventTitle, 0, strripos($eventTitle, " "));	
			$eventTitle = trim(preg_replace( '/\s+/', ' ', $eventTitle));	
		}	
		return $eventTitle;	
	}
}
// sidebars
if (function_exists('register_sidebar')) {
    register_sidebar(array(
            'name'          => 'Footer Left',
            'id'            => 'footer-left',
            'description'   => '',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>'
	));
    register_sidebar(array(
            'name'          => 'Footer Right',
            'id'            => 'footer-right',
            'description'   => '',
            'before_widget' => '<div class="footer-widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>'
	));
    register_sidebar(array(
            'name'          => 'Post Sidebar',
            'id'            => 'blog-sidebar',
            'description'   => 'Sidebar for News and Spotlights',
            'before_widget' => '<div class="sidebar-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="sidebar-widget-title">',
            'after_title'   => '</h3>'
	));
	if($subdomain == 'www') {
		register_sidebar(array(
				'name'          => 'Internal News',
				'id'            => 'in-news-sidebar',
				'description'   => 'Sidebar for the News Category',
				'before_widget' => '<div class="sidebar-widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="sidebar-widget-title">',
				'after_title'   => '</h3>'
		));
		register_sidebar(array(
				'name'          => 'External News',
				'id'            => 'ext-news-sidebar',
				'description'   => 'Sidebar for the In The Media Page',
				'before_widget' => '<div class="sidebar-widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="sidebar-widget-title">',
				'after_title'   => '</h3>'
		));
		register_sidebar(array(
				'name'          => 'Spotlight Archive',
				'id'            => 'spotlight-sidebar',
				'description'   => 'Sidebar for the Spotlight Category',
				'before_widget' => '<div class="sidebar-widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="sidebar-widget-title">',
				'after_title'   => '</h3>'
		));
	}
	if($subdomain == 'www' || $subdomain == 'law') {
		register_sidebar(array(
				'name'          => 'Default Sidebar',
				'id'            => 'default-sidebar',
				'description'   => 'Default Sidebar',
				'before_widget' => '<div class="sidebar-widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="sidebar-widget-title">',
				'after_title'   => '</h3>'
		));	
	}
}
// school filter widget, meant for News Archive sidebar
add_action('widgets_init', create_function('', 'return register_widget("schoolNews_widget");'));
class schoolNews_widget extends WP_Widget {
	// register widget
	function __construct() {
		parent::__construct(
			'schoolNews_widget',
			'News by School'
		);
	}
	// front end display
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget; echo $before_title . $title . $after_title;
		$schools = get_terms('school');
		echo '<ul>';
		foreach($schools as $school) {
			echo '<li><a href="/category/news/?school=' . $school->slug . '">' . $school->name . '</a></li>';
		}
		echo '</ul>';
		echo $after_widget;
	}
	// back end display
	public function form($instance) {
		$title = esc_attr($instance['title']); ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stmu-parent'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<?php 
	}
	// save settings
	public function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}
// social sharing button widget, meant for single.php
add_action('widgets_init', create_function('', 'return register_widget("socialShare_widget");'));
class socialShare_widget extends WP_Widget {
	// register widget
	function __construct() {
		parent::__construct(
			'socialShare_widget',
			'Social Share Buttons'
		);
	}
	// front end display
	public function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		$postTitle = urlencode(get_the_title());
			$postURL = urlencode(get_the_permalink());
			$postSummary = urlencode(get_the_excerpt());
			if(has_post_thumbnail()) {
				$thumbnailId = get_post_thumbnail_id();
				$thumbnailObject = get_post($thumbnailId);
				$postImage = $thumbnailObject->guid;
			} else {
				$postContent = get_the_content();
				preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $postContent, $imageMatches);
				$postImage = $imageMatches[1][0];
				if(empty($postImage)) {
					if(has_custom_logo()) {
						$postImage = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'large');
					} else {
						$postImage = '/wp-content/themes/stmu-parent/images/plain-logo-white.png';
					}
				}
			}
		?>
		<a href="https://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo $postURL; ?>&p[images][0]=<?php echo $postImage; ?>&p[title]=<?php echo $postTitle; ?>&p[summary]=<?php echo $postSummary; ?>" class="socialLink socialFb" id="Facebook">Facebook</a>
		<a href="https://twitter.com/intent/tweet?text=<?php echo $postTitle; ?>&url=<?php echo $postURL; ?>" class="socialLink socialTw" id="Twitter">Twitter</a>
		<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $postURL; ?>&title=<?php echo $postTitle; ?>&summary=<?php echo $postSummary; ?>" class="socialLink socialLi" id="LinkedIn">LinkedIn</a>
		<?php echo $after_widget; ?>
		<?php
	}
	// back end display
	public function form($instance) {
		$title = esc_attr($instance['title']); ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stmu-parent'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<?php 
	}
	// save settings
	public function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}
// prevent non-Admins from accessing Menu admin on www and law
add_action('admin_menu', 'stmu_lock_menus');
function stmu_lock_menus() {
	global $user_ID;
	global $subdomain;
	if(!current_user_can('administrator') && ($subdomain == 'www' || $subdomain == 'law')) {
		remove_submenu_page('themes.php', 'nav-menus.php');
	}
}
/////////////////////////////////////////////// AJAX Filter Search ////////////////////////////////////////////////
function stmu_post_filter_function() {
	if(isset($_POST['posttype'])) {
		$tax_query = array('relation' => 'AND');
		if($_POST['posttype'] == 'hall') {
			// hall-class
			if(isset($_POST['hall-class'])) {
				$tax_query[] = array(
					'taxonomy'	=> 'hall-class',
					'field'		=> 'slug',
					'terms'		=> $_POST['hall-class'],
					'operator'	=> 'IN'
				);
			}
			// hall-theme
			if(isset($_POST['hall-theme'])) {
				$tax_query[] = array(
					'taxonomy'	=> 'hall-theme',
					'field'		=> 'slug',
					'terms'		=> $_POST['hall-theme'],
					'operator'	=> 'IN'
				);
			}
			// hall-price
			if(isset($_POST['hall-price'])) {
				$tax_query[] = array(
					'taxonomy'	=> 'hall-price',
					'field'		=> 'slug',
					'terms'		=> $_POST['hall-price'],
					'operator'	=> 'IN'
				);
			}
			// hall-layout
			if(isset($_POST['hall-layout'])) {
				$tax_query[] = array(
					'taxonomy'	=> 'hall-layout',
					'field'		=> 'slug',
					'terms'		=> $_POST['hall-layout'],
					'operator'	=> 'IN'
				);
			}
		}
	}
	$args = array(
		'post_type' => $_POST['posttype'],
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'title',
	);
	if(!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}
	$query = new WP_Query($args);
	if($query->have_posts()) {
		$i=1;
		while($query->have_posts()): $query->the_post();
			if(has_post_thumbnail($query->post->ID)) {
				$image = get_the_post_thumbnail_url( $_post->ID, 'large' );
			} else {
				// fallback image
				$image = 'https://lorempixel.com/400/300/';
			}
			// picture and title as a link
			echo '<a href="' . get_permalink($query->post->ID) . '" aria-label="Show details" class="open-dialog" style="background-image:url(' . $image . ');"><div class="overlay">' . $query->post->post_title . '</div></a>';
			$i++;
		endwhile;
		wp_reset_postdata();
	} else {
		echo 'Sorry, there are no results. Try searching with fewer filters to see more results.';
	}
	die();
}
add_action('wp_ajax_stmu_search_filter', 'stmu_post_filter_function'); 
add_action('wp_ajax_nopriv_stmu_search_filter', 'stmu_post_filter_function');
// ID - add to each <hX> tag in the_content (if they don't already have one)
add_filter('the_content', 'stmu_add_heading_ids');
add_filter('acf_the_content', 'stmu_add_heading_ids');
add_filter('the_field', 'stmu_add_heading_ids');
add_filter('the_sub_field', 'stmu_add_heading_ids');
function stmu_add_heading_ids($content) {
	$content = preg_replace_callback('/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function($matches) {
		// only add ID if there isn't one already
		if(!stripos($matches[0], 'id=')) {
			// strip tags, force lowercase
			$new_id = strtolower(sanitize_title($matches[3]));
			// replace spaces with hyphens
			$new_id = str_replace(array(' ',), '-', $new_id);
			// remove quotes, commas, periods, parenthesis
			$new_id = str_replace(array("'", '"', '.', ',', '(', ')'), '', $new_id);
			$matches[0] = $matches[1] . $matches[2] . ' id="' . $new_id . '">' . $matches[3] . $matches[4];
		}
		return $matches[0];
	}, $content);
	// return the whole heading, not just the ID
	return $content;
}
// ID - use in templates
function stmu_manually_add_heading_id($heading) {
	// strip tags, force lowercase
	$heading = strtolower(sanitize_title($heading));
	// replace spaces with hyphens
	$heading = str_replace(array(' ',), '-', $heading);
	// remove quotes, commas, periods, parenthesis
	$heading = str_replace(array("'", '"', '.', ',', '(', ')'), '', $heading);
	// return just the ID, not the whole heading
	return $heading;
}
?>