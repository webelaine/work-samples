<?php get_header(); ?>
<div class="white-ghostweave page-wrapper">
    <div class="max-width with-sidebar">
        <main class="padRight" id="theContent" data-swiftype-index="true">
            <?php
                the_date('', '<p itemprop="datePublished">', '</p>');
                the_content();
            ?>
        </main>
        <aside role="complementary" aria-label="News Links">
            <?php if(!function_exists('register_sidebar') || !dynamic_sidebar('blog-sidebar')): endif; ?>
        </aside>
    </div>
    <?php // WWW Posts
    if($subdomain == 'www') {
        // Magazine: "This Issue" and "Next Story" links
        $issue = wp_get_post_terms(get_the_ID(), 'issue');
        if(count($issue) > 0) { ?>
            <div class="nextprev">
                <div class="max-width half-half">
                    <div>
                        <a href="/magazine/?issue=<?php echo $issue[0]->term_id; ?>">More from the <?php echo $issue[0]->name; ?> <span class="nowrap">Issue &gt;</span></a>
                    </div>
                    <div class="text-right">
                        <?php $next = get_next_post_link( '%link', 'Next story &gt;', true, '', 'issue');
                            // If we're already on the newest (farthest Next) Post, link to the category
                            if(empty($next)) {
                                $next = '<a href="/magazine/">See all issues &gt;</a>';
                            }
                            echo $next;
                        ?>
                    </div>
                </div>
            </div>
        <?php } // end Magazine links
        // Read More Stories
        $currentid = get_the_ID();
        $postArgs = array(
            'post_type' => 'post',
            'post__not_in' => array($currentid), // exclude current post
            'posts_per_page' => 12,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_key' => '_thumbnail_id', // only grab posts with a featured image
            'no_found_rows' => 'true',
            '_shuffle_and_pick' => 4 // custom attribute (functions.php) to get 4 random posts from the initial query of 12 latest
        );
        $postQuery = new WP_Query($postArgs);
        if($postQuery->have_posts()) { ?>
            <div class="max-width">
                <h2 id="recommended">Read More Stories</h2>
                <div class="post-connector" role="complementary" aria-label="More Stories"><?php
                while($postQuery->have_posts()) : $postQuery->the_post();
                    $postImgID = get_post_thumbnail_id($post->ID);
                    $postAlt = get_post_meta($postImgID, '_wp_attachment_image_alt', true); ?>
                    <a class="post-item test-headline" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url('spotlight'); ?>');">
                        <h3 class="overlay"><?php the_title(); ?></h3>
                    </a><?php
                endwhile; ?>
                </div>
            </div><?php
        }
    } // end WWW Posts ?>
</div>
<?php get_footer(); ?>