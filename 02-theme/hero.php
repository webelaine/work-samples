<?php global $subdomain; $siteurl = site_url();
/*---------- homepage ----------*/
if(is_front_page()) {
	// Policy Library, non-www, non-law (Policy Library claims "www" so must be caught first)
	if(
		// Policy Library
		(substr($siteurl, 7, 6) == 's29372' || substr($siteurl, 8, 25) == 'www.stmarytx.edu/policies') ||
		// Non-www, non-law
		($subdomain != 'www' && $subdomain != 'law')
	) { ?>
		<div class="hero">
			<div class="max-width">
				<h1><?php bloginfo('title'); ?></h1>
			</div>
		</div><?php
	// WWW and Law
	} else {
		// "Takeover" for Commencement, weather alerts, etc.
		if(get_field('main_hero_type', 'option') == 'takeover') { ?>
			<div class="hero takeover">
				<div class="takeover-overlay">
					<div class="h1"><?php the_field('main_hero_h1', 'option'); ?></div>
					<?php the_field('main_hero_text', 'option'); ?>
					<a class="ghost-btn" href="<?php the_field('main_hero_button_url', 'option'); ?>"><?php the_field('main_hero_button_text', 'option'); ?></a>
				</div>
			</div>
		<?php
		// Normal www & law hero
		} else { ?>
			<div class="hero"></div>
		<?php }
	}
/*---------- slim hero ----------*/
} else {
	/*---------- photo "defining moment" hero ----------*/
	if(
		(is_page(array('about', 'academics', 'admission', 'campuslife', 'campus-life')) && ($subdomain == 'www' || $subdomain == 'law'))
		|| (is_page(array('activities', 'career-services', 'definingmoment', 'living-on-campus', 'outreach', 'oyster-bake', 'spiritual')) && $subdomain == 'www')
		|| (is_singular('specialprogram') && $subdomain == 'www')
		|| (is_post_type_archive(array('business', 'humanities', 'set')) && $subdomain == 'www')
	) {
		$defininghero = true;
	}
	// set the image
	if(is_post_type_archive('business') && $subdomain == 'www') { ?>
		<style type="text/css">.hero.defining-hero { background-image:url('<?php the_field('greehey_hero_image', 'option'); ?>'); }</style><?php
	} elseif(is_post_type_archive('humanities') && $subdomain == 'www') { ?>
		<style type="text/css">.hero.defining-hero { background-image:url('<?php the_field('hss_hero_image', 'option'); ?>'); }</style><?php
	} elseif(is_post_type_archive('set') && $subdomain == 'www') { ?>
		<style type="text/css">.hero.defining-hero { background-image:url('<?php the_field('set_hero_image', 'option'); ?>'); }</style><?php
	} elseif(has_post_thumbnail() && $defininghero == true) { ?>
		<style type="text/css">.hero.defining-hero { background-image:url('<?php the_post_thumbnail_url(); ?>'); }</style><?php
	} ?>
	<div class="hero<?php if($defininghero == true) { echo ' defining-hero'; } ?>">
		<div class="max-width">
			<h1 <?php if(is_singular('post') && $subdomain == 'www') { ?>itemprop="headline"<?php } else { ?>itemprop="name"<?php } ?>><?php if($defininghero == true) { echo '<span>'; }
					/*---------- programs ----------*/
					if(is_singular('program')) {
						global $post;
						// MJur concentrations
						if($post->post_parent == 1483915) {
							$parent_title = get_the_title($post->post_parent);
							$child_title = $post->post_title;
							echo "$parent_title - $child_title";
						// all others
						} else {
							the_title();
						}
					/*---------- category from 1 school ----------*/
					} elseif(is_archive()) {
						if(empty($_GET['school'])) {
							the_archive_title();
						} else {
							if($_GET['school'] == 'school-business') {
								$school = 'Greehey School of Business';
							} elseif($_GET['school'] == 'school-humanities') {
								$school = 'College of Arts, Humanities and Social Sciences';
							} elseif($_GET['school'] == 'school-law') {
								$school = 'School of Law';
							} elseif($_GET['school'] == 'school-set') {
								$school = 'School of Science, Engineering and Technology';
							}
							the_archive_title(); echo " Stories in the $school";
						}
					/*---------- 404 ----------*/
					} elseif(is_404()) {
						echo 'Not Found';
					} elseif(is_search()) {
						echo 'Search Results';
					} else {
						the_title();
					}
				if($defininghero == true) { echo '</span>'; } ?></h1>
			<?php /*---------- faculty titles ----------*/
			if(is_singular('faculty')) {
				$titles = get_post_meta($post->ID, 'faculty_titles', true); ?>
				<span itemprop="jobTitle"><?php echo $titles[0]; ?></span><?php
				if(count($titles) > 1) {
					for($i=1; $i<count($titles); $i++) {
						echo '&nbsp;| <span>' . $titles[$i] . '</span>';
					}
				}
			} ?>
		</div>
	</div><?php
}
?>