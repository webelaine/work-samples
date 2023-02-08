<?php
// RSS feed for "news" category, specifically for MyStMU App
header('Content-Type: ' . feed_content_type('atom') . '; charset=' . get_option('blog_charset'), true); ?>
<?xml version="1.0" encoding="<?php echo get_option('blog_charset'); ?>" ?>
<?php do_action( 'rss_tag_pre', 'atom' ); ?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" <?php do_action( 'atom_ns' );?>>
	<channel>
		<title><?php wp_title_rss(); ?></title>
		<link><?php self_link(); ?></link>
		<description><?php bloginfo_rss("description"); ?></description>
		<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
		<language><?php bloginfo_rss( 'language' ); ?></language>
		<ttl>60</ttl>
<?php while ( have_posts() ) { the_post(); ?>
		<item>
			<title><![CDATA[<?php the_title_rss() ?>]]></title>
			<link><?php the_permalink_rss(); ?></link>
			<guid><?php the_guid(); ?></guid>
			<?php the_category_rss('rss'); ?>
			<description><![CDATA[<?php the_content(); ?>]]></description>
			<?php if ( has_post_thumbnail( $post->ID ) ){
				$thumb = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
				$full  = get_the_post_thumbnail_url( $post->ID, 'large' );
				$alt   = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
			} else {
				$thumb = get_site_icon_url('thumbnail');
				$full  = get_site_icon_url('large');
				$alt   = 'St. Louis Hall apex';
			} ?><thumbnail url="<?php echo $thumb; ?>" />
			<content url="<?php echo $full; ?>">
				<title><?php print_r($alt); ?></title>
			</content>
			<pubDate><?php echo get_post_time('r', true); ?></pubDate><?php atom_enclosure(); do_action( 'atom_entry' ); ?>

		</item>
<?php } ?>
	</channel>
</rss>