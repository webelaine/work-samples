<article id="post-<?php the_ID(); ?>" <?php post_class('archiveItem'); ?>>
	<div class="cal">
		<span class="calMonth"><?php the_time('M'); ?></span>
		<span class="calDay"><?php the_time('j'); ?></span>
		<span class="calYear"><?php the_time('Y'); ?></span>
	</div>
	<?php if(has_post_thumbnail()) {
		$imgID = get_post_thumbnail_id();
		$altText = get_post_meta($imgID, '_wp_attachment_image_alt', true);
		?><img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="<?php echo $altText; ?>" itemprop="image" width="150" height="150" /><?php
	} ?>
	<?php the_title( sprintf( '<a href="%s" rel="bookmark"><h2 id="post-%s">', esc_url( get_permalink()), get_the_ID()), '</h2></a>' );
	the_excerpt(); ?>
</article>