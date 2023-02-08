<?php get_header();
global $subdomain;
if($subdomain == 'www' || $subdomain == 'law') {
	date_default_timezone_set('America/Chicago'); ?>
	<style type="text/css">
		#side-btn a {
			display:inline-block;
			margin:0 .5em 1em;
			padding:.6em 1em;
			font-size:1.125em;
			line-height:1em;
			border-radius:4px;
			text-align:center;
			text-decoration:none;
			border:1px solid #c78f0e;
			background:#f2bf49;
			color:#036;
			box-shadow:5px -5px 0 #c78f0e;
			position:absolute;
			top:5em;
			left:-3em;
			transform:rotate(90deg);
			-webkit-transform:rotate(90deg);
		}
		#side-btn a:hover, #side-btn a:focus { box-shadow:3px -3px 0 #c78f0e; top:calc(5em + 3px); left:calc(-3em + 3px); color:#048; }
		<?php if(get_field('main_hero_type', 'option') != 'takeover') { ?>
			<?php if($subdomain == 'www') { // display logo banner text on www only ?>
			#header:not(.open) .hero:after {
				content:'<?php the_field('main_hero_h1', 'option'); ?>'; display:block; width:220px; height:50px; margin:0 auto; text-align:center; font-size:.8em; line-height:1; color:#fff; padding:0 1em;
				background: url("data:image/svg+xml,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20width%3D%27220px%27%20height%3D%2750px%27%3E%3Cpolygon%20points%3D%271%2C1%201%2C30%20110%2C50%20220%2C30%20219%2C1%27%20fill%3D%27%23999%27%2F%3E%3Cpolygon%20points%3D%270%2C0%200%2C29%20110%2C49%20220%2C29%20220%2C0%27%20fill%3D%27%23036%27%2F%3E%3C%2Fsvg%3E") no-repeat;
			}
			#header.collapse-header:after { display:none; }
			<?php } // end logo banner text on www only ?>
		.hero { background:
			url('/wp-content/themes/stmu-parent/images/overlay-blue-top.png') no-repeat -150px top,
			url('/wp-content/themes/stmu-parent/images/overlay-corner-bottom.png') no-repeat -250px bottom,
			url('/wp-content/themes/stmu-parent/images/overlay-white-right.png') no-repeat 120% -70px, url('<?php the_field('main_hero_image', 'option'); ?>') center center/cover no-repeat;
		}
		<?php } ?>
		/* "Takeover" hero */
		.hero .h1 { font-size:1.7em; line-height:1; margin:0; }
		.hero.takeover { min-height:1em; padding:1em 2em; color:#fff; background:rgba(0, 51, 102, 0.85); }
		.hero .takeover-overlay { padding:.5em .6em 0; }
		.hero.takeover .h1 { margin-bottom:.3em; }
		.hero p { line-height:1.1; }
		.hero.takeover .ghost-btn { min-width:2em; max-width:90%; margin-left:0; margin-right:0; }
		@media screen and (min-width:600px) {
			.hero.takeover {
				padding:2em;
				background:url('/wp-content/themes/stmu-parent/images/overlay-white-right.png') no-repeat 120% -70px, url('<?php
				if ( get_field( 'main_takeover_image', 'option' ) ) {
					the_field('main_takeover_image', 'option');
				} else {
					the_field('main_rotating_image', 'option');
				}
				?>') center center/cover no-repeat, #036;
			}
			.hero .takeover-overlay { max-width:500px; margin:0 auto; padding:.5em .6em 0; background:rgba(0, 51, 102, 0.85); }
		}
		/* Normal hero */
		.hero { min-height:200px; padding:0 .5em 2em; text-align:center; }
		.home-welcome { padding:1em 0 0; text-align:center; background:#fff; }
		.home-rotating { padding:1em 0; text-align:center; background:#ddd; }
		.home-welcome h1, .home-rotating h2, .news-grid h2 { margin:0; padding:0 0 .5em; text-shadow:none; font-size:1.7em; }
		.home-rotating h1 { display:none; }
		a.event-link { padding:.5em; display:flex; text-decoration:none; border:1px solid #ddd; }
		a.event-link:hover, a.event-link:focus { background:#fff; border:1px solid #aaa; }
		.home-events { padding:1em 0 0; }
		.home-calendar a.ghost-btn { display:inline-block; margin:.5em 1em 1em .5em; }
		.home-calendar a.tablet-cal-items, .home-calendar a.desktop-cal-items { display:none; }
		.home-calendar a div { flex:1; }
		.home-calendar a h3 { flex:4; margin:0; padding:.5em 0 0; font-size:1em; text-align:left; }
		.home-calendar li:hover, .home-calendar li:focus { text-decoration:underline; }
		.home-cal-box { margin:0 .5em 0 0; border:1px solid #036; color:#036; background:#fff; }
		.home-cal-month { background:#036; color:#fff; text-transform:uppercase; }
		.home-cal-day { font-size:1.5em; }
		.home-accordion { padding:2em 0; background:#7ea6e2; }
		.home-accordion a { text-decoration:none; }
		.home-accordion a:focus h3, .home-accordion a:hover h3 { color:#0073e6; }
		.accordion {
			position:relative;
			margin:0 1em;
			display:flex;
			flex-direction:column;
			background:#fff;
		}
		.accordion ul { margin:0 0 0 1em; }
			.accordion.section-1 #section-2, .accordion.section-1 #section-3, .accordion.section-1 #section-4 { display:none; }
			.accordion.section-2 #section-1, .accordion.section-2 #section-3, .accordion.section-2 #section-4 { display:none; }
			.accordion.section-3 #section-1, .accordion.section-3 #section-2, .accordion.section-3 #section-4 { display:none; }
			.accordion.section-4 #section-1, .accordion.section-4 #section-2, .accordion.section-4 #section-3 { display:none; }
		dl dt.section-title {
			height:calc(2em + 7px);
			margin-bottom:0;
			border-bottom:1px solid #f2bf49;
			color:#fff;
			font-weight:normal;
		}
		dl dt.section-title .active { background:#f2bf49; color:#036; }
		.section-title button {
			width:100%;
			font-size:1em;
			height:calc(2em + 6px);
			margin:0;
			padding:.5em 0 .3em;
			background:#036;
			border:none;
			border-radius:0;
			box-shadow:none;
			color:#fff;
		}
		.section-title button:focus, .section-title button:hover { background:#048; top:0; left:0; }
		.section-content { padding:.5em; }
		.section-content h2 { margin:0 0 .5em; font-size:1.2em; }
		.section-content h3 { margin:0 0 .5em; font-size:1.1em; }
		.section-content p { padding:0; line-height:1.2; }
		.home-programs img { display:none; }
		.home-programs h3 { color:#05a; }
		.home-programs a:focus h3, .home-programs a:hover h3 { color:#08f; }
		.news-grid { padding:1em 0; text-align:center; }
		.news-grid h2, .news-grid .ghost-btn { width:250px; margin-left:1em; margin-right:1em; }
		.news-grid h2 { padding-bottom:0; }
		.news-grid a:nth-child(3), .news-grid a:nth-child(10) { display:none; }
		.news-grid h2:nth-child(6) { border-top:1px solid #036; margin-top:.5em; padding-top:.5em; }
		div.home-divider { display:none; }
		.home-phrase { padding:5vw 0; background:
			url('/wp-content/themes/stmu-parent/images/overlay-white-right.png') no-repeat 120% -70px, url('<?php the_field('main_rotating_image', 'option'); ?>') center center/cover no-repeat fixed, #ccc; color:#fff; text-align:center; font-size:2.5em; line-height:1; }
		.home-phrase h2 { display:inline-block; padding:.25em .5em; background:rgba(0, 51, 102, 0.85); color:#fff; font-size:.8em; }
		/* 559 = 16x34.9375 */
		@media screen and (min-width:34.9375em) {
			.hero { min-height:28vw; }
			.news-grid .ghost-btn { min-width:8em; width:250px; grid-column:span 2; justify-self:center; }
			.news-grid .post-connector {
				display:grid;
				grid-template-columns:1fr 1fr;
				grid-template-rows:auto 1fr auto auto 1fr 1fr auto;
			}
			.news-grid h2 { min-width:0; width:90%; margin:0 auto; grid-column:span 2; }
			.news-grid a.post-item { width:250px; height:250px; justify-self:center; }
			.news-grid a:nth-child(3) { display:block; }
			.news-grid a:nth-child(10) { display:block; }
		}
		/* 800 = 16x50 */
		@media screen and (min-width:50em) {
			<?php if(get_field('main_hero_type', 'option') != 'takeover') { ?>
			.hero { background:
				url('/wp-content/themes/stmu-parent/images/overlay-blue-top.png') no-repeat top left,
				url('/wp-content/themes/stmu-parent/images/overlay-corner-bottom.png') no-repeat bottom left,
				url('/wp-content/themes/stmu-parent/images/overlay-white-right.png') no-repeat top right, url('<?php the_field('main_hero_image', 'option'); ?>') center center/cover no-repeat;
			}
			<?php } ?>
			.home-rotating h1 { display:block; }
			.home-calendar { display:grid; display:-ms-grid; grid-template-rows:2fr 2fr 2fr; grid-template-columns:1fr 1fr; -ms-grid-rows:1fr 1fr 1fr; -ms-grid-columns:1fr 1fr; }
			.home-calendar a:nth-child(1) { -ms-grid-row:1; -ms-grid-column:1; }
			.home-calendar a:nth-child(2) { -ms-grid-row:1; -ms-grid-column:2; }
			.home-calendar a:nth-child(3) { -ms-grid-row:2; -ms-grid-column:1; }
			.home-calendar a:nth-child(4) { -ms-grid-row:2; -ms-grid-column:2; }
			.home-calendar a:nth-child(5) { -ms-grid-row:3; -ms-grid-column:1; }
			.home-calendar a:nth-child(6) { -ms-grid-row:3; -ms-grid-column:2; }
			.home-calendar a.tablet-cal-items { display:flex; }
			.home-calendar a.ghost-btn { margin:1em .5em; -ms-grid-row:3; -ms-grid-column:2; }
			.accordion { flex-direction:row; flex-wrap:nowrap; width:768px; margin:0 auto; min-height:452px; overflow:hidden; text-align:center; }
			dl dt.section-title {
				flex:0 0 49px;
				position:relative;
				cursor:pointer;
				box-sizing:border-box;
				border-right:1px solid #f2bf49;
				border-bottom:none;
				height:452px;
				background:#036;
				color:#fff;
			}
			dl dt.section-title button, dl dt.section-title button:focus, dl dt.section-title button:hover {
				position:absolute;
				top:50%;
				left:50%;
				width:452px;
				margin:0;
				transform:translateX(-50%) translateY(-50%) rotate(-90deg);
				white-space:nowrap;
			}
			.section-content { padding:1em; display:grid; align-content:end; justify-content:center; }
			.section-content h2 { font-size:1.7em; }
			.home-programs { display:flex; flex-direction:row; display:-ms-grid; display:grid; grid-template-columns:1fr 1fr 1fr; grid-gap:1em; }
			.home-programs img {
				display:block;
				margin-bottom:.5em;
				border-radius:100%;
				box-shadow:0 0 0 3px #f2bf49, 0 0 0 6px #036;
			}
			.home-programs a { margin:.5em; flex-basis:148px; }
			.home-programs a:focus img, .home-programs a:hover img { border:5px solid #f2bf49; box-shadow:0 0 0 3px #036, 0 0 0 6px #f2bf49; }
			.home-programs h3 { font-size:.8em; line-height:1; }
			.home-phrase { background:
				url('/wp-content/themes/stmu-parent/images/overlay-corner-bottom.png') no-repeat -200px bottom,
				url('/wp-content/themes/stmu-parent/images/overlay-white-right.png') no-repeat right top,
				url('<?php the_field('main_rotating_image', 'option'); ?>') center center/cover no-repeat fixed,
				#ccc;
			}
			.home-phrase h2 { width:469px; text-align:left; }
			.law .home-phrase h2 { text-align:center; }
		}
		
		/* 848 - 16x53 */
		@media screen and (min-width:53em) {
			.news-grid .post-connector {
				grid-template-columns:1fr 1fr 1fr;			-ms-grid-columns:1fr 40px 1fr 1fr;
				grid-template-rows:auto 1fr 1fr auto;		-ms-grid-rows:50px 1fr 20px 1fr 80px;
				display:-ms-grid;
			}
			.news-grid .home-divider {														-ms-grid-row:1; -ms-grid-column:2; -ms-grid-row-span:4; }
			.news-grid h2:nth-child(1) { grid-column:span 1;								-ms-grid-row:1; -ms-grid-column:1; }
			.news-grid h2:nth-child(6) { border-top:none; margin-top:0; padding-top:0;		-ms-grid-row:1; -ms-grid-column:3; -ms-grid-column-span:2; }
			.news-grid a:nth-child(2) { grid-row:2; grid-column:1/span 1;					-ms-grid-row:2; -ms-grid-column:1; -ms-grid-column-align:center; }
			.news-grid a:nth-child(3) { grid-row:3;											-ms-grid-row:4; -ms-grid-column:1; -ms-grid-column-align:center; }
			.news-grid a:nth-child(4) { grid-row:4/span 1; grid-column:1/span 1;			-ms-grid-row:5; -ms-grid-column:1; -ms-grid-column-align:center; }
			.news-grid a:nth-child(6) { grid-row:2; grid-column:2;							-ms-grid-row:2; -ms-grid-column:3; -ms-grid-column-align:center; }
			.news-grid a:nth-child(7) { grid-row:2; grid-column:2;							-ms-grid-row:2; -ms-grid-column:3; -ms-grid-column-align:center; }
			.news-grid a:nth-child(8) { grid-row:2; grid-column:3;							-ms-grid-row:2; -ms-grid-column:4; -ms-grid-column-align:center; }
			.news-grid a:nth-child(9) { grid-row:3; grid-column:2;							-ms-grid-row:4; -ms-grid-column:3; -ms-grid-column-align:center; }
			.news-grid a:nth-child(10) { grid-row:3; grid-column:3;							-ms-grid-row:4; -ms-grid-column:4; -ms-grid-column-align:center; }
			.news-grid a:nth-child(11) {													-ms-grid-row:5; -ms-grid-column:3; -ms-grid-column-span:2; -ms-grid-column-align:center; }
		}

		/* 1000 = 16x62.5 */
		@media screen and (min-width:62.5em) {
			.news-grid .post-connector {
				grid-template-rows: auto calc(200px + 1em) auto;
				grid-template-columns:1fr 30px 1fr 1fr 1fr;
			}
			.news-grid a.post-item { width:200px; height:200px; }
			.news-grid a.ghost-btn { width:auto; }
			.news-grid h2:nth-child(1) { grid-column:span 1; }
			.news-grid a:nth-child(2) { grid-row:2; grid-column:1/span 1; }
			.news-grid a:nth-child(3) { display:none; }
			.news-grid a:nth-child(4) { grid-row:3; }
			div.home-divider { display:block; width:30px; grid-row:1/span 3; grid-column:2; }
			span.home-line { display:block; margin:0 auto; width:1px; height:100%; background:#036; }
			.news-grid h2:nth-child(6) { grid-row:1; grid-column:3/span 3; }
			.news-grid a:nth-child(7) { grid-column:3; }
			.news-grid a:nth-child(8) { grid-column:4/span 1; grid-row:2; }
			.news-grid a:nth-child(9) { grid-column:5; grid-row:2; }
			.news-grid a:nth-child(10) { display:none; }
			.news-grid a:nth-child(11) { grid-column:3/span 3; }
		}
		
		/*---------- desktop ----------*/
		/* 1040 = 16x65 */
		@media screen and (min-width:65em) {
			.hoverable #side-btn a { top:8em; }
			.hoverable #header .hero:after { display:none; }
			<?php if(get_field('main_hero_type', 'option') != 'takeover' && $subdomain == 'www') { // display logo banner text on www only ?>
				.hoverable .headerContainer nav:not(.sticky) ul.menu>li:first-child:after { content:"<?php the_field('main_hero_h1', 'option'); ?>"; color:#fff; text-align:center; font-size:.8em; position:relative; top:5.1em; white-space:pre; }
				.hoverable .headerContainer nav:not(.sticky) ul.menu>li:first-child {
					background:url('/wp-content/themes/stmu-parent/images/plain-logo-white.png') center 10px no-repeat,  url("data:image/svg+xml,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20width%3D%27220px%27%20height%3D%27140px%27%3E%3Cpolygon%20points%3D%271%2C1%201%2C115%20110%2C140%20220%2C115%20219%2C1%27%20fill%3D%27%23999%27%2F%3E%3Cpolygon%20points%3D%270%2C0%200%2C114%20110%2C139%20220%2C114%20220%2C0%27%20fill%3D%27%23036%27%2F%3E%3C%2Fsvg%3E") no-repeat;
					height:140px;
				}
			<?php } ?>
			.hoverable .headerContainer nav ul.menu>li:first-child a { display:none; }
			.hero.bgGold { padding:3em 2em 2em; }
			.home-rotating .max-width { display:grid; display:-ms-grid; grid-template-columns:15vw 15vw 1fr; -ms-grid-columns:15vw 15vw 1fr; grid-template-rows:15vw 15vw; -ms-grid-rows:15vw 15vw; grid-gap:1vw; padding-bottom:1em; padding-left:.5em; }
			.home-events { grid-column:3; -ms-grid-column:3; grid-row:1/span 2; -ms-grid-row:1; -ms-grid-row-span:2; padding:0 0 0 1em; }
			.home-calendar { grid-template-columns:1fr 1fr; -ms-grid-columns:1fr 1fr; grid-template-rows:1fr 1fr 1fr 1fr; -ms-grid-rows:1fr 1fr 1fr 1fr; padding:0 0 .5em; }
			.home-calendar a:nth-child(7) { -ms-grid-row:4; -ms-grid-column:1; }
			.home-calendar a:nth-child(8) { -ms-grid-row:4; -ms-grid-column:2; }
			.home-calendar a.ghost-btn { width:90%; }
			.home-accordion { padding:2em 0; background:
				url('/wp-content/themes/stmu-parent/images/overlay-blue-top.png') no-repeat top left,
				url('/wp-content/themes/stmu-parent/images/overlay-corner-bottom.png') no-repeat bottom left,
				url('/wp-content/themes/stmu-parent/images/overlay-white-right.png') no-repeat top right,
				url('<?php the_field('main_accordion_image', 'option'); ?>') center center/cover no-repeat fixed,
				#7ea6e2;
			}
			.accordion { width:64%; margin-left:36%; }
		}
		/* 1216 = 16x76 */
		@media screen and (min-width:76em) {
			.news-grid .post-connector {
				grid-template-rows: auto 280px auto;
				grid-template-columns:280px 1px 280px 280px;
				grid-gap:20px;
			}
			.news-grid a.post-item { width:280px; height:280px; max-width:280px; max-height:280px; margin:0; }
			.news-grid a.ghost-btn { margin-top:.5em; }
			div.home-divider { width:1px; }
		}

		/* 1300 = 16x81.25 */
		@media screen and (min-width:81.25em) {
			.home-calendar a.desktop-cal-items { display:flex; }
			.home-rotating .max-width { grid-template-columns:200px 200px 1fr; -ms-grid-columns:200px 200px 1fr; grid-template-rows:200px 200px; -ms-grid-rows:200px 200px; }
		}
		
		/* ie 10+ on 800px+ */
		@media (min-width:50em) and (-ms-high-contrast: none),
			(min-width:50em) and (-ms-high-contrast: active) {
			.accordion { display:-ms-grid; -ms-grid-rows:1; -ms-grid-columns:5; height:452px; }
			.accordion.section-1 { -ms-grid-rows:1fr; -ms-grid-columns: calc(2em + 1px) 1fr calc(2em + 1px) calc(2em + 1px) calc(2em + 1px); }
			.accordion.section-2 { -ms-grid-rows:1fr; -ms-grid-columns: calc(2em + 1px) calc(2em + 1px) 1fr calc(2em + 1px) calc(2em + 1px); }
			.accordion.section-3 { -ms-grid-rows:1fr; -ms-grid-columns: calc(2em + 1px) calc(2em + 1px) calc(2em + 1px) 1fr calc(2em + 1px); }
			.accordion.section-4 { -ms-grid-rows:1fr; -ms-grid-columns: calc(2em + 1px) calc(2em + 1px) calc(2em + 1px) calc(2em + 1px) 1fr; }
			.accordion .section-title:nth-child(1) { -ms-grid-row:1; -ms-grid-column:1; }
			.accordion.section-1 #section-1 { -ms-grid-row:1; -ms-grid-column:2; }
			.accordion.section-1 .section-title:nth-child(3) { -ms-grid-row:1; -ms-grid-column:3; }
			.accordion.section-1 .section-title:nth-child(5) { -ms-grid-row:1; -ms-grid-column:4; }
			.accordion.section-1 .section-title:nth-child(7) { -ms-grid-row:1; -ms-grid-column:5; }
			.accordion.section-2 .section-title:nth-child(3) { -ms-grid-row:1; -ms-grid-column:2; }
			.accordion.section-2 #section-2 { -ms-grid-row:1; -ms-grid-column:3; }
			.accordion.section-2 .section-title:nth-child(5) { -ms-grid-row:1; -ms-grid-column:4; }
			.accordion.section-2 .section-title:nth-child(7) { -ms-grid-row:1; -ms-grid-column:5; }
			.accordion.section-3 .section-title:nth-child(3) { -ms-grid-row:1; -ms-grid-column:2; }
			.accordion.section-3 .section-title:nth-child(5) { -ms-grid-row:1; -ms-grid-column:3; }
			.accordion.section-3 #section-3 { -ms-grid-row:1; -ms-grid-column:4; }
			.accordion.section-3 .section-title:nth-child(7) { -ms-grid-row:1; -ms-grid-column:5; }
			.accordion.section-4 .section-title:nth-child(3) { -ms-grid-row:1; -ms-grid-column:2; }
			.accordion.section-4 .section-title:nth-child(5) { -ms-grid-row:1; -ms-grid-column:3; }
			.accordion.section-4 .section-title:nth-child(7) { -ms-grid-row:1; -ms-grid-column:4; }
			.accordion.section-4 #section-4 { -ms-grid-row:1; -ms-grid-column:5; }
			
			.home-programs { display:-ms-grid; -ms-grid-rows:auto; -ms-grid-columns:1fr 1fr 1fr; }
			.home-programs a { display:block; }
			.home-programs a:nth-child(1) { -ms-grid-row:1; -ms-grid-column:1; }
			.home-programs a:nth-child(2) { -ms-grid-row:1; -ms-grid-column:2; }
			.home-programs a:nth-child(3) { -ms-grid-row:1; -ms-grid-column:3; }
			
			.news-grid a:nth-child(3), .news-grid a:nth-child(10) { display:block; }
			.news-grid a.ghost-btn { width:250px; height:52px; }
		}
		
		/* edge */
		@supports (-ms-ime-align:auto) {
			.home-rotating .max-width { -ms-grid-rows: calc(200px + 1em) 200px; }
			.home-rotating .max-width { -ms-grid-columns: calc(200px + 1em) 200px; }
			.boxy-effect:nth-child(1), .boxy-effect:nth-child(2) { margin-bottom:1em; }
			.boxy-effect:nth-child(1), .boxy-effect:nth-child(3) { margin-right:1em; }
			.news-grid a:nth-child(3), .news-grid a:nth-child(10) { display:block; }
			.news-grid a.ghost-btn { width:250px; height:52px; }
		}
	</style>
	<main id="theContent" class="keepClear" data-swiftype-index="true" aria-label="main content">
		<div class="home-welcome">
			<h1><?php the_field('main_featured_header', 'option'); ?></h1>
		</div>
		<?php if($subdomain == 'www') { ?>
		<div class="stmu-social-wall gold-ghostweave">
			<script src="https://assets.juicer.io/embed.js" type="text/javascript"></script>
			<link href="https://assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
			<ul class="juicer-feed" data-feed-id="stmu-homepage" data-per="8" data-gutter="20"></ul>
		</div>
		<?php } ?>
		<div class="home-rotating">
			<h2 id="events">Quick Links and Events</h2>
			<div class="max-width">
				<?php // 4 featured links
				$have_featured_links = false;
				if(have_rows('main_featured_sets', 'option')) {
					while(have_rows('main_featured_sets', 'option')): the_row();
						// if any of the sets are for this time period, show those
						$todaysDate = strtotime('now');
						$startDate = strtotime(get_sub_field('featured_start_date'));
						$endDate = strtotime(get_sub_field('featured_end_date'));
						if($startDate <= $todaysDate && $todaysDate <= $endDate) {
							if(have_rows('four_featured_links', 'option')) {
								while(have_rows('four_featured_links', 'option')) : the_row();
									?><a class="button-to-box boxy-effect" href="<?php the_sub_field('link_url', 'option'); ?>" style="background-image:url('<?php the_sub_field('link_image', 'option'); ?>');"><div class="blue-overlay"><h3><?php the_sub_field('link_text', 'option'); ?></h3></div></a><?php
								endwhile;
								// set to true so fallback isn't shown
								$have_featured_links = true;
								// exit the loop - we only want one set of links at a time
								break;
							}
						}
					endwhile;
					// else, there are sets, but none for the right dates - show the newest set
					if($have_featured_links == false) {
						$set = count(get_field('main_featured_sets', 'option')); // i.e. if 2 sets of links set = 2
						$i = 1;
						while(have_rows('main_featured_sets', 'option')): the_row();
							// if this is the newest set of featured links
							if($set == $i) {
								if(have_rows('four_featured_links', 'option')) {
									while(have_rows('four_featured_links', 'option')) : the_row();
										?><a class="button-to-box boxy-effect" href="<?php the_sub_field('link_url', 'option'); ?>" style="background-image:url('<?php the_sub_field('link_image', 'option'); ?>');"><div class="blue-overlay"><h3><?php the_sub_field('link_text', 'option'); ?></h3></div></a><?php
									$have_featured_links = true;
									endwhile;
								}
							}
							$i++;
						endwhile;
					}
				}
				// if there are no sets at all, display a fallback set
				if($have_featured_links == false) {
					?>
					<a class="button-to-box boxy-effect" href="/about/" style="background-image:none;"><div class="blue-overlay"><h3>About</h3></div></a>
					<a class="button-to-box boxy-effect" href="/academics/programs/" style="background-image:none;"><div class="blue-overlay"><h3>Majors</h3></div></a>
					<a class="button-to-box boxy-effect" href="/news/" style="background-image:none;"><div class="blue-overlay"><h3>News</h3></div></a>
					<a class="button-to-box boxy-effect" href="/admission/visit-campus/" style="background-image:none;"><div class="blue-overlay"><h3>Visit Campus</h3></div></a>
					<?php
				}
				?>
				<div class="home-events">
					<div class="home-calendar">
						<?php
						// pull from Master Calendar API
						$startDate = new DateTime('now', new DateTimeZone('America/Chicago'));
						$endDate = new DateTime('now', new DateTimeZone('America/Chicago'));
						$endDate->modify("+3 months");
						$url = 'https://ems-app.stmarytx.edu/MCAPI/MCAPIService.asmx?WSDL';
						$headers = get_headers($url);
						if($headers[0] == 'HTTP/1.1 200 OK') {
							$client = new SoapClient("$url", array('trace' => 1));
							// www: GetFeaturedEvents from calendar 5; law: GetEvents (not just Featured) from calendar 2, priority 1+2
							if($subdomain == 'www') {
								$params = array(
									'soap_version'	=> 'SOAP_1_2',
									'startDate'		=> $startDate->format('Y-m-d') . 'T00:00:00',
									'endDate'		=> $endDate->format('Y-m-d') . 'T23:59:59',
									'calendars'		=> array('5'),
									'userName'		=> 'redacted',
									'password'		=> 'redacted'
								);
								$output = array();
								$result = $client->__soapCall('GetFeaturedEvents', array($params));
								if(!is_soap_fault($result)) {
									$xml = simplexml_load_string($result->GetFeaturedEventsResult);
								}
							} elseif($subdomain == 'law') {
								$params = array(
									'soap_version'	=> 'SOAP_1_2',
									'startDate'		=> $startDate->format('Y-m-d') . 'T00:00:00',
									'endDate'		=> $endDate->format('Y-m-d') . 'T23:59:59',
									'calendars'		=> array('2'),
									'userName'		=> 'redacted',
									'password'		=> 'redacted'
								);
								$output = array();
								$result = $client->__soapCall('GetEvents', array($params));
								if(!is_soap_fault($result)) {
									$xml = simplexml_load_string($result->GetEventsResult);
								}
							}
							// both sites: parse the data
							foreach($xml->Data as $event) {
								if($event->Priority < 3) { // only show "high" (1) and "medium" (2) events, not "low" (3)
									$output[] = array(
										'title' => str_replace('"', '\"', $event->{'Title'}),
										'start' => $event->TimeEventStart,
										'url' => 'https://ems-app.stmarytx.edu/MasterCalendar/EventDetails.aspx?EventDetailId=' . $event->EventDetailID,
										'allDay' => $allDay,
										'priority' => $priority,
										'eventType' => $event->EventTypeName,
										'canceled' => $event->Canceled[0]
									);
								}
							}
							// sort by date, since Master Calendar API does not have this capability
							foreach($output as $key => $value) {
								$sort[$key] = strtotime($value['start']);
							}
							array_multisort($sort, SORT_ASC, $output);
							// only display 7
							$i=1;
							foreach($output as $event) {
								if($i<=7) {
									$eventTime = strtotime($event['start']);
									$eventMonth = date('M', $eventTime);
									$eventDay = date('j', $eventTime);
									echo '<a class="event-link';
									if('true' == $event['canceled']) { echo ' canceled-event'; }
									if($i==5) { echo ' tablet-cal-items'; }
									elseif($i>=6) { echo ' desktop-cal-items'; }
									$eventTitle = str_replace("\\", "", $event['title']);
									$eventTitle = trimTitle($eventTitle);
									echo '" itemprop="url" href="' . $event['url'] . '">
											<div class="home-cal-box">
												<div class="home-cal-month">' . $eventMonth . '</div>
												<div class="home-cal-day">' . $eventDay . '</div>
											</div>
											<h3 itemprop="name">' . $eventTitle . '</h3>
									</a>';
									$i++;
								} else {
									break;
								}
							}
							if($subdomain == 'www') { ?>
								<a class="ghost-btn" href="/about/events/">More events</a><?php
							} else { ?>
								<a class="ghost-btn" href="https://www.stmarytx.edu/about/events/?category=2">More events</a><?php
							}
						} else {
							echo "Sorry, the calendar is currently unavailable.";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- end featured links and events -->
		<!-- accordion -->
		<div class="home-accordion">
			<div class="max-width">
				<?php
				if(have_rows('main_accordion_tabs', 'option')) :
					// single UL - accordion on desktop, plain for small screens ?>
					<style type="text/css">
						/* 800 = 16x50 */
						@media screen and (min-width:50em) {
							<?php
							$i=1;
							while(have_rows('main_accordion_tabs', 'option')) : the_row();
								$background = '';
								$background = get_sub_field('tab_background', 'option');
								if(!empty($background)) {
									echo ".accordion.section-$i { background:#fff url('" . $background . "') ";
									if($i==1) { echo '1em'; }
									elseif($i==2) { echo '2em'; }
									elseif($i==3) { echo '3em'; }
									elseif($i==4) { echo '4em'; }
									else { echo 'center'; }
									echo " center/cover no-repeat; }\n";
								}
								$i++;
							endwhile; ?>
						}
					</style>
					<dl class="accordion section-1"><?php
					$i=1;
					while(have_rows('main_accordion_tabs', 'option')) : the_row();
						echo '<dt class="section-title">
							<button class="section-' . $i;
							if($i==1) { echo ' active" aria-expanded="true"'; } else { echo '" aria-expanded="false"'; }
							echo ' aria-controls="section-' . $i . '">';
							the_sub_field('tab_name', 'option');
							echo '</button>
						</dt>
						<dd class="section-content" id="section-' . $i . '">
							<h2 id="accordion-heading-' . $i . '">';
							the_sub_field('tab_heading', 'option');
							echo '</h2>';
							if(get_row_layout() == 'programs') {
								$programArgs = array(
									'no_found_rows' => true,
									'post_type' => 'program',
									'posts_per_page' => 3,
									'post_status' => 'publish',
									'orderby' => 'rand',
									'meta_key' => '_thumbnail_id', // only grabs posts with a featured image
								);
								$majorQuery = new WP_Query($programArgs);
								if($majorQuery->have_posts()) { ?>
									<div class="home-programs"><?php
									while($majorQuery->have_posts()) {
										$majorQuery->the_post();
										?><a href="<?php the_permalink(); ?>"><div class="program">
											<img src="<?php the_post_thumbnail_url('program'); ?>" />
											<h3><?php the_title(); ?></h3>
										</div></a><?php
									} ?>
									</div><?php
								}
							}
							the_sub_field('tab_content', 'option');
						echo '</dd>';
						$i++;
					endwhile; ?>
					</dl><?php
				endif; ?>
			</div>
		</div>
		<!-- end accordion -->
		<div class="news-grid gold-ghostweave">
			<div class="max-width post-connector">
				<h2>Gold &amp; Blue</h2>
				<?php if($subdomain == 'www') {
					// get 7 latest magazine posts
					$magArgs = array(
						'post_type' => 'post',
						'category__in' => array('178'), // ID 178 is "magazine" category
						'posts_per_page' => 7,
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_key' => '_thumbnail_id', // only grab posts with a featured image
						'no_found_rows' => 'true',
						'_shuffle_and_pick' => 2 // custom attribute (functions.php) to get 2 random posts from the initial query
					);
					$magQuery = new WP_Query($magArgs);
					if($magQuery->have_posts()):
						while($magQuery->have_posts()) : $magQuery->the_post();
							$magImgID = get_post_thumbnail_id($post->ID); ?>
							<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url('spotlight'); ?>');">
								<div class="overlay"><h3><?php the_title(); ?></h3></div>
							</a>
							<?php
						endwhile;
					endif;
					?><a class="ghost-btn" href="https://www.stmarytx.edu/magazine/">Magazine</a><?php
				} else { // law
					// WP REST API
					$response = wp_remote_get('https://www.stmarytx.edu/wp-json/wp/v2/posts?categories=178&per_page=7&school=58');
					if(!is_wp_error($response) && $response['response']['code'] == 200) {
						$remote_posts = json_decode($response['body']);
						// display
						$i=0;
						// randomize
						shuffle($remote_posts);
						foreach($remote_posts as $remote_post) {
							if($remote_post->fimg_300_url) {
								$imageUrl = $remote_post->fimg_300_url;
							} else {
								$imageUrl = 'https://law.stmarytx.edu/wp-content/uploads/2018/11/law-icon.png';
							}
							if($i==0 || $i==1) {
								echo '<a class="post-item" href="' . $remote_post->link . '" style="background-image:url(\'' . $imageUrl . '\');">';
								echo '<div class="overlay"><h3>' . $remote_post->title->rendered . '</h3></div></a>';
							}
							$i++;
						}
					}
					?><a class="ghost-btn" href="/law_magazine/">Magazine</a><?php
				} ?>
				
				<div class="home-divider"><span class="home-line"></span></div>
				<h2>News</h2>
				<?php if($subdomain == 'www') {
					// get 4 latest news
					$newsArgs = array(
						'post_type' => 'post',
						'category_name' => 'news',
						'posts_per_page' => 4,
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_key' => '_thumbnail_id', // only grab posts with a featured image
						'no_found_rows' => 'true',
					);
					$newsQuery = new WP_Query($newsArgs);
					if($newsQuery->have_posts()):
						while($newsQuery->have_posts()) : $newsQuery->the_post();
							$newsImgID = get_post_thumbnail_id($post->ID); ?>
							<a class="post-item" href="<?php the_permalink(); ?>" style="background-image:url('<?php the_post_thumbnail_url('spotlight'); ?>');">
								<div class="overlay"><h3><?php the_title(); ?></h3></div>
							</a>
							<?php
						endwhile;
					endif;
				} else { // law
					// WP REST API
					if(substr(get_site_url(), 0, 5) != 'https') {
						$response = wp_remote_get('http://s28507.p221.sites.pressdns.com/wp-json/wp/v2/posts?categories=1&per_page=4&school=58');
					} else {
						$response = wp_remote_get('https://www.stmarytx.edu/wp-json/wp/v2/posts?categories=1&per_page=4&school=58');
					}
					if(!is_wp_error($response) && $response['response']['code'] == 200) {
						$news_posts = json_decode($response['body']);
						$x=0;
						// display latest 4
						foreach($news_posts as $remote_post) {
							if($x<4) {
								if($remote_post->fimg_300_url) {
									$imageUrl = $remote_post->fimg_300_url;
								} else {
									$imageUrl = 'https://law.stmarytx.edu/wp-content/uploads/2018/11/law-icon.png';
								}
								echo '<a class="post-item" href="' . $remote_post->link . '" style="background-image:url(\'' . $imageUrl . '\');">
									<div class="overlay"><h3>' . $remote_post->title->rendered . '</h3></div>
								</a>';
								}
							$x++;
						}
					}
				} ?>
				<a class="ghost-btn" href="https://www.stmarytx.edu/news/">More News</a>
			</div>
		</div>
		<div class="home-phrase">
			<?php
				if(($subdomain == 'www' || $subdomain == 'law')) {
					echo '<h2 id="rotating">';
						if(get_field('main_static_text', 'option')) {
							the_field('main_static_text', 'option');
						}
						if(have_rows('main_looping_text_repeater', 'option')) {
							 while(have_rows('main_looping_text_repeater', 'option')) : the_row(); ?>
							 <span class="loopingText"><?php the_sub_field('main_looping_text', 'option'); ?></span><?php
							 endwhile;
						}
					echo '</h2>';
				}
			?>
		</div>
		<?php if($subdomain == 'law') { ?>
		<div class="stmu-social-wall gold-ghostweave">
			<h2>Social Media</h2>
			<script src="https://assets.juicer.io/embed.js" type="text/javascript"></script>
			<link href="https://assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
			<ul class="juicer-feed" data-feed-id="law-homepage" data-per="4" data-gutter="20"></ul>
		</div>
		<?php } ?>
	<?php
} else { ?>
<main id="theContent" data-swiftype-index="true">
	<div class="max-width">
		<?php if(have_posts()):
		while (have_posts()): the_post();
			the_content();
		endwhile;
		endif; ?>
	</div>
<?php } ?>
</main>
<?php get_footer(); ?>