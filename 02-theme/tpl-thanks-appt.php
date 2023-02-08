<?php
/*
 * Template Name: Thanks - Appt.
 */
if(empty($_GET['calclang'])) {
	wp_redirect(home_url(), 301);
	exit;
} else {
	get_header(); ?>
	<div class="white-ghostweave page-wrapper">
		<main class="max-width" id="theContent">
			<?php
			// Condition setup - Christmas Break 2019
			$cBreak = false;
			date_default_timezone_set('America/Chicago');
			$todaysDate = strtotime(now);
			$startEvent = strtotime('2019-12-23 00:01');
			$endEvent = strtotime('2020-01-03 00:01');
			if($startEvent <= $todaysDate && $todaysDate <= $endEvent) { $cBreak = true; }
			// Break message (English and Spanish)
			if($cBreak == true) {
				if(urldecode($_GET['calclang']) == 'Counseling Services for the Public') { ?>
					<p>Thank you for requesting an appointment. The Family Life Center is closed December 23 - January 3, and we look forward to following up with you when we return.</p><?php
				} else { ?>
					<h2 itemprop="headline">Gracias por solicitar una cita</h2>
					<p>El Family Life Center está cerrado del 16 de diciembre al 2 de enero, y esperamos seguir con usted cuando regresemos.</p><?php
				}
			// Regular message (English and Spanish)
			} else {
				if(urldecode($_GET['calclang']) == 'Counseling Services for the Public') { ?>
					<p>We will give you a call soon to help you schedule a convenient time.</p><?php
				} else { ?>
					<h2 itemprop="headline">Gracias por solicitar una cita</h2>
					<p>Lo llamaremos pronto.</p><?php
				}
			}
			?>
		</main>
	</div>
	<?php get_footer();
} ?>