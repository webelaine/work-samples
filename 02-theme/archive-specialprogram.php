<?php get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<div class="stmu-single-block">
		<div class="max-width">
			<p>Beyond the course curriculum, St. Mary’s Law equips students with lawyering skills and real-life experiences through our special programs. Our students are national champions in moot court and mock trial competitions and gain hands-on legal experience representing San Antonio’s indigent and disadvantaged citizens.</p>
		</div>
	</div>
	<div class="stmu-single-block">
		<div class="max-width">
			<div class="post-circles">
			<?php
				$specialPrograms = get_posts(array(
						'post_type' => 'specialprogram',
						'numberposts' => -1,
						'posts_per_page' => -1,
						'order' => 'ASC',
						'orderby' => 'title',
						'post_status' => 'publish',
						'post_parent' => 0	// only get top-level special programs, not children
					)
				);
				foreach($specialPrograms as $specialProgram) {
					$id = $specialProgram->ID;
					$imgID = get_post_thumbnail_id($id);
					if(!$imgID) {
						$imgInfo[0] = get_site_icon_url('200');
					} else {
						$imgInfo = wp_get_attachment_image_src($imgID, 'program');
					}
					echo '<a class="post-circle" href="' . get_permalink($id) . '"><img src="' . $imgInfo[0] .'" alt="" /><h3>' . $specialProgram->post_title . '</h3></a>';
				}
			?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>