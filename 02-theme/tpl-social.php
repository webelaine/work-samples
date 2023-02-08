<?php
/*
 * Template Name: Social Media
 */
get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<?php if(has_blocks()) { ?><div class="stmu-single-block">
		<div class="max-width">
			<?php the_content(); ?>
		</div>
	</div><?php } ?>
	<div class="stmu-single-block">
		<div class="max-width">
			<h2>Officially Recognized St. Mary’s University Social Media Accounts</h2>
			<div class="wp-block-image"><figure class="alignright"><img src="/wp-content/uploads/2016/05/stmu-social-media-magnet.png" alt="StMU Social Media magnet with links" class="wp-image-1487167"></figure></div>
				<p>This is the place to find every social media account officially recognized by St. Mary’s University. Your organization must be affiliated with St. Mary’s in order to be included. University Communications reserves the right to determine whether pages are affiliated.</p>
				<p>To add an account, please review the <a href="/policies/university-communications/university-social-media-official-university-sites/">Social Media Policy</a> and submit a <a href="https://gateway.stmarytx.edu/group/mycampus/services/university-communications">request form</a> on Gateway.</p>
				<p>In addition to the accounts below, the University has a <a href="https://mediaspace.stmarytx.edu/">Kaltura account</a> which provides access to videos and live streaming.</p>
	<?php if(!has_blocks()) { ?></div></div><div class="stmu-single-block"><div class="max-width"><?php } ?>
			<h3 id="university">Main University Accounts</h3>
				<div class="socialDirectory">
					<?php global $wpdb;
					$socialAccounts = $wpdb->get_results("SELECT * FROM wp_social_directory WHERE parent = '0' AND section = '1' ORDER BY name");
					socialDisplayBlock($socialAccounts); ?>
				</div>
			<h3 id="schools">School Accounts</h3>
				<div class="socialDirectory">
					<?php $socialAccounts = $wpdb->get_results("SELECT * FROM wp_social_directory WHERE parent = '0' AND section = '2' ORDER BY name");
					socialDisplayBlock($socialAccounts); ?>
				</div>
			<h3 id="other">Other Accounts</h3>
				<div class="socialDirectory">
					<?php $socialAccounts = $wpdb->get_results("SELECT * FROM wp_social_directory WHERE parent = '0' AND section = '3' ORDER BY name");
					socialDisplayBlock($socialAccounts); ?>
				</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>