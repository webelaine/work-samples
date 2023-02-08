<?php global $subdomain; get_header(); ?>
<script>
	(function($){
		$(document).ready(function(){
			$("#secondary-nav a").addClass('school-nav');
		});
		$(document).ready(function(){
			$(".childNav a").each(function() {           
				$(this).html($(this).html().replace(" - Greehey School of Business",""));
				$(this).html($(this).html().replace(" of the Greehey School of Business",""));
			});
			$(".childNav li").each(function() {           
				$(this).html($(this).html().replace(" - Greehey School of Business",""));
				$(this).html($(this).html().replace(" of the Greehey School of Business",""));
			});
			$("#breadcrumbs span").each(function() {
				$(this).html($(this).html().replace(" – Greehey School of Business",""));
				$(this).html($(this).html().replace(" of the Greehey School of Business",""));
			});
		});
	})(jQuery);
</script>
<div class="white-ghostweave page-wrapper">
    <div class="max-width with-sidebar">
		<aside class="padRight" role="navigation" aria-label="In This Section">
			<?php
			// School Banner
			// need to set school, otherwise it doesn't show up
			get_template_part('school-banner');
			// Related Pages
			$related = get_field('related_posts');
			if($related) {
				echo showRelatedPages($related);
			}
			// Leftnav
			get_template_part('child-nav');
			wp_link_pages();
			?>
		</aside>
		<main id="theContent" data-swiftype-index="true">
			<?php the_content(); ?>
		</main>
	</div>
</div>
<?php get_footer(); ?>