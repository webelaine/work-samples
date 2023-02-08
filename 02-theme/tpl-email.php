<?php
/*
 * Template Name: Email
 * Template Post Type: page
 */
// require "emailId" and "to" ("emailId" tells MS Flow who to send to, and "to" displays the name on this page)
if(empty($_GET['emailId']) || empty($_GET['to'])) {
	wp_redirect('/', 302);
} else {
	get_header(); ?>
	<div class="white-ghostweave page-wrapper">
		<main class="max-width" id="theContent" data-swiftype-index="true">
			<p><strong>To:</strong> <?php echo urldecode($_GET['to']); ?></p>
			<?php echo do_shortcode("[gravityforms id=131 title=false]"); ?>
		</main>
	</div>
	<?php get_footer();
} ?>