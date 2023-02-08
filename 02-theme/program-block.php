<?php if(get_post_status($post->ID) == 'publish') { ?>
			<div class="column column-block text-center programBlock <?php if($i==count($posts)) { echo ' end'; } ?>">
				<a href="<?php the_permalink(); ?>">
					<div class="circle">
						<img src="<?php the_post_thumbnail_url('program'); ?>" alt="<?php the_title(); ?>" />
					</div>
					<h3><?php the_title(); ?></h3>
				</a>
			</div>
<?php } ?>