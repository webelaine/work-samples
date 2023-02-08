<?php if(get_post_status($post->ID) == 'publish') { ?>
			<a class="post-circle" href="<?php the_permalink(); ?>">
				<img src="<?php the_post_thumbnail_url('program'); ?>" alt="" />
				<h3><?php the_title(); ?></h3>
			</a>
<?php } ?>