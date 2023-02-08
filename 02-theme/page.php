<?php get_header(); ?>
<?php // Script in both tpl-law-career.php & page.php
global $subdomain; if($subdomain == 'law') { ?>
<script>
	$(document).ready(function(){
		$("#secondary-nav a").addClass('school-nav');
	});
    $(document).ready(function(){
        $(".childNav a").each(function() {           
            $(this).html($(this).html().replace("Law Career Services for ",""));
        });
        $(".childNav li").each(function() {
            $(this).html($(this).html().replace("Law Career Services for ",""));
        });
        $("#breadcrumbs span").each(function() {
            $(this).html($(this).html().replace("Law Career Services for ",""));
        });
    });
</script>
<?php } ?>
<div class="white-ghostweave page-wrapper">
    <div class="max-width with-sidebar">
		<aside class="padRight" role="navigation" aria-label="In This Section">
			<?php
			// Law Admission contact info
			global $subdomain;
			if($subdomain == 'law' && is_page('admission')) { ?>
				<h2 id="contact-us"><i class="fa fa-cog" aria-hidden="true"></i> Contact Us</h2><a href="tel:210-436-3523">210-436-3523</a>
				<a href="mailto:lawadmissions@stmarytx.edu">lawadmissions@stmarytx.edu</a><?php
			}
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