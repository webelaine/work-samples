<?php get_header(); ?>
<script>
	$(document).ready(function(){
		$(".childNav a").each(function() {
			$(this).html($(this).html().replace(" - Center for Catholic Studies",""));
		});
		$(".childNav li").each(function() {
			$(this).html($(this).html().replace(" - Center for Catholic Studies",""));
		});
		$("#breadcrumbs span").each(function() {
			$(this).html($(this).html().replace(" - Center for Catholic Studies",""));
		});
	})
</script>
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
			wp_link_pages();
			// Centers Sidebar
			echo apply_filters('the_content', get_field('sidebar_content'));
			?>
		</aside>
		<main id="theContent" data-swiftype-index="true">
			<?php the_content(); ?>
		</main>
	</div>
</div>
<?php get_footer(); ?>