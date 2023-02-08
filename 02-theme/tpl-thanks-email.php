<?php
/*
 * Template Name: Thanks - Email
 */
if(empty($_GET['emailId'])) {
	wp_redirect(home_url(), 301);
	exit;
} else {
	get_header(); ?>
	<div class="white-ghostweave page-wrapper">
		<main class="max-width" id="theContent">
			<p>Thank you, your message has been sent.</p>
		</main>
	</div>
	<?php get_footer();
} ?>