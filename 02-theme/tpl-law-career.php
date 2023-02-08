<?php
/*
 * Template Name: Law Careers
 */
get_header(); ?>
<?php // Script in both tpl-law-career.php & page.php
global $subdomain; if($subdomain == 'law') { ?>
<script>
	$(document).ready(function(){
		$("#secondary-nav a").addClass('school-nav');
	});
    $(document).ready(function(){
        $(".childNav a").each(function() {           
            $(this).html($(this).html().replace("Law Career Services for ",""));
        });
        $(".childNav li").each(function() {
            $(this).html($(this).html().replace("Law Career Services for ",""));
        });
        $("#breadcrumbs span").each(function() {
            $(this).html($(this).html().replace("Law Career Services for ",""));
        });
    });
</script>
<?php } ?>
<div class="white-ghostweave page-wrapper">
	<div class="max-width with-sidebar">
		<aside class="padRight" role="navigation" aria-label="In This Section">
			<?php
			// Related Pages
			$related = get_field('related_posts');
			if($related) {
				echo showRelatedPages($related);
			}
			// Leftnav
			get_template_part('child-nav');
			wp_link_pages(); ?>
			<h2><i class="fa fa-users"></i> Success Stories</h2>
			<ul class="childNav">
				<?php
					// Only show Alumni Profiles if some exist
					$args = array('post_type' => 'aprofile');
					$aprofiles = new WP_Query($args);
					if($aprofiles->have_posts()) { ?>
					<li><a href="/career-services/alumni-profiles/">Alumni Profiles</a></li>
				<?php } ?>
				<li><a href="/career-services/student-profiles/">Student Profiles</a></li>
			</ul>
		</aside>
		<main id="theContent" data-swiftype-index="true">
			<?php the_content(); ?>
			<?php
			// 'Alumni Profile' post type query
			$args = array(
				'no_found_rows' => true,
				'post_type' => 'aprofile',
				'posts_per_page' => 10,
				'_shuffle_and_pick' => 3, // custom attribute (functions.php) to get 3 random posts from the initial query
				'meta_key' => '_thumbnail_id', // only get profiles with images
			);
			$profiles = new WP_Query($args);
			if($profiles->have_posts()) : ?>
				<h2 id="our-alumni"><i class="fa fa-users"></i> Graduate Success Stories</h2>
				<div class="post-connector"><?php
				while($profiles->have_posts()) : $profiles->the_post(); ?>
					<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url('spotlight'); ?>');">
						<div class="overlay"><?php the_title(); ?></div>
					</a><?php
				endwhile; ?>
				</div>
				<a class="ghost-btn" href="/career-services/alumni-profiles/">View All Alumni Profiles</a><?php
			endif;
			wp_reset_postdata();
		?>
		<?php
			// 'Student Profile' post type query
			$args = array(
				'no_found_rows' => true,
				'post_type' => 'sprofile',
				'posts_per_page' => 10,
				'_shuffle_and_pick' => 3, // custom attribute (functions.php) to get 3 random posts from the initial query
				'meta_key' => '_thumbnail_id', // only get profiles with images
			);
			$profiles = new WP_Query($args);
			if($profiles->have_posts()) : ?>
				<h2 id="our-students"><i class="fa fa-users"></i> See what our students are doing</h2>
				<div class="post-connector"><?php
				while($profiles->have_posts()) : $profiles->the_post(); ?>
					<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url('spotlight'); ?>');">
						<div class="overlay"><?php the_title(); ?></div>
					</a><?php
				endwhile; ?>
				</div>
				<a class="ghost-btn" href="/career-services/student-profiles/">View all student profiles</a><?php
			endif;
			wp_reset_postdata();
		?>
		</main>
	</div>
</div>
<?php get_footer(); ?>