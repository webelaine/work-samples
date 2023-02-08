<a href="#header" id="smoothup">Back to top</a>
<footer itemscope="itemscope" itemtype="https://schema.org/WPFooter">
	<div class="blue-footer">
		<div class="max-width">
			<div class="footer-1">
				<?php if(!function_exists('register_sidebar') || !dynamic_sidebar('footer-left')): endif; ?>
			</div>
			<div class="footer-2">
				<?php global $subdomain; if($subdomain == 'law') {
					wp_nav_menu(array('menu' => 'footer', 'container' => '', 'items_wrap' => '<ul class="law-footer">%3$s</ul>')); ?>
					<a href="/disclosures/">Consumer Information <span class="nowrap">(ABA Required Disclosures)</span></a><?php
				} else {
					wp_nav_menu(array('menu' => 'footer', 'container' => '', 'items_wrap' => '<ul>%3$s</ul>'));
				} ?>
			</div>
			<div class="footer-3">
				&copy;<?php echo date('Y'); ?>. All rights reserved.
				<a href="https://www.stmarytx.edu/compliance/title-ix/">Nondiscrimination / <span class="nowrap">Title IX</span></a>
				<a href="https://www.stmarytx.edu/about/social-media/">
				<span class="show-for-sr">List of social media accounts</span>
					<i class="fa fa-facebook" aria-hidden="true" title="Facebook"></i>
					<i class="fa fa-twitter" aria-hidden="true" title="Twitter"></i>
					<i class="fa fa-youtube" aria-hidden="true" title="YouTube"></i>
					<i class="fa fa-instagram" aria-hidden="true" title="Instagram"></i>
					<i class="fa fa-pinterest" aria-hidden="true" title="Pinterest"></i>
				</a>
			</div>
		</div>
	</div>
</footer>
<nav id="sticky-footer" aria-label="Quick actions">
<?php $subdomain = get_option('stmu_subdomain'); if($subdomain == 'www') { ?>
	<a id="cta-sticky-info" class="cta-test-2020 ghost-btn" href="/admission/stay-informed/"><span class="inline-medium">Request </span>Info</a>
	<a id="cta-sticky-visit" class="cta-test-2020 ghost-btn" href="/admission/visit-campus/">Visit</a>
	<a id="cta-sticky-apply" class="cta-test-2020 apply-btn" href="https://apply.stmarytx.edu/apply/">Apply</a>
<?php } elseif($subdomain == 'law') { ?>
	<a id="cta-sticky-visit" class="cta-test-2020 ghost-btn" href="https://law.stmarytx.edu/admission/#visit">Visit</a>
	<a id="cta-sticky-apply" class="cta-test-2020 apply-btn" href="https://law.stmarytx.edu/admission/#apply">Apply</a>
<?php } else { ?>
	<a id="cta-sticky-donate" class="cta-test-2020 ghost-btn" href="/give-now/">Give Now</a>
<?php } ?>
</nav>
<script>
	(function($) {
		$(document).ready(function(){
			jQuery('ul.menu.accordion-menu ul').each(function() {
				var parent = jQuery(this).parent();
				jQuery(this).prepend("<li class='hide-for-large'><a href='" + parent.find('a:first').attr('href') + "'>" + parent.find('a:first').html() + "</a></li>");
			});
		<?php if(($subdomain == 'www' || $subdomain == 'law') && is_front_page()) { ?>
			var headingLoop = $(".loopingText");
			var bestIndex = -1;
			function showNextBest() {
				++bestIndex;
				headingLoop.eq(bestIndex % headingLoop.length)
					.fadeIn(750)
					.delay(3000)
					.fadeOut(750, showNextBest);
			}
			showNextBest();
			var accordionChoices = $('dl.accordion dt button');
			var accordion = $('dl.accordion');
			function toggleAccordion() {
				// make all buttons inactive and aria-expanded false
				accordionChoices.removeClass('active');
				accordionChoices.attr('aria-expanded', 'false');
				// now set just this button active and aria-expanded true
				$(this).addClass('active');
				$(this).attr('aria-expanded', 'true');
				// set accordion class so CSS can display the right DD
				if($(this).hasClass('section-1')) {
					accordion.attr('class', 'accordion section-1');
				} else if($(this).hasClass('section-2')) {
					accordion.attr('class', 'accordion section-2');
				} else if($(this).hasClass('section-3')) {
					accordion.attr('class', 'accordion section-3');
				} else if($(this).hasClass('section-4')) {
					accordion.attr('class', 'accordion section-4');
				}
			}
			accordionChoices.on('click', toggleAccordion);
			<?php } // end homepage loop ?>
		});
		// Print only: force drawers (details/summary) open - Chrome won't allow without JS
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener( printTest );
		function printTest(mql) {
			dt = $( 'details' )
			if (mql.matches) {
				dt.each( function( index ){
					b = $(this).attr('open');
					if ( !b ){
						$(this).attr('open','');
						$(this).attr('print','');
					}
				});
			} else {
				dt.each( function( index ){
					b = $(this).attr('print');
					if ( !b ){
						$(this).removeAttr('open');
						$(this).removeAttr('print');
					}
				});
			}
		}
	})(jQuery);
</script>
<?php wp_footer(); ?>
</body>
</html>