<?php get_header(); ?>
<div class="white-ghostweave page-wrapper">
    <main class="max-width" id="theContent" data-swiftype-index="true">
		<?php if(have_posts()):
			while(have_posts()): the_post();
				the_content();
			endwhile;
		endif; ?>
	</main>
</div>
<?php get_footer(); ?>