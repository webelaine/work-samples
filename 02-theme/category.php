<?php get_header(); ?>
<div class="white-ghostweave page-wrapper">
    <div class="max-width with-sidebar">
        <main class="padRight" id="theContent" data-swiftype-index="true">
			<?php while (have_posts()) : the_post();
				get_template_part( 'content', 'archive' );
			endwhile; ?>
        </main>
        <aside role="complementary" aria-label="News Links">
            <div class="sidebar-widget">
                <form class="search-container">
                    <label for="st-post-search" class="show-for-sr">Search News and Spotlights only</label>
                    <input type="text" class="st-default-search-input" id="st-post-search" data-st-install-key="HRGTzKaHX_Z-1ZZPwusc" placeholder="Search news and spotlights" autocomplete="off">
                    <button type="submit" name="newssearch">&#xf002;<span class="show-for-sr">Search</span></button>
                </form>
            </div>
            <?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('in-news-sidebar')): endif; ?>
        </aside>
	</div>
    <div class="max-width"><p>
        <?php global $wp_query;
        $big = 999999999; // need an unlikely integer
        $translated = __( 'Page', 'mytextdomain' ); // Supply translatable string
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
                'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
        ) ); ?>
    </p></div>
</div>
<?php get_footer(); ?>