<?php
/*
 * Template Name: Fancy Page
 * Template Post Type: page
 */
get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true"<?php if($subdomain == 'www' && is_page('1076')) { ?> lang="es"<?php } ?>>
	<?php the_content(); ?>
</main>
<?php get_footer(); ?>