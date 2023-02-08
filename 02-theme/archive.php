<?php global $subdomain;
// Prevent Schools and Interests from displaying
if(is_tax() && ($subdomain == 'www' || $subdomain == 'law')) {
	if(is_tax('school', 'school-business')) {
		wp_redirect('/academics/business/', 301);
		exit;
	} elseif(is_tax('school', 'school-humanities')) {
		wp_redirect('/academics/humanities/', 301);
		exit;
	} elseif(is_tax('school', 'school-law')) {
		wp_redirect('https://law.stmarytx.edu', 301);
		exit;
	} elseif(is_tax('school', 'school-set')) {
		wp_redirect('/academics/set/', 301);
		exit;
	} elseif(is_tax('interest')) {
		wp_redirect('/academics/programs/', 301);
		exit;
	}
}
get_header();
// school homepages
if(is_post_type_archive('business') || is_post_type_archive('humanities') || is_post_type_archive('set')) {
	if(is_post_type_archive('business')) { $school = 'business'; $oldSchool = 'greehey'; }
	elseif(is_post_type_archive('humanities')) { $school = 'humanities'; $oldSchool = 'hss'; }
	elseif(is_post_type_archive('set')) { $school = 'set'; $oldSchool = 'set'; } ?>
	<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
		<div id="secondary-nav" class="headerContainer" role="navigation" aria-label="School">
			<?php $theme_location = $school . '-nav';
			wp_nav_menu(array('theme_location' => "$theme_location", 'container' => '', 'items_wrap' => '<ul class="menu">%3$s</ul>',));
			?>
		</div>
		<?php if(have_rows($oldSchool . '_content_blocks', 'option')) :
			$i=1;
			while(have_rows($oldSchool . '_content_blocks', 'option')) : the_row();
			if(get_sub_field($oldSchool . '_content_block', 'option') == 'school-about') { ?>
				<section class="stmu-single-block">
				<h2 class="text-center" id="about-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_left_content_header', 'option') ?></h2>
					<div class="max-width half-half">
						<div>
							<?php the_sub_field($oldSchool . '_left_content', 'option') ?>
						</div>
						<div>
							<?php the_sub_field($oldSchool . '_right_content', 'option') ?>
						</div>
					</div>
					<?php if(!empty(get_sub_field($oldSchool . '_about_button_text', 'option'))) { ?>
						<div class="max-width text-center">
							<a class="ghost-btn" href="
								<?php the_sub_field($oldSchool . '_about_url', 'option') ?>">
								<?php the_sub_field($oldSchool . '_about_button_text', 'option') ?>
							</a>
						</div>
					<?php } ?>
				</section>
			<?php } elseif(get_sub_field($oldSchool . '_content_block', 'option') == 'school-full-width') { ?>
				<section class="stmu-single-block text-center schoolHomeBlock">
					<div class="max-width">
						<h2 id="wide-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_fullwidth_header', 'option') ?></h2>
						<?php the_sub_field($oldSchool . '_fullwidth_content', 'option') ?>
					</div>
				</section>
			<?php } elseif(get_sub_field($oldSchool . '_content_block', 'option') == 'school-faculty') { ?>
				<section class="stmu-single-block schoolHomeBlock text-center">
					<div class="max-width">
						<h2 id="faculty-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_faculty_header', 'option') ?></h2>
						<?php // get 3 random faculty in this school
						$terms = 'school-' . $school;
						$facultyArgs = array(
							'no_found_rows' => true,
							'post_type' => 'faculty',
							'posts_per_page' => 4,
							'orderby' => 'rand',
							'meta_key' => '_thumbnail_id', // only grabs posts with a featured image
							'tax_query' => array(
								array(
									'taxonomy' => 'school',
									'field' => 'slug',
									'terms' => array("$terms"),
								)
							)
						);
						$myposts = get_posts($facultyArgs);
						$list = '<div class="post-connector">';
						foreach ($myposts as $mypost) {
							$postID = $mypost->ID;
							$list .= '<a class="post-item" href="' . get_permalink($postID) . '" style="background-image:url(\'' . get_the_post_thumbnail_url($postID) . '\');">';
								$list .= '<div class="overlay">';
									$list .= '<h3>'. get_the_title($postID) . '</h3>';
									$list .= '<p>' . get_field("faculty_staff_title", $postID) . '</p>';
								$list .= '</div>';
							$list .= '</a>';
						}
						$list .= '</div>';	
						echo $list; ?>
					</div>
					<div class="max-width">
						<a class="ghost-btn" href="faculty/">View all faculty</a>
					</div>
				</section>
			<?php } elseif(get_sub_field($oldSchool . '_content_block', 'option') == 'school-news') { ?>
				<section class="stmu-single-block schoolHomeBlock spotlightBlock text-center">
					<div class="max-width">
						<h2 id="news-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_news_header', 'option') ?></h2>
						<?php // get 5 latest news posts in this school
						$terms = 'school-' . $school;
						$newsArgs = array(
							'no_found_rows' => true,
							'post_type' => 'post',
							'category_name' => 'news',
							'posts_per_page' => 5,
							'orderby' => 'date',
							'_shuffle_and_pick' => 4, // custom attribute (functions.php) to get 4 random posts from the initial query
							'meta_key' => '_thumbnail_id', // only grabs posts with a featured image
							'tax_query' => array(
								array(
									'taxonomy' => 'school',
									'field' => 'slug',
									'terms' => array("$terms"),
								)
							)
						);
						$newsQuery = new WP_Query($newsArgs);
						if($newsQuery->have_posts()): ?>
							<div class="post-connector"><?php
							while($newsQuery->have_posts()) : $newsQuery->the_post(); ?>
								<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url(); ?>');">
									<div class="overlay"><h3><?php the_title(); ?></h3></div>
								</a>
						<?php endwhile; ?>
							</div><?php
						endif; ?>
					</div>
					<div class="max-width">
						<a class="ghost-btn" href="
							<?php the_sub_field($oldSchool . '_news_url', 'option') ?>">
							<?php the_sub_field($oldSchool . '_news_button_text', 'option') ?></a>
					</div>
				</section>
			<?php } elseif(get_sub_field($oldSchool . '_content_block', 'option') == 'school-majors') { ?>
				<section class="stmu-single-block schoolHomeBlock text-center">
					<div class="max-width">
						<h2 id="programs-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_majors_section_header', 'option') ?></h2>
						<div class="post-circles">
							<?php
							// GSB get all, other schools get 4 undergrad programs
							if($oldSchool == 'greehey') { $posts_per_page = -1; } else { $posts_per_page = 4; }
							$terms = 'school-' . $school;
							$programArgs = array(
								'no_found_rows' => true,
								'post_type' => 'program',
								'post__not_in' => array('1483295', '1483807'), // exclude 2 GSB Minors
								'posts_per_page' => $posts_per_page,
								'orderby' => 'rand',
								'meta_key' => '_thumbnail_id', // only grabs posts with a featured image
								'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'school',
										'field' => 'slug',
										'terms' => array("$terms"),
									),
									array(
										'taxonomy' => 'degree',
										'field' => 'slug',
										'terms' => array('undergraduate'),
									)
								)
							);
							$majorQuery = new WP_Query($programArgs);
							if($majorQuery->have_posts()):
								while($majorQuery->have_posts()) : $majorQuery->the_post();
									$programImgID = get_post_thumbnail_id($post->ID);
									$programAlt = get_post_meta($programImgID, '_wp_attachment_image_alt', true);
									get_template_part('post-circle');
								endwhile;
							endif; ?>
						</div>
						<a class="ghost-btn" href="
							<?php the_sub_field($oldSchool . '_majors_url', 'option') ?>">
							<?php the_sub_field($oldSchool . '_majors_button_text', 'option') ?></a>
					</div>
				</section>
			<?php } elseif(get_sub_field($oldSchool . '_content_block', 'option') == 'school-grad') { ?>
				<section class="stmu-single-block schoolHomeBlock text-center">
					<div class="max-width">
						<h2 id="grad-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_grad_section_header', 'option') ?></h2>
						<div class="post-circles">
							<?php // get 3 random programs in this school
							$terms = 'school-' . $school;
							$programArgs = array(
								'post_type' => 'program',
								'posts_per_page' => 3,
								'orderby' => 'rand',
								'meta_key' => '_thumbnail_id', // only grabs posts with a featured image
								'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'school',
										'field' => 'slug',
										'terms' => array("$terms"),
									),
									array(
										'taxonomy' => 'degree',
										'field' => 'slug',
										'terms' => array('graduate'),
									)
								)
							);
							$majorQuery = new WP_Query($programArgs);
							if($majorQuery->have_posts()):
								while($majorQuery->have_posts()) : $majorQuery->the_post();
									$programImgID = get_post_thumbnail_id($post->ID);
									$programAlt = get_post_meta($programImgID, '_wp_attachment_image_alt', true);
									get_template_part('post-circle');
								endwhile;
							endif; ?>
						</div>
						<a class="ghost-btn" href="
							<?php the_sub_field($oldSchool . '_grad_url', 'option') ?>">
							<?php the_sub_field($oldSchool . '_grad_button_text', 'option') ?>
						</a>
					</div>
				</section>
			<?php } elseif(get_sub_field($oldSchool . '_content_block', 'option') == 'school-spotlights') { ?>
				<section class="stmu-single-block schoolHomeBlock spotlightBlock text-center">
					<div class="max-width">
						<h2 id="spotlights-<?php echo $i; ?>"><?php the_sub_field($oldSchool . '_spotlight_header', 'option') ?></h2>
						<?php // get 3 random spotlights in this school
						$terms = 'school-' . $school;
						$spotArgs = array(
							'no_found_rows' => true,
							'post_type' => 'post',
							'category_name' => 'magazine',
							'posts_per_page' => 5,
							'orderby' => 'date',
							'meta_key' => '_thumbnail_id', // only grabs posts with a featured image
							'no_found_rows' => 'true',
							'_shuffle_and_pick' => 4, // custom attribute (functions.php) to get 4 random posts from the initial query
							'tax_query' => array(
								array(
									'taxonomy' => 'school',
									'field' => 'slug',
									'terms' => array("$terms"),
								)
							)
						);
						$spotQuery = new WP_Query($spotArgs);
						if($spotQuery->have_posts()): ?>
							<div class="post-connector"><?php
							while($spotQuery->have_posts()) : $spotQuery->the_post(); ?>
								<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url(); ?>');">
									<div class="overlay"><h3><?php the_title(); ?></h3></div>
								</a>
						<?php endwhile; ?>
							</div><?php
						endif; ?>
					</div>
					<?php if(get_sub_field($oldSchool . '_spotlight_url', 'option')) { ?>
					<div class="max-width">
						<a class="ghost-btn" href="
							<?php the_sub_field($oldSchool . '_spotlight_url', 'option') ?>">
							<?php the_sub_field($oldSchool . '_spotlight_button_text', 'option') ?>
						</a>
					</div>
					<?php } ?>
				</section>		
			<?php }
			$i++;
			endwhile;
		endif; ?>
	</main><?php 
} else { ?>
	<main class="page-wrapper white-ghostweave" id="theContent" data-swiftype-index="true">
		<div class="max-width">
			<?php if(have_posts()):
				while(have_posts()): the_post();
					get_template_part( 'content', 'archive' );
				endwhile;
			endif; ?>
		</div>
	</main><?php
}
// no matter what archive type, get footer
get_footer(); ?>