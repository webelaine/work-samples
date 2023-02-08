<?php
get_header(); ?>
<div class="white-ghostweave page-wrapper">
	<main class="max-width" id="theContent" data-swiftype-index="true">
		<?php
		if(have_posts()) { ?>
			<div class="max-width">
				<div class="post-connector">
				<?php while(have_posts()) : the_post(); ?>
					<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php
						if(has_post_thumbnail()) {
							the_post_thumbnail_url('spotlight');
						} else {
							echo get_site_icon_url('200');
						} ?>');">
						<div class="overlay"><?php the_title(); ?></div>
					</a>
					<?php endwhile; ?>
				</div>
			</div><?php
		} ?>
	</main>
</div>
<?php get_footer(); ?>