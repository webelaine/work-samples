<?php $subdomain = get_option('stmu_subdomain'); ?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
<head>
<?php $siteurl = get_site_url();
if(($subdomain == 'www' || $subdomain == 'law') && (substr($siteurl, 0, 8) != 'http://s')) { ?>
	<!-- GTM WWW / Law / Policies / excludes Staging -->
	<script>
	(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;
	h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
	(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);
	})(window,document.documentElement,'async-hide','dataLayer',2000,{'GTM-TNC7WF':true});
	</script>
<?php } elseif(
		$subdomain == 'www' && (substr($siteurl, 0, 8) == 'http://s' && substr($siteurl, 7, 6) != 's29372')
		||
		$subdomain == 'law' && (substr($siteurl, 0, 8) == 'http://s')
	) { ?>
	<!-- GTM Staging, but not PolicyStaging -->
	<script>
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-525ZDM');
	</script>
<?php } elseif($subdomain == 'law.alumni' || $subdomain == 'alumni') { ?>
	<!-- GTM Alumni -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5SCLTQ');</script>
<?php } ?>
<?php // Enable A/B testing on www Admission and www Graduate Admission pages
/* if($subdomain == 'www' && is_page(array('admission', 1488267))) { ?>
	<!-- Google Optimize: commented out when not running an experiment -->
	<style>.async-hide { opacity: 0 !important} </style>
	<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
	h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
	(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
	})(window,document.documentElement,'async-hide','dataLayer',4000,
	{'GTM-TNC7WF':true});</script>
	<!-- end Google Optimize -->
<?php } */ ?>
<meta charset="UTF-8" /><?php if($subdomain == 'www') {
	if(is_page('1066') || is_page('1076')) { ?><link rel="alternate" href="https://www.stmarytx.edu/outreach/consejeria/" hreflang="es" />
	<link rel="alternate" href="https://www.stmarytx.edu/outreach/counseling/" hreflang="en" /><?php } ?>
	<meta property="fb:pages" content="31373936394" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
if(($subdomain == 'www' || $subdomain == 'law' || $subdomain == 'alumni') && is_front_page()) { ?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type" : "WebSite",
	"name" : "<?php echo bloginfo('name'); ?>",
	"url" : "<?php echo site_url(); ?>",
	"potentialAction": {
		"@type": "SearchAction",
		"target": "<?php echo site_url(); ?>/search-results/#stq={search_term_string}&stp=1",
		"query-input": "required name=search_term_string"
	}
}
</script>
<?php
}
if(has_post_thumbnail()) {
	echo '<meta class="swiftype" name="image" data-type="enum" content="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '" />';
}
if(is_singular('program')) { ?>
<meta class="swiftype" name="keywords" data-type="string" content="<?php $interests = wp_get_post_terms($post->ID, 'interest', array("fields" => "names")); foreach($interests as $interest) { $interestList .= "$interest,"; } echo substr($interestList, 0, -1); ?>" />
<meta class="swiftype" name="title" data-type="string" content="<?php the_title(); ?>" />
<?php $meta = array();
		$online = $post->available_online; if($online == '1') { $meta[] = 'online'; }
		$evening = $post->available_evening; if($evening == '1') { $meta[] = 'evening'; }
		for($i=0; $i<count($meta); $i++) { ?>
<meta class="swiftype" name="tags" data-type="string" content="<?php echo $meta[$i]; ?>" />
<?php } } ?>
<?php wp_head(); ?>
<style type="text/css">
<?php if(has_custom_logo()) { $image = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'large'); } else { $image = '/wp-content/themes/stmu-parent/images/plain-logo-white.png'; } ?>
@media screen and (min-width:65em) and (hover:hover) and (pointer:fine) {
	.headerContainer nav ul.menu>li:first-child {
		background:url('<?php echo $image; ?>') center 17px no-repeat, url("data:image/svg+xml,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20width%3D%27220px%27%20height%3D%27475px%27%3E%3Cpolygon%20points%3D%270%2C0%200%2C90%20110%2C110%20220%2C90%20220%2C0%27%20fill%3D%27%23999%27%20stroke%3D%27%23999%27%2F%3E%3Cpolygon%20points%3D%270%2C0%200%2C89%20110%2C109%20220%2C89%20220%2C0%27%20fill%3D%27%23036%27%20stroke%3D%27%23036%27%2F%3E%3C%2Fsvg%3E") no-repeat; 
	}
	.headerContainer nav.sticky ul.menu>li:first-child {
		background:url('<?php echo $image; ?>') center 36px no-repeat, url("data:image/svg+xml,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20width%3D%27220px%27%20height%3D%27500px%27%3E%3Cpolygon%20points%3D%270%2C0%200%2C100%20110%2C125%20220%2C100%20220%2C0%27%20fill%3D%27%23999%27%20stroke%3D%27%23999%27%2F%3E%3Cpolygon%20points%3D%270%2C0%200%2C99%20110%2C124%20220%2C99%20220%2C0%27%20fill%3D%27%23036%27%20stroke%3D%27%23036%27%2F%3E%3C%2Fsvg%3E") no-repeat;
	}
.async-hide {opacity:0 !important}
}
@media print{.show-for-print{display:block!important;nav,.hello-bar,.hide,.hidePrint,.skipLink,.sticky-header,button,#print-page-link,#smoothup,.wp-block-embed,footer{display:none!important}@page{margin:1in}body,p{font:15pt/1.5 arial,sans-serif}body{width:100%;margin:0;padding:0;background:#fff}body,a{color:#000}a:link:after{content:" ("attr(href)")"}.wp-block-button__link { background:#fff;color:#000;border:1px solid #999}.breadcrumbs,footer,aside,video{display:none!important}h1,h2,h3,h4,h5,h6,h2.policyMeta{font-family:'times new roman',times,serif;line-height:130%}h1{margin-top:0;text-align:center;border-top:1px solid #999;border-bottom:1px solid #999}h2{font-size:1.5rem}img{float:left;width:100px;height:auto;margin:15px}h2.policyMeta{margin:5px 0;font-size:1em}ul,ol{margin-left:2em}ul.bordered-box{margin-left:0;padding-left:0;list-style-type:none}ul.bordered-box>li{margin-bottom:30px;padding:0 15px}ul.bordered-box, .wp-block-stmu-icon-heading{page-break-inside:avoid}details{margin-bottom:30px;padding:15px 15px 0;border:1px solid #999}}
</style>
</head>
<body <?php
if(has_blocks()) { $added_class = 'has-blocks'; }
body_class("$subdomain $added_class"); if($subdomain == 'www' || $subdomain == 'alumni') { ?> itemscope itemtype="http://schema.org/CollegeOrUniversity"<?php } elseif($subdomain == 'law' || $subdomain == 'law.alumni') { ?> itemscope itemtype="http://schema.org/School"<?php } ?>>
<?php $siteurl = get_site_url();
if(($subdomain == 'www' || $subdomain == 'law') && (substr($siteurl, 0, 8) != 'http://s')) { ?>
	<!-- "noscript" for GTM WWW / Law / Policies / excludes Staging -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TNC7WF"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TNC7WF');</script>
<?php } elseif(
		$subdomain == 'www' && (substr($siteurl, 0, 8) == 'http://s' && substr($siteurl, 7, 6) != 's29372')
		||
		$subdomain == 'law' && (substr($siteurl, 0, 8) == 'http://s')
	) { ?>
	<!-- "noscript" for GTM Staging, but not PolicyStaging -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-525ZDM"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php } elseif($subdomain == 'law.alumni' || $subdomain == 'alumni') { ?>
	<!-- "noscript" for GTM Alumni -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5SCLTQ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5SCLTQ');</script>
<?php } if($subdomain == 'www' || $subdomain == 'law' || $subdomain == 'law.alumni' || $subdomain == 'alumni') { ?>
<div class="hide">
	<span itemprop="name" class="show-for-sr hidePrint"><?php bloginfo('name'); ?></span>
	<span itemprop="address" class="show-for-sr hidePrint" itemscope itemtype="http://schema.org/PostalAddress">
		<span itemprop="streetAddress">1 Camino Santa Maria</span> <span itemprop="addressLocality">San Antonio</span>, <span itemprop="addressRegion">TX</span> <span itemprop="postalCode">78228</span>
	</span>
	<span itemprop="telephone" class="show-for-sr hidePrint">+1-210-436-3011</span>
	<span itemprop="url" class="show-for-sr hidePrint"><?php echo site_url(); ?></span>
	<img itemprop="logo" class="show-for-sr" src="<?php echo $image; ?>" alt="<?php bloginfo('name'); ?> logo" />
	<?php if($subdomain == 'www') { ?>
		<span itemprop="founder" class="show-for-sr hidePrint" itemscope itemtype="http://schema.org/Person"><a itemprop="sameAs" class="hide" href="https://en.wikipedia.org/wiki/William_Joseph_Chaminade"><span itemprop="name">William Joseph Chaminade</span></a></span>
		<link itemprop="sameAs" class="show-for-sr hidePrint" href="https://en.wikipedia.org/wiki/St._Mary's_University,_Texas" />
	<?php } else { ?>
		<span itemprop="parentOrganization" class="show-for-sr hidePrint">
			<span itemprop="name">St. Mary's University</span>
		</span>
	<?php } ?>
</div>
<?php } // end law/www ?>
<a class="show-on-focus skipLink" href="#theContent" tabindex="1">Skip to main content</a>
<?php if($subdomain == 'www' || $subdomain == 'law') {
	// Emergency or Seasonal Message (i.e. Christmas Break): WWW & LAW full website
	$startEvent = strtotime(get_field('main_emergency_start', 'option'));
	if($startEvent) {
		$endEvent = strtotime(get_field('main_emergency_end', 'option'));
		$emergencyShow = 0;
		$todaysDate = strtotime('now');
		// If an end date is set
		if($endEvent) {
			// If start date is before today or today; and if today is before end date
			if($startEvent <= $todaysDate && $todaysDate <= $endEvent) {
				$emergencyShow = 1;
			}
		// Else no end date is set
		} else {
			// If start date is before today, or equals today
			if($startEvent <= $todaysDate) {
				$emergencyShow = 1;
			}
		}
		// If we're within the set dates, show the Emergency/Seasonal message
		if($emergencyShow == 1) { ?>
			<div class="hello-bar">
				<div class="max-width text-center">
					<?php the_field('main_emergency_text', 'option'); ?>
				</div>
			</div>
		<?php
		}
	}
} ?>
<header id="header" class="headerContainer" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
<?php if(is_front_page()) { ?>
	<div id="side-btn">
		<a href="<?php the_field('homepage_side_button_url', 'option'); ?>"><?php the_field('homepage_side_button_text', 'option'); ?></a>
	</div>
<?php } ?>
	<div class="sticky-header" id="stickyHeader">
		<div class="siteName"><?php if($subdomain == 'www') { ?><img src="/wp-content/themes/stmu-parent/images/st-marys-small-logo.png" alt="St. Mary's University" width="191" height="44" /><?php }
			else { echo bloginfo('name'); } ?>
		</div>
		<div class="headerTop">
			<div class="item tagline"><?php bloginfo('description'); ?></div>
			<div class="item"><a class="small-btn" href="https://www.stmarytx.edu/stmu-sites/"><span class="no-transform">StMU</span> Sites</a></div>
			<form class="item search-container" role="search">
				<label for="st-global-search" class="show-for-sr">Search</label>
				<input type="text" class="st-default-search-input" id="st-global-search" data-st-install-key="xr6FS4Lto2zJTUiQFbm7" placeholder="Search" autocomplete="off" autocorrect="off" autocapitalize="off"><button type="submit" name="icon">&#xf002;<span class="show-for-sr">Submit</span></button>
			</form>
		</div>
		<nav id="primaryNav" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="site">
			<?php wp_nav_menu(array('menu' => 'topnav', 'container' => 'div', 'container_class' => 'menu-topnav-left-container', 'items_wrap' => '<ul class="menu">%3$s</ul>')); ?>
		</nav>
	</div>
	<?php get_template_part('hero'); ?>
	<?php get_template_part('breadcrumbs'); ?>
</header>