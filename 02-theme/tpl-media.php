<?php
/*
 * Template Name: In the Media
 */
get_header(); ?>
<?php get_header(); ?>
<div class="white-ghostweave page-wrapper">
    <div class="max-width with-sidebar">
        <main class="padRight" id="theContent" data-swiftype-index="true">
			<?php while (have_posts()) : the_post();
				the_content();
			endwhile; ?>
        </main>
        <aside role="complementary" aria-label="Media Links">
		<?php if (!function_exists('register_sidebar') || !dynamic_sidebar('ext-news-sidebar')): endif; ?>
        </aside>
	</div>
</div>
<?php get_footer(); ?>