<?php
/*
 * Template Name: Thanks - Info
 */
if(empty($_GET['lawprogram'])) {
	wp_redirect(home_url(), 301);
	exit;
} else {
	get_header(); ?>
	<div class="white-ghostweave page-wrapper">
		<main class="max-width" id="theContent">
			<p>Thank you! We have received your request and will be in touch shortly.</p>
			<?php if($_GET['lawprogram'] == 'jd') { ?>
				<a class="apply-btn" href="/admission/applying-j-d/">Learn how to apply</a>
			<?php } elseif($_GET['lawprogram'] == 'llm') { ?>
				<a class="apply-btn" href="/admission/applying-ll-m/">Learn how to apply</a>
			<?php } else { ?>
				<a class="apply-btn" href="/admission/applying-m-jur/">Learn how to apply</a>
			<?php } ?>
				<a class="ghost-btn" href="/academics/about/">Learn more about St. Mary's Law</a>
		</main>
	</div>
	<?php get_footer();
} ?>