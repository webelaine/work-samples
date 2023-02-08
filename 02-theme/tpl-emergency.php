<?php
/*
 * Template Name: Emergency Notifications
 */
get_header(); ?>
<div class="white-ghostweave page-wrapper">
	<main class="max-width" id="theContent" data-swiftype-index="true">
		<?php
			the_date('', '<p itemprop="datePublished">Last updated ', '</p>');
			$thecontent = get_the_content();
			if(!empty($thecontent)) {
				the_content();
			} else {
				echo '<p>There are no emergency notifications at this time. Please bookmark this page and check back for updates.</p>';
			}
		?>
	</main>
</div>
<?php get_footer(); ?>