<?php
/*
Plugin Name: StMU Blocks
Description: Adds custom StMU blocks: Accessible Table, Bordered Boxes, Child Pages, Drawer, Faculty (Contact, Departments, Info, Programs), Featured Image, Finder, Icon Heading, Master Calendar, Person, Program Info (with children Degrees, Departments, Directors, Locations), Related Pages, Related Posts, Residence Halls, School Departments, School Faculty, School Programs, and Stat.
*/
add_action('init', 'stmu_register_blocks');
function stmu_register_blocks() {
	wp_register_script(
		'stmu-blocks',
		plugins_url('/build/index.js', __FILE__),
		array('wp-blocks', 'wp-components', 'wp-element', 'wp-editor'),
		filemtime( plugin_dir_path( __FILE__ ) . '/build/index.js' )
	);
	wp_register_style(
		'stmu-blocks-style',
		plugins_url('/build/front.css', __FILE__),
		array('wp-block-library'),
		filemtime( plugin_dir_path( __FILE__ ) . '/build/front.css' )
	);
	wp_register_style(
		'stmu-blocks-edit-style',
		plugins_url('/build/editor.css', __FILE__),
		array('wp-edit-blocks')
	);
	register_block_type('stmu/a11y-table', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/bordered-boxes', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/bordered-box-item', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'attributes' => array(
			'alignment' => array(
				'type' => 'string',
				'default' => 'left'
			)
		)
	));
	register_block_type('stmu/child-pages', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_child_pages'
	));
	register_block_type('stmu/donut-chart', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/drawer', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/faculty-contact', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'attributes' => array(
			'email' => array(
				'type' => 'string',
				'default' => '@stmarytx.edu'
			),
			'phone' => array(
				'type' => 'string',
				'default' => 'N/A'
			)
		)
	));
	register_block_type('stmu/faculty-departments', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_faculty_departments'
	));
	register_block_type('stmu/faculty-info', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/faculty-programs', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_faculty_programs'
	));
	register_block_type('stmu/featured-image', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_featured_image'
	));
	register_block_type('stmu/finder', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_finder',
		'attributes' => array(
			'editMode' => array(
				'type' => 'boolean',
				'default' => true
			),
			'postType' => array(
				'type' => 'string',
				'default' => 'hall'
			)
		)
	));
	// Enqueue front-end JS that powers Finder results
	wp_enqueue_script(
		'stmu-finder',
		plugins_url('finder.js', __FILE__),
		array('jquery'),
		filemtime( plugin_dir_path( __FILE__ ) . 'finder.js' ),
		true
	);
	register_block_type('stmu/icon-heading', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/master-calendar', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_master_calendar',
		'attributes' => array(
			'editMode' => array(
				'type' => 'boolean',
				'default' => true
			),
			'calendarId' => array(
				'type' => 'string',
				'default' => '5'
			),
			'level' => array(
				'type' => 'string',
				'default' => 'h2'
			),
			'numberEvents' => array(
				'type' => 'string',
				'default' => '6'
			),
			'rssUrl' => array(
				'type' => 'string'
			)
		)
	));
	register_block_type('stmu/person', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'attributes' => array(
			'extraInfo' => array(
				'type' => 'string',
				'selector' => '.personInfo',
				'default' => '(Optional Title or Year)'
			),
			'gender' => array(
				'type' => 'string',
				'selector' => '.personGender',
				'default' => 'Unknown'
			),
			'imgURL' => array(
				'type' => 'string',
				'source' => 'attribute',
				'attribute' => 'src',
				'selector' => '.personImage img'
			),
			'imgID' => array(
				'type' => 'number'
			),
			'imgAlt' => array(
				'type' => 'string',
				'source' => 'attribute',
				'attribute' => 'alt',
				'selector' => '.personImage img'
			),
			'level' => array(
				'type' => 'string',
				'default' => 'h2',
				'selector' => '.personName'
			),
			'link' => array(
				'type' => 'string',
				'selector' => '.personLink',
				'attribute' => 'href'
			),
			'name' => array(
				'type' => 'string',
				'source' => 'text',
				'selector' => '.personName',
				'default' => 'Firstname Lastname'
			),
			'showBorder' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showName' => array(
				'type' => 'boolean',
				'default' => true
			),
			'type' => array(
				'type' => 'string',
				'selector' => '.wp-block-stmu-person',
				'default' => 'Other',
				'attribute' => 'itemprop'
			)
		)
	));
	register_block_type('stmu/post-connector', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_post_connector',
		'attributes' => array(
			'category' => array(
				'type' => 'string',
				'default' => 'all'
			),
			'display' => array(
				'type' => 'string',
				'default' => 'list'
			),
			'editMode' => array(
				'type' => 'boolean',
				'default' => true
			),
			'number' => array(
				'type' => 'string',
				'default' => '5'
			),
			'school' => array(
				'type' => 'string',
				'default' => 'all'
			),
			'tag' => array(
				'type' => 'string',
				'default' => 'all'
			)
		)
	));
	register_block_type('stmu/program-info', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
	register_block_type('stmu/program-degrees', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_program_degrees'
	));
	register_block_type('stmu/program-departments', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_program_departments'
	));
	register_block_type('stmu/program-directors', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_program_directors'
	));
	register_block_type('stmu/program-locations', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_program_locations',
		'attributes' => array(
			'locCampus' => array(
				'type' => 'boolean',
				'default' => true
			),
			'locCombo' => array(
				'type' => 'boolean',
				'default' => false
			),
			'locOnline' => array(
				'type' => 'boolean',
				'default' => false
			)
		)
	));
	register_block_type('stmu/related-pages', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_related_pages'
	));
	register_block_type('stmu/related-posts', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_stmu_related_posts',
		'attributes' => array(
			'editMode' => array(
				'type' => 'boolean',
				'default' => true
			),
			'postIds' => array(
				'type' => 'array',
				'default' => []
			),
			'postType' => array(
				'type' => 'string',
				'default' => 'posts'
			),
			'updated' => array(
				'type' => 'string',
				'default' => ''
			)
		)
	));
	register_block_type('stmu/residence-halls', array(
		'editor_script' => 'stmu-blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_residence_halls'
	));
	register_block_type('stmu/school-departments', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_school_departments'
	));
	register_block_type('stmu/school-faculty', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_school_faculty'
	));
	register_block_type('stmu/school-programs', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style',
		'render_callback' => 'get_school_programs',
		'attributes' => array(
			'editMode' => array(
				'type' => 'boolean',
				'default' => true
			),
			'levels' => array(
				'type' => 'string',
				'default' => 'all'
			)
		)
	));
	register_block_type('stmu/stat', array(
		'editor_script' => 'stmu_blocks',
		'editor_style' => 'stmu-blocks-edit-style',
		'style' => 'stmu-blocks-style'
	));
}
// Child Pages block callback
function get_child_pages() {
	global $post;
	$postArgs = array(
		'post_type' => $post->post_type,
		'post_parent' => $post->ID,
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	);
	$postQuery = new WP_Query($postArgs);
	// Child Programs (Law Concentrations)
	if($post->post_type == 'program') {
		if($postQuery->have_posts()) {
			$children = '<div class="stmu-single-block"><div class="max-width"><h2><i class="fa fa-certificate"></i> ' . get_the_title() . ' Concentrations</h2><ul class="concentrations">';
			while($postQuery->have_posts()) {
				$postQuery->the_post();
				$children .= '<li><a href="' . get_the_permalink() . '">' . get_the_title();
				if(get_post_meta($post->ID, 'available_online', true) == '1') {
					$children .= ' - <em>available online</em>';
				}
				$children .= '</a></li>';
			}
			wp_reset_postdata();
			$children .= '</ul></div></div>';
		}
	// All other post types
	} else {
		if($postQuery->have_posts()) {
			$children = '<div class="stmu-single-block"><div class="max-width"><div class="post-circles">';
			while($postQuery->have_posts()) {
				$postQuery->the_post();
				$image = get_the_post_thumbnail_url(get_the_id(), 'program');
				if(empty($image)) {
					$image = get_site_icon_url('200');
				}
				$children .= '<a class="post-circle" href="' . get_the_permalink() . '">';
				$children .= '<img src="' . $image . '" alt="" />';
				$children .= '<h3>' . get_the_title() . '</h3>';
				$children .= '</a>';
			}
			wp_reset_postdata();
			$children .= '</div></div></div>';
		}
	}
	return $children;
}// Residence Halls block callback
function get_residence_halls() {
	global $post;
	$postArgs = array(
		'post_type' => 'hall',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	);
	$postQuery = new WP_Query($postArgs);
	if($postQuery->have_posts()) {
		$stmu_circles = '<div class="stmu-single-block"><div class="max-width"><div class="post-circles">';
		while($postQuery->have_posts()) {
			$postQuery->the_post();
			$image = get_the_post_thumbnail_url(get_the_id(), 'program');
			if(empty($image)) {
				$image = get_site_icon_url('200');
			}
			$stmu_circles .= '<a class="post-circle" href="' . get_the_permalink() . '">';
			$stmu_circles .= '<img src="' . $image . '" alt="" />';
			$stmu_circles .= '<h3>' . get_the_title() . '</h3>';
			$stmu_circles .= '</a>';
		}
		wp_reset_postdata();
		$stmu_circles .= '</div></div></div>';
	}
	return $stmu_circles;
}
// Degrees - used in both Program Degree block and Related Posts block (when post type is Program)
function get_degree_schema($postId) {
	$degreeTerms = wp_get_post_terms((int)$postId, 'degree');
	if(count($degreeTerms) > 0) {
		$degrees = '<ul>';
		foreach($degreeTerms as $degree) {
			if($degree->parent != 0) { // always exclude parents "Undergraduate," "Graduate," and "Law" that aren't really degrees
				// Determine credential category: (Law) Degree, Certificate, (Teaching) Certification, Bachelor's Degree, Master's Degree, Doctorate, or Minor
				if(stripos($degree->name, 'Juris Doctor') != false || stripos($degree->name, 'Master of Jurisprudence') != false || stripos($degree->name, 'Master of Laws') != false) {
					$credentialCategory = 'Degree';
					$credentialLink = 'https://purl.org/ctdl/terms/Degree';
				} elseif(stripos($degree->name, 'Certificate') != false) {
					$credentialCategory = 'Certificate';
					$credentialLink = 'https://purl.org/ctdl/terms/Certificate';
				} elseif(stripos($degree->name, 'Certification') != false) {
					$credentialCategory = 'Certification';
					$credentialLink = 'https://purl.org/ctdl/terms/Certification';
				} elseif(stripos($degree->name, 'Bachelor') != false) {
					$credentialCategory = "Bachelor's Degree";
					$credentialLink = 'https://purl.org/ctdl/terms/BachelorDegree';
				} elseif(stripos($degree->name, 'Master') != false) {
					$credentialCategory = "Master's Degree";
					$credentialLink = 'https://purl.org/ctdl/terms/MasterDegree';
				} elseif(stripos($degree->name, 'Doctorate') != false) {
					$credentialCategory = "Bachelor's Degree";
					$credentialLink = 'https://purl.org/ctdl/terms/DoctoralDegree';
				}
				$degrees .= '<li itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
								<span itemprop="name">'. $degree->name . '</span>
								<span class="hide">
									<span itemprop="url">' . get_permalink($postID) . '</span>
									<span itemprop="image">' . get_the_post_thumbnail_url($post, 'large') . '</span>
									<span itemprop="credentialCategory" itemscope itemtype="https://schema.org/DefinedTerm">
										<meta itemprop="name" content="' . $credentialCategory . '" />
										<link itemprop="url" href="' . $credentialLink . '" />
										<span itemprop="inDefinedTermSet" itemscope itemtype="https://schema.org/DefinedTermSet">
											<meta itemprop="name" content="Credential Transparency Description Language"/>
											<link itemprop="url" content="https://purl.org/ctdl/terms/" />
										</span>
									</span>
								</span>
							</li>';
			}
		}
		$degrees .= '</ul>';
	}
	return $degrees;
}
// Faculty Departments block callback
function get_faculty_departments() {
	$deptField = get_field('relationship_facultydepartment', (int)get_the_ID());
	// Even faculty without a department have this meta_key, with an empty meta_value
	// so check each value to make sure we only output if there is at least one valid, published department
	if($deptField) {
		foreach($deptField as $post) {
			// Make sure it's not an empty value
			if(!empty($post)) {
				// Make sure the department is published
				if($post->post_status == 'publish') {
					$departments .= '<li><a href="' . get_the_permalink($post) . '">' . get_the_title($post) . '</a></li>';
				}
			}
		}
	}
	// If any were found, wrap with a heading and list
	if(!empty($departments)) {
		$departments = '<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i> Departments</h2><ul>' . $departments . '</ul>';
	}
	return $departments;
}
// Faculty Programs block callback
function get_faculty_programs() {
	$progField = get_field('relationship_programfaculty', (int)get_the_ID());
	// Even faculty without a program have this meta_key, with an empty meta_value
	// so check each value to make sure we only output if there is at least one valid, published program
	if($progField) {
		foreach($progField as $post) {
			// Make sure it's not an empty value
			if(!empty($post)) {
				// Make sure the program is published
				if($post->post_status == 'publish') {
					$programs .= '<li><a href="' . get_the_permalink($post) . '">' . get_the_title($post) . '</a></li>';
				}
			}
		}
	}
	// If any were found, wrap with a heading and list
	if(!empty($programs)) {
		$programs = '<h2><i class="fa fa-book" aria-hidden="true"></i> Programs</h2><ul>' . $programs . '</ul>';
	}
	return $programs;
}
// Featured Image block callback
function get_featured_image($attributes) {
	global $post;
	if(has_post_thumbnail($post)) {
		$src = get_the_post_thumbnail_url($post, 'large');
		$alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
		if(empty($alt)) {
			$alt = 'Faculty photo';
		}
	} else {
		$src = '/wp-content/themes/stmu-parent/images/no-photo-available.png';
		$alt = 'No photo available';
	}
	return "<img src=\"$src\" alt=\"$alt\" />";
}
// Finder block callback
function get_finder($attributes) {
	$finder = '<div class="search-filters">';
		$postType = get_post_type_object($attributes['postType']);
		$finder .= '<h2>' . $postType->labels->singular_name . ' Finder</h2>
		<form action="/wp-admin/admin-ajax.php" method="POST" id="filter">
			<input type="hidden" name="posttype" value="' . $attributes['postType'] . '" />';
			$taxonomies = get_object_taxonomies($attributes['postType'], 'objects');
			foreach($taxonomies as $taxonomy) {
				$finder .= '<fieldset><legend>' . $taxonomy->label . '</legend>';
				$terms = get_terms(array('taxonomy' => $taxonomy->name, 'hide_empty' => true));
				foreach($terms as $term) {
					$finder .= '<label><input type="checkbox" name="' . $taxonomy->name . '[]" id="' . $term->slug . '" value="' . $term->slug . '" />' . $term->name . '</label>';
				}
				$finder .= '</fieldset>';
			}
	// The action "stmu_search_filter" is added to AJAX hooks in theme functions.php, lines ~740-860.
	// Data retrieval and display is handled in that file.
	$finder .= '<input type="hidden" name="action" value="stmu_search_filter" />
			<button>Apply filter</button>
		</form>
	</div>
	<div class="max-width" id="stmu-results"></div>';
	return $finder;
}
// Master Calendar block callback - also see theme "tpl-events.php" for similar API calls
function get_master_calendar($attributes) {
	// If RSS feed was entered, pull from that. (RSS feeds are the only option for groups like "music events."
	if ( 'rss' === $attributes['calendarId'] ) {
		date_default_timezone_set('America/Chicago');
		$startMonth = date('Ym');
		$endMonth = date('Ym', strtotime("+10 months"));
		$rss = fetch_feed($attributes['rssUrl']);
		$output = array();
		if(!is_wp_error($rss)) {
			$rss->enable_order_by_date(false);
			$rss_items = $rss->get_items(0, 10);
			foreach($rss_items as $item) {
				$allDay = '';
				$checkDescription = $item->get_item_tags('', 'description')[0]['data'];
				if(' All day event' == $checkDescription) {
					$allDay = true;
				}
				$title = str_replace('"', '\"', $item->get_title());
				if(strlen($title) > 70) {
					$title = substr($title, 0, 50);
					$title = substr($title, 0, strripos($title, " "));
					$title = trim(preg_replace( '/\s+/', ' ', $title));
				}
				if($title) {
					$output[] = array(
						'title' => $title,
						'start' => $item->get_date('Y-m-d H:i:s'),
						'url' => $item->get_permalink(),
						'allDay' => $allDay,
						'eventType' => $item->get_item_tags('','category')[0]['data'],
					);
				}
			}
		}
	// Else, a calendar ID was passed - use the MC API instead.
	} else {
		$url = 'https://ems-app.stmarytx.edu/MCAPI/MCAPIService.asmx?WSDL';
		$headers = get_headers($url);
		if($headers[0] == 'HTTP/1.1 200 OK') {
			// calculate start and end dates
			$startDate = new DateTime("today", new DateTimeZone('America/Chicago'));
			$endDate = new DateTime("+3 months", new DateTimeZone('America/Chicago'));
			// call via SOAP
			$client = new SoapClient('https://ems-app.stmarytx.edu/MCAPI/MCAPIService.asmx?WSDL', array('trace' => 1));
			$params = array(
				'soap_version'	=> 'SOAP_1_2',
				'startDate'		=> $startDate->format('Y-m-d') . 'T00:00:00',
				'endDate'		=> $endDate->format('Y-m-d') . 'T23:59:59',
				'userName'		=> 'redacted',
				'password'		=> 'redacted',
				'calendars'		=> array($attributes['calendarId'])
			);
			$output = array();
			$result = $client->__soapCall('GetEvents', array($params));
			if(!is_soap_fault($result)) {
				$xml = simplexml_load_string($result->GetEventsResult);
				foreach($xml->Data as $event) {
					$allDay = '';
					$priority = '';
					if($event->IsAllDayEvent == 'true') {
						$allDay = true;
					}
					if($event->Priority == 1) {
						$priority = 'high';
					}
					// Only show priority 1 and 2 events
					$duplicate='';
					if($event->Priority < 3) {
						// Loop through existing to see if there is a duplicate title
						// This differs from the events page - it checks for dupe title *and* start date
						for($q=0; $q<count($output); $q++) {
							if((str_replace('"', '\"', $event->{'Title'}) == $output[$q]['title'])) {
								$duplicate=1;
							}
						}
						// If no duplicate was found, add to the array
						if($duplicate != 1) {
							$output[] = array(
								'title' => str_replace('"', '\"', $event->{'Title'}),
								'start' => $event->TimeEventStart,
								'url' => 'https://ems-app.stmarytx.edu/MasterCalendar/EventDetails.aspx?EventDetailId=' . $event->EventDetailID,
								'allDay' => $allDay,
								'priority' => $priority,
								'eventType' => $event->EventTypeName,
								'canceled' => $event->Canceled[0]
							);
						}
					}
				}
			}
		}
		$sort = array();
		// sort by date, since Master Calendar API does not have this capability
		foreach($output as $key => $value) {
			$sort[$key] = strtotime($value['start']);
		}
		array_multisort($sort, SORT_ASC, $output);
	}
	// For both RSS and API, output a standard style with schema.
	if(count($output) > 0) {
		$calendar = '<ul class="calendar bordered-box">';
		for($i=0; $i < $attributes['numberEvents']; $i++) {
			if(!empty($output[$i]['title'])) {
				$eventDate = strtotime($output[$i]['start']);
				$calendar .= '<li itemscope itemtype="http://schema.org/Event" class="wp-block-stmu-bordered-box-item">
					<div class="calWrap">
						<meta itemprop="startDate" content="' . date('Y-m-d', $eventDate) . '" />
						<div class="cal">
							<span class="calMonth">' . date('M', $eventDate) . '</span>
							<span class="calDay">' . date('j', $eventDate) . '</span>
						</div>
						<span class="hide" itemprop="location" itemscope itemtype="http://schema.org/Place">
							<span itemprop="name">St. Mary\'s University</span>
							<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
								<span itemprop="addressLocality">San Antonio</span>,
								<span itemprop="addressRegion">TX</span>
							</span>
						</span>
						<span class="hide" itemprop="eventStatus" itemscope itemtype="https://schema.org/EventStatusType">EventScheduled</span>
						<a class="event-link';
						if('true' == $event['canceled']) { $calendar .= ' canceled-event'; }
						$calendar .= '" itemprop="url" href="' . $output[$i]['url'] . '">';
						if ( 'h4' === $attributes['level'] ) {
							$calendar .= '<h4 itemprop="name">' . $output[$i]['title'] . '</h4></a>';
						} else if ( 'h3' === $attributes['level'] ) {
							$calendar .= '<h3 itemprop="name">' . $output[$i]['title'] . '</h3></a>';
						} else {
							$calendar .= '<h2 itemprop="name">' . $output[$i]['title'] . '</h2></a>';
						}
						$calendar .= '
					</div>
				</li>';
			}
		}
		$calendar .= '</ul>';
	} else {
		$calendar = '<p>Sorry, there are no events to display.</p>';
	}
	return $calendar;
}
// Post Connector block callback
function get_post_connector($attributes) {
	global $post;
	// Set up basic query - excludes current post
	$postArgs = array(
		'post_type' => 'post',
		'post__not_in' => array($post->ID)
	);
	// Att: category
	if(!empty($attributes['category']) && $attributes['category'] != 'all') {
		$postArgs['category_name'] = $attributes['category'];
	}
	// Att: display
	if(!empty($attributes['display']) && $attributes['display'] == 'images') {
		$postArgs['meta_key'] = '_thumbnail_id';
	}
	// Att: number
	if(is_numeric($attributes['number'])) {
		$postArgs['posts_per_page'] = $attributes['number'];
	}
	// Att: school
	if(!empty($attributes['school']) && $attributes['school'] != 'all') {
		$postArgs['tax_query'] = array(
			array(
				'taxonomy' => 'school',
				'field' => 'slug',
				'terms' => array($attributes['school'])
			)
		);
	}
	// Att: tag
	if(!empty($attributes['tag']) && $attributes['tag'] != 'all') {
		$postArgs['tag'] = $attributes['tag'];
	}
	// Run the query
	$postQuery = new WP_Query($postArgs);
	if($postQuery->have_posts()) {
		// With images
		if($attributes['display'] == 'images') {
			$stmu_posts = '<div class="post-connector">';
			while($postQuery->have_posts()) {
				$postQuery->the_post();
				$stmu_posts .= '<a class="post-item" href="' . get_the_permalink() . '" style="background-image:url(\'';
				$stmu_posts .= get_the_post_thumbnail_url(get_the_id(), 'spotlight') . '\');" />';
				$stmu_posts .= '<div class="overlay">' . get_the_title() . '</div>';
				$stmu_posts .= '</a>';
			}
			$stmu_posts .= '</div>';
		// List without images
		} else {
			$stmu_posts = '<ul class="stmu_posts">';
			while($postQuery->have_posts()) {
				$postQuery->the_post();
				$stmu_posts .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
			}
			$stmu_posts .= '</ul>';
		}
		// Restore the main Post
		wp_reset_postdata();
		// Always return to be displayed
	} else {
		$stmu_posts = '<div>Check back later for posts on this topic.</div>';
	}
	return $stmu_posts;
}
// Program Degree block callback
function get_program_degrees() {
	$postId = (int)get_the_ID();
	// Nursing program shows Category > Pre-health; all others show Degree > List of degree taxonomy terms
	$slug = get_post_field('post_name', $postId);
	if($slug == 'nursing') {
		$degrees = '<div class="programDetails"><h2>Category</h2>';
		$degrees .= '   <ul>
							<li><a href="/academics/special-programs/pre-health-professional/">Pre-health Professional Programs</a></li>
						</ul>';
		$degrees .= '</div>';
	} else {
		$degrees = '<div class="programDetails"><h2>Degree</h2>';
		$degreeTerms = wp_get_post_terms($postId, 'degree');
		if(count($degreeTerms) > 0) {
			$degrees .= get_degree_schema($postId);
		}
		$degrees .= '</div>';
	}
	return $degrees;
}
// Program Department block callback
function get_program_departments() {
	$departments = '<div class="programDetails"><h2>Department</h2>';
	$deptField = get_field('relationship_programdepartment', (int)get_the_ID());
	if(count($deptField) > 0) {
		$departments .= '<ul>';
		foreach($deptField as $post) {
			setup_postdata($post);
			if($post->post_status == 'publish') {
				$departments .= '<li><a href="' . get_the_permalink($post) . '">' . get_the_title($post) . '</a></li>';
			}
		}
		$departments .= '</ul>';
	}
	$departments .= '</div>';
	return $departments;
}
// Program Director block callback
function get_program_directors() {
	$directors = '<div class="programDetails"><h2>Contact</h2>';
	$facultyField = get_field('relationship_programfaculty', (int)get_the_ID());
	if(count($facultyField) > 0) {
		$directors .= '<ul>';
		foreach($facultyField as $post) {
			setup_postdata($post);
			if($post->post_status == 'publish') {
				$directors .= '<li><a href="' . get_the_permalink($post) . '">' . get_the_title($post) . '</a></li>';
			}
		}
		$directors .= '</ul>';
	}
	$directors .= '</div>';
	return $directors;
}
// Program Locations block callback
function get_program_locations($attributes) {
	$locations = '<div class="programDetails">';
	$levels = get_the_terms(get_the_ID(), 'degree');
	$undergrad = 0;
	if($levels) {
		foreach($levels as $level) {
			if($level->slug == 'undergraduate') {
				$undergrad = 1;
				break;
			}
		}
	}
	// If undergraduate, show School
	if($undergrad == 1) {
		$locations .= '<h2>School</h2><ul>';
		$school = get_the_terms(get_the_ID(), 'school');
		if( $school && ! is_wp_error( $school ) ) {
			if ( 'Greehey School of Business' === $school[0]->name ) {
				$schoolLink = '/academics/business/';
			} elseif ( 'College of Arts, Humanities and Social Sciences' === $school[0]->name ) {
				$schoolLink = '/academics/humanities/';
			} else {
				$schoolLink = '/academics/set/';
			}
			$locations .= '<li><a href="' . $schoolLink . '">' . $school[0]->name . '</a></li>';
		}
		$locations .= '</ul>';
	// Otherwise, show Location
	} else {
		$locations .= '<h2>Locations</h2><ul>';
		if($attributes['locCampus'] == true) { $locations .= '<li>On Campus</li>'; }
		if($attributes['locOnline'] == true) { $locations .= '<li>Online</li>'; }
		if($attributes['locCombo'] == true) { $locations .= '<li>Combination</li>'; }
		$locations .= '</ul>';
	}
	$locations .= '</div>';
	return $locations;
}
// Related Pages block callback
function get_related_pages() {
	$related = '';
	$relatedPages = get_field('related_posts', (int)get_the_ID());
	// REQUIRES stmu-2017-functions.php (plugin) - ~line 1664
	if($relatedPages) {
		$related = showRelatedPages($relatedPages);
	}
	return $related;
}
// School Departments block callback
function get_school_departments() {
	global $post;
	if($post->post_type == 'business') {
		$school_term = 'school-business';
	} elseif($post->post_type == 'humanities') {
		$school_term = 'school-humanities';
	} else {
		$school_term = 'school-set';
	}
	$list = '';
	$myposts = get_posts(array(
		'post_type' => 'department',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'title',
		'tax_query' => array(
			array(
			'taxonomy' => 'school',
			'field' => 'slug',
			'terms' => "$school_term")
			)
		)); 
	$list .= '<ul>';
	foreach ($myposts as $mypost) {
		$postID = $mypost->ID;
		$list .= '<li><a href="' . get_permalink($postID) . '">' . $mypost->post_title . '</a></li>';
	}
	$list .= '</ul>';
	return $list;
}
// School Faculty block callback
function get_school_faculty() {
	global $post;
	if($post->post_type == 'business') {
		$school_term = 'school-business';
	} elseif($post->post_type == 'humanities') {
		$school_term = 'school-humanities';
	} else {
		$school_term = 'school-set';
	}
	$list = '';
	$myposts = get_posts(array(
		'post_type' => 'faculty',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_key' => 'faculty_last',
		'order' => 'ASC',
		'orderby' => 'meta_value',
		'tax_query' => array(
			array(
				'taxonomy' => 'school',
				'field' => 'slug',
				'terms' => "$school_term")
			)
		)
	);
	$list = '<div class="post-connector">';
	foreach($myposts as $mypost) {
		$postID = $mypost->ID;
		if(has_post_thumbnail($postID)) {
			$image_url = get_the_post_thumbnail_url($postID);
		} else {
			$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
		}
		$list .= '<a class="post-item" href="' . get_permalink($postID) . '" style="background-image:url(\'' . $image_url . '\');"><div class="overlay">' . get_the_title($postID) . '</div></a>';
	}
	$list .= '</div>';
	return $list;
}
// School Programs block callback
function get_school_programs($attributes) {
	global $post;
	if($post->post_type == 'business') {
		$school_term = 'school-business';
	} elseif($post->post_type == 'humanities') {
		$school_term = 'school-humanities';
	} else {
		$school_term = 'school-set';
	}
	$list = '';
	$myposts = new WP_Query(array(
		'post_type' => 'program',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'title',
		'tax_query' => array(
			array(
				'taxonomy' => 'school',
				'field' => 'slug',
				'terms' => "$school_term")
			)
		)
	);
	if($myposts->have_posts()){
		$list = '<div class="post-circles">';
		while($myposts->have_posts()) { $myposts->the_post();
			$postID = get_the_ID();
			// Show all levels
			if($attributes['levels'] == 'all') {
				$programImgID = get_post_thumbnail_id($postID);
				$programAlt = get_post_meta($programImgID, '_wp_attachment_image_alt', true);
				$list .= '<a class="post-circle" href="' . get_permalink($postID) . '">
					<img src="' . get_the_post_thumbnail_url($postID, 'thumbnail') . '" alt="" />
					<h3>' . get_the_title($postID) . '</h3>
				</a>';
			// Show either "undergraduate" or "graduate" only
			} else {
				$terms = wp_get_post_terms($postID, 'degree');
				foreach($terms as $term) {
					if(strtolower($term->name) == $attributes['levels']) {
						$programImgID = get_post_thumbnail_id($postID);
						$programAlt = get_post_meta($programImgID, '_wp_attachment_image_alt', true);
						$list .= '<a class="post-circle" href="' . get_permalink($postID) . '">
							<img src="' . get_the_post_thumbnail_url($postID, 'thumbnail') . '" alt="" />
							<h3>' . get_the_title($postID) . '</h3>
						</a>';
					}
				}
			}
		}
		$list .= '</div>';
	}
	return $list;
}
// Related Posts block callback
function get_stmu_related_posts($attributes) {
	// Faculty: render white rectangle with thumbnail and title
	if($attributes['postType'] == 'faculty') {
		$stories = '<div class="stmu-single-block">
						<div class="max-width">
							<h2><i class="fa fa-users" aria-hidden="true"></i> Faculty</h2>
							<ul class="bordered-box faculty-list">';
		foreach($attributes['postIds'] as $postId) {
			$post = get_post($postId);
			if(!is_null($post) && $post->post_status == 'publish') { // Only display if the post still exists.
				setup_postdata($post);
				if(has_post_thumbnail($postId)) {
					$image_url = get_the_post_thumbnail_url($postId, 'thumbnail');
				} else {
					$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
				}
				$titles = get_post_meta($postId, 'faculty_titles', true);
				$stories .= '<li itemprop="employee" itemscope itemtype="https://schema.org/Person" class="wp-block-stmu-bordered-box-item">
					<a itemprop="url" href="' . get_the_permalink($postId) . '">
						<img src="' . $image_url . '" alt="' . get_the_title($postId) . '" />
						<div>
							<span itemprop="name">' . get_the_title($postId) . '</span>
							<span itemprop="jobTitle">' . $titles[0] . '</span>
						</div>
					</a>
				</li>';
			}
		}
		$stories .= '</ul>
				</div>
			</div>';
	// Programs and Special Programs: circle with thumbnail and title; programs also have schema for their degrees
	} elseif($attributes['postType'] == 'program' || $attributes['postType'] == 'specialprogram') {
		$stories = '<div class="stmu-single-block"><div class="max-width">';
		$stories .= '<div class="post-circles">';
		foreach($attributes['postIds'] as $postId) {
			$post = get_post($postId);
			if(!is_null($post) && $post->post_status == 'publish') { // Only display if the post still exists.
				setup_postdata($post);
				// Programs have "Degrees" assigned - each one can have Schema for "EducationalOccupationalCredential"
				// (the schema is put on the individual degrees, since the Program itself may have several available credentials)
				$degrees = get_degree_schema($postId);
				if($attributes['postType'] == 'program') {
					$stories .= '<span itemscope itemtype="https://schema.org/EducationalOccupationalProgram">';
				}
				if(has_post_thumbnail($postId)) {
					$image_url = get_the_post_thumbnail_url($post, 'program');
				} elseif(has_custom_logo()) {
					$image_url = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'program');
				} else {
					$image_url = 'https://via.placeholder.com/200';
				}
				$stories .= '<a itemprop="url" class="post-circle" href="' . get_permalink($postId) . '">
								<img itemprop="image" src="' . $image_url . '" alt="" />
								<h3 itemprop="name">' . get_the_title($post) . '</h3><span class="hide">' . $degrees . '</span>
							</a>';
				if($attributes['postType'] == 'program') {
					$stories .= '</span>';
				}
			}
		}
		$stories .= '</div></div></div>';
	}
	// Posts: render featured image with blue overlay and title
	// Note: because the REST API URL for "Post" is plural, this one is "posts", but all other post types use singular (i.e. "program") in the REST API URL
	else {
		$stories = '<div class="stmu-single-block"><div class="max-width"><h2><i class="fa fa-user-circle" aria-hidden="true"></i> Related Stories</h2><div class="post-connector" role="complementary">';
		foreach($attributes['postIds'] as $postId) {
			$post = get_post($postId);
			if(!is_null($post) && $post->post_status == 'publish') { // Only display if the post still exists.
				setup_postdata($post);
				$stories .= '<a class="post-item" href="' . get_the_permalink($post) . '" style="background-image:url(' . get_the_post_thumbnail_url($post, 'spotlight') . ');">
								<h3 class="overlay">' . get_the_title($post) . '</h3>
							</a>';
			}
		}
		$stories .= '</div></div></div>';
	}
	// Always return!
	return $stories;
}
// Remove the Core "Table" block, since this plugin creates an Accessible Table replacement - and also remove Core "Search" block because we use Swiftype
add_action('enqueue_block_editor_assets', 'stmu_blacklist_blocks');
function stmu_blacklist_blocks() {
	wp_enqueue_script('stmu-blacklist-blocks', plugins_url('stmu-blacklist.js', __FILE__), array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), '', true);
}
?>