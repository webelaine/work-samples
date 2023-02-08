<?php
get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">

	<?php the_content(); ?>

	<?php // Programs
	$posts = get_field('relationship_programdepartment');
	if($posts) { ?>
	<div class="stmu-single-block">
		<div class="max-width">
			<h2 id="programs"><i class="fa fa-graduation-cap" aria-hidden="true"> </i> Academic Programs in the <?php the_title(); ?></h2>
		</div>
		<div class="max-width post-circles">
			<?php $i=1; foreach($posts as $post):
			setup_postdata($post);
			if($post->post_status == 'publish') {
				get_template_part('post-circle');
			}
			$i++;
			endforeach; ?>
		</div>
	</div>
	<?php } wp_reset_postdata(); ?>

	<?php // Faculty
	$posts = get_field('relationship_facultydepartment');
	if($posts) { ?>
		<div class="stmu-single-block">
			<div class="max-width">
				<h2 id="faculty"><i class="fa fa-users" aria-hidden="true"></i> Faculty in the <?php the_title(); ?></h2>
				<ul class="bordered-box faculty-list">
				<?php foreach($posts as $post) {
					setup_postdata($post);
					if(!is_null($post) && $post->post_status == 'publish') { // Only display if the post still exists.
						setup_postdata($post);
						$facultyTitles = get_post_meta($post->ID, 'faculty_titles', true);
						if(has_post_thumbnail($post->ID)) {
							$image_url = get_the_post_thumbnail_url($post->ID, 'thumbnail');
						} else {
							$image_url = "/wp-content/themes/stmu-parent/images/no-photo-available.png";
						}
						echo '<li itemprop="employee" itemscope itemtype="https://schema.org/Person" class="wp-block-stmu-bordered-box-item">
							<a itemprop="url" href="' . get_the_permalink($post->ID) . '">
								<img src="' . $image_url . '" alt="' . get_the_title($post->ID) . '" />
								<div>
									<span itemprop="name">' . get_the_title($post->ID) . '</span>
									<span itemprop="jobTitle">' . $facultyTitles[0] . '</span>
								</div>
							</a>
						</li>';
					}
				} ?>
				</ul>
			</div>
		</div>
	<?php } wp_reset_postdata(); ?>

</main>
<?php get_footer(); ?>