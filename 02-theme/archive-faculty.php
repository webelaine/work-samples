<?php
$subdomain = get_option('stmu_subdomain');
if(get_field('faculty_hero_image', 'option')) {
	$hero_image = get_field('faculty_hero_image', 'option');
}
if(get_field('faculty_hero_header', 'option')) {
	$hero_h1 = get_field('faculty_hero_header', 'option');
}
// Faculty are pulled in the MAIN QUERY via functions.php.
// only get Administration, Instructors, Practicing Faculty, and Staff on the law site
if($subdomain == 'law') {
	// Administration
	$args = array(
		'no_found_rows' => true,
		'post_type' => 'faculty',
		'meta_key' => 'faculty_last',
		'order' => 'ASC',
		'orderby' => 'meta_value',
		'meta_query' => array(
			array('key' => 'faculty_type',
					'value' => 'administration',
					'compare' => '=',
				),
			),
	);
	$administration = new WP_Query($args);
	// Instructors
	$args = array(
		'no_found_rows' => true,
		'post_type' => 'faculty',
		'meta_key' => 'faculty_last',
		'order' => 'ASC',
		'orderby' => 'meta_value',
		'meta_query' => array(
			array('key' => 'faculty_type',
					'value' => 'instructor',
					'compare' => '=',
				),
			),
	);
	$instructors = new WP_Query($args);
	// Practicing Faculty (marked as Adjuncts in the database)
	$args = array(
		'no_found_rows' => true,
		'post_type' => 'faculty',
		'meta_key' => 'faculty_last',
		'order' => 'ASC',
		'orderby' => 'meta_value',
		'meta_query' => array(
			array('key' => 'faculty_type',
					'value' => 'adjunct',
					'compare' => '=',
				),
			),
	);
	$adjuncts = new WP_Query($args);
	// Staff
	$args = array(
		'no_found_rows' => true,
		'post_type' => 'faculty',
		'meta_key' => 'faculty_last',
		'order' => 'ASC',
		'orderby' => 'meta_value',
		'meta_query' => array(
			array('key' => 'faculty_type',
					'value' => 'staff',
					'compare' => '=',
				),
			),
	);
	$staff = new WP_Query($args);
}
get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<?php // If there is intro text, display it
	if(get_field('faculty_content', 'option')) { ?>
		<div class="stmu-single-block">
			<div class="max-width">
				<p><?php the_field('faculty_content', 'option'); ?></p>
			</div>
		</div>
	<?php }
	if($subdomain == 'law') {
	//////////////// Administration
		if($administration->have_posts()) { ?>
		<div class="stmu-single-block">
			<div class="max-width">
				<h2 id="administration">Administration</h2>
				<div class="post-connector">
					<?php while($administration->have_posts()) : $administration->the_post();
					$facultyTitles = get_post_meta($post->ID, 'faculty_titles', true);
					if(has_post_thumbnail()) {
						$image_url = get_the_post_thumbnail_url('', 'spotlight');
					} else {
						$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
					} ?>
						<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $image_url; ?>');">
							<div class="overlay">
								<h3><?php the_title(); ?></h3>
								<p><?php echo $facultyTitles[0]; ?></p>
							</div>
						</a>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
		<?php
		} wp_reset_postdata();
	}
	// Faculty
	if(have_posts()) { ?>
	<div class="stmu-single-block">
		<div class="max-width">
			<h2 id="faculty">Faculty</h2>
			<div class="post-connector">
				<?php while(have_posts()) : the_post();
					$facultyTitles = get_post_meta($post->ID, 'faculty_titles', true);
					if(has_post_thumbnail()) {
						$image_url = get_the_post_thumbnail_url('', 'spotlight');
					} else {
						$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
					} ?>
					<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $image_url; ?>');">
						<div class="overlay">
							<h3><?php the_title(); ?></h3>
							<p><?php echo $facultyTitles[0]; ?></p>
						</div>
					</a>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
	<?php
	}
	if($subdomain == 'law') {
//////////////// Instructors
		if($instructors->have_posts()) { ?>
		<div class="stmu-single-block">
			<div class="max-width">
				<h2 id="instructors">Instructors</h2>
				<div class="post-connector">
					<?php while($instructors->have_posts()) : $instructors->the_post();
						$facultyTitles = get_post_meta($post->ID, 'faculty_titles', true);
						if(has_post_thumbnail()) {
							$image_url = get_the_post_thumbnail_url('', 'spotlight');
						} else {
							$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
						} ?>
						<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $image_url; ?>');">
							<div class="overlay">
								<h3><?php the_title(); ?></h3>
								<p><?php echo $facultyTitles[0]; ?></p>
							</div>
						</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<?php
		}
//////////////// Adjuncts
		if($adjuncts->have_posts()) { ?>
		<div class="stmu-single-block">
			<div class="max-width">
				<h2 id="practicing">Practicing Faculty</h2>
				<div class="post-connector">
					<?php while($adjuncts->have_posts()) : $adjuncts->the_post();
						$facultyTitles = get_post_meta($post->ID, 'faculty_titles', true);
						if(has_post_thumbnail()) {
							$image_url = get_the_post_thumbnail_url('', 'spotlight');
						} else {
							$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
						} ?>
						<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $image_url; ?>');">
							<div class="overlay">
								<h3><?php the_title(); ?></h3>
								<p><?php echo $facultyTitles[0]; ?></p>
							</div>
						</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<?php
		}
//////////////// Staff
		if($staff->have_posts()) { ?>
		<div class="stmu-single-block">
			<div class="max-width">
				<h2 id="staff">Staff</h2>
				<div class="post-connector">
					<?php while($staff->have_posts()) : $staff->the_post();
						$facultyTitles = get_post_meta($post->ID, 'faculty_titles', true);
						if(has_post_thumbnail()) {
							$image_url = get_the_post_thumbnail_url('', 'spotlight');
						} else {
							$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
						} ?>
						<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $image_url; ?>');">
							<div class="overlay">
								<h3><?php the_title(); ?></h3>
								<p><?php echo $facultyTitles[0]; ?></p>
							</div>
						</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<?php
		}
	} ?>
</main>
<?php get_footer(); ?>