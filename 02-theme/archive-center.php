<?php get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<div class="stmu-single-block">
		<div class="max-width">
			<?php the_field('centers_content', 'option'); ?>
		</div>
	</div>
	<?php
	if(have_posts()) {
		while(have_posts()): the_post();
			if(has_excerpt()) {
				$excerpt = get_the_excerpt();
			} else {
				$excerpt = 'Missing excerpt';
			}
			echo '<div class="stmu-single-block"><div class="max-width"><p><a href="' . get_the_permalink() . '">' . get_the_title() . '</a> - ' . $excerpt . '</p></div></div>';
		endwhile;
	}
	?>
</main>
<?php get_footer(); ?>