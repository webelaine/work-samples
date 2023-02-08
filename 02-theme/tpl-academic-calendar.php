<?php
/*
 * Template Name: Acad Calendar
 */
get_header(); date_default_timezone_set('America/Chicago');
function getAcadAPIEvents($startDate, $endDate) {
	// Build MC API query that only pulls the events we need. Need to identify how this is determined: what tag or calendar or other identifier marks it?
	// pull from Master Calendar API
	$url = 'https://ems-app.stmarytx.edu/MCAPI/MCAPIService.asmx?WSDL';
	$headers = get_headers($url);
	if($headers[0] == 'HTTP/1.1 200 OK') {
		$client = new SoapClient('https://ems-app.stmarytx.edu/MCAPI/MCAPIService.asmx?WSDL', array('trace' => 1));
		$params = array(
			'soap_version'	=> 'SOAP_1_2',
			'startDate'		=> $startDate . 'T00:00:00',
			'endDate'		=> $endDate . 'T23:59:59',
			'userName'		=> 'redacted',
			'password'		=> 'redacted',
			'calendars'		=> array(1) // 1 is the ID of the Academic Calendar
		);
		$output = array();
		$result = $client->__soapCall('GetEvents', array($params));
		if(!is_soap_fault($result)) {
			$xml = simplexml_load_string($result->GetEventsResult);
			foreach($xml->Data as $event) {
				$allDay = '';
				if($event->IsAllDayEvent == 'true') {
					$allDay = true;
				}
				$output[] = array(
					'title' => str_replace('"', '\"', $event->{'Title'}),
					'start' => $event->TimeEventStart,
					'url' => 'https://ems-app.stmarytx.edu/MasterCalendar/EventDetails.aspx?EventDetailId=' . $event->EventDetailID,
					'allDay' => $allDay,
					'canceled' => $event->Canceled[0]
				);
			}
		}
		// sort by date, since Master Calendar API does not have this capability
		foreach($output as $key => $value) {
			$sort[$key] = strtotime($value['start']);
		}
		array_multisort($sort, SORT_ASC, $output);
	} else {
		$output = 'No events';
	}
	return $output;
}
?>
<style type="text/css">
select { margin-bottom:1em; }
input[type="submit"] { min-width:5em; }
@media print {
	body, p, .calWrap, .calWrap h3 { font:normal 18px arial, helvetica, sans-serif; }
	.hide{display:none;}
	a { text-decoration:none; }
	a:link:after{content:''; content:none;}
	h2 { clear:both; }
	.cal { float:left; width:80px; }
	.show-for-print { border:1px solid #aaa; padding:1em; font-style:italic; }
	select { width:auto!important; }
	input[type="submit"] { display:none; }
	li.calWrap { margin:1em; list-style:none; }
	.calMonth { margin-right:.4em; }
}
</style>
<div class="white-ghostweave page-wrapper">
	<main class="max-width" id="theContent" data-swiftype-index="true">
		<?php the_content(); ?>
		<div class="show-for-print">
			This copy was printed on <?php echo date('M. j, Y'); ?> and may be outdated. Please check the online calendar at <strong>www.stmarytx.edu/academic-calendars</strong> for the latest updates.
		</div>
		<?php
			if(!isset($_GET['semester']) || !isset($_GET['y'])) {
				// determine which semester and year to start with
				$startCalc = new DateTime('second sat of this month');
				$currentMonth = $startCalc->format('n');
				// Determine which dates to show, using current year.
				if($currentMonth <= 5) { // jan, feb, mar, apr, may: show spring
					// Start January 1 of (requested year)
					$startDate = $startCalc->format('Y-01-01');
					// End May 20 of (requested year)
					$endDate = $startCalc->format('Y-05-20');
					$semester = 'spring';
				} elseif($currentMonth <= 7) { // june or july: show summer
					// Start May 1 of (requested year)
					$startDate = $startCalc->format('Y-05-01');
					// End Aug 15 of (requested year)
					$endDate = $startCalc->format('Y-08-15');
					$semester = 'summer';
				} else { // aug, sep, oct, nov, dec: show fall
					// Start August 1 of (requested year)
					$startDate = $startCalc->format('Y-08-01');
					// End Dec 31 of (requested year)
					$endDate = $startCalc->format('Y-12-31');
					$semester = 'fall';
				}
				$year = $startCalc->format('Y');
			} else {
				// Determine which dates to show, using requested semester and year.
				if($_GET['semester'] == 'spring') {
					$startDate = $_GET['y'] . '-01-01';
					$endDate = $_GET['y'] . '-05-20';
					$semester = 'spring';
				} elseif($_GET['semester'] == 'summer') {
					$startDate = $_GET['y'] . '-05-01';
					$endDate = $_GET['y'] . '-08-15';
					$semester = 'summer';
				} else { // fall
					$startDate = $_GET['y'] . '-08-01';
					$endDate = $_GET['y'] . '-12-31';
					$semester = 'fall';
				}
				$year = $_GET['y'];
			}
		?>
		<form method="GET">
			<select name="semester" style="width:30%; padding:1%;">
				<option value="spring"<?php if($semester == 'spring') { echo ' selected'; } ?>>Spring</option>
				<option value="summer"<?php if($semester == 'summer') { echo ' selected'; } ?>>Summer</option>
				<option value="fall"<?php if($semester == 'fall') { echo ' selected'; } ?>>Fall</option>
			</select>
			<select name="y" style="width:25%; padding:1%;">
				<?php
					$startingYear = $year - 2;
					$endingYear = $year + 2;
					for($i=$startingYear; $i<=$endingYear; $i++) {
						echo "<option value=\"$i\"";
						if($i == $year) { echo ' selected'; }
						echo ">$i</option>";
					}
				?>
			</select>
			<input type="submit" value="Show" style="width:35%; margin-left:0;">
		</form>
		<?php
		$acadEvents = getAcadAPIEvents($startDate, $endDate);
		if($acadEvents == 'No events') {
			echo "Sorry, either the calendar is temporarily unavailable or we don't have dates for this semester.";
		} else {
			echo '<ul class="acadCalendar row small-up-1">';
			foreach($acadEvents as $event) {
				$eventDate = strtotime($event['start']);
				echo '<li itemscope itemtype="https://schema.org/Event" class="column calWrap">';
					echo '<meta itemprop="startDate" content="' . date('Y-m-d', $eventDate) . '"><span class="hide" itemprop="location" itemscope itemtype="https://schema.org/Place"><span itemprop="name">St. Mary\'s University</span><span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"><span itemprop="addressLocality">San Antonio</span>, <span itemprop="addressRegion">TX</span></span></span>';
					echo '<div class="cal"><span class="calMonth">' . date('M', $eventDate);
					if(date('M', $eventDate) != 'May') { echo '.'; }
					echo '</span><span class="calDay">' . date('j', $eventDate) . '</span></div>';
					echo '<a class="event-link';
					if('true' == $event['canceled']) { echo ' canceled-event'; }
					echo '" itemprop="url" href="' . $event['url'] . '"><span itemprop="name">' . $event['title'] . '</span></a>';
				echo '</li>';
			}
			echo '</ul>';
		}
		?>
		<hr/>
		<p>Dates are subject to change.</p>
		<p>We encourage you to bookmark this page and use it as your reference throughout the semester. If you wish to print a copy or save a PDF version of this calendar, please open this page in the Google Chrome browser, then use the print link. You can change your printer to "Save as PDF" in Chrome to save a digital copy rather than printing a hard copy.</p>
		<button id="print-page-link" onclick="window.print();">Print</button>				
	</main>
</div>
<?php get_footer(); ?>