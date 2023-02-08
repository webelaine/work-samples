<?php $siteurl = site_url();
if(
	// Policy Library: show everywhere
	(
		substr($siteurl, 7, 6) == 's29372'
		||
		substr($siteurl, 8, 25) == 'www.stmarytx.edu/policies'
	)
	||
	// Other sites: show everywhere except homepage
	(!is_home() && !is_front_page())
) { ?>
	<div class="breadcrumbs">
		<div class="max-width">
			<?php if(function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
		</div>
	</div><?php
} ?>