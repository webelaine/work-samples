<?php
/*
 * Template Name: Program Search
 */
 // set Online as the fallback
if($_GET['tag'] == 'evening') { $tag = 'evening';
} else {
	$tag = 'online';
}
$subdomain = get_option('stmu_subdomain');
// change Yoast title
add_filter('wpseo_title', 'filter_program_search_page_title');
function filter_program_search_page_title() {
	global $tag, $subdomain;
	if($subdomain == 'www') {
		$title = ucfirst($tag) . " Programs - St. Mary's University";
	} else {
		$title = ucfirst($tag) . " Programs - School of Law";
	}
	return $title;
}
// Adjust breadcrumbs
add_filter('wpseo_breadcrumb_links', 'stmu_2017_program_search_breadcrumbs');
function stmu_2017_program_search_breadcrumbs($links) {
	$addedBreadcrumbs[] = array('text' => 'Programs', 'url' => '/academics/programs/', 'allow_html' => 1);
	array_splice($links, 2, 0, $addedBreadcrumbs);
	return $links;
}
// identify www site "online" taxonomy term
$www_online_term_id = 0;
$response = wp_remote_get('https://www.stmarytx.edu/wp-json/wp/v2/avail/');
if(!is_wp_error($response) && $response['response']['code'] == 200) {
	$allAvailabilities = json_decode($response['body']);
	foreach($allAvailabilities as $ability) {
		if($ability->slug == 'online') {
			$www_online_term_id = $ability->id;
		}
	}
}
// identify law site "online" taxonomy term
$law_online_term_id = 0;
$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/avail/');
if(!is_wp_error($response) && $response['response']['code'] == 200) {
	$allAvailabilities = json_decode($response['body']);
	foreach($allAvailabilities as $ability) {
		if($ability->slug == 'online') {
			$law_online_term_id = $ability->id;
		}
	}
}
get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<div class="stmu-single-block">
		<div class="max-width">
			<?php the_content(); ?>
		</div>
	</div>
	<div class="stmu-single-block">
		<div class="max-width">
			<h2 id="class-type"><?php
				if($subdomain == 'www') { echo "St. Mary's University "; }
				echo ucfirst($tag);
			?> Programs</h2>
			<?php if($subdomain == 'www') { ?>
				<p>Please contact the St. Mary’s University Office of Graduate Admission at 210-436-3101 or <a href="mailto:graduate@stmarytx.edu">graduate@stmarytx.edu</a> with questions regarding these programs or the application process.</p>
			<?php } ?>
			<div class="post-circles">
				<?php
					$args = array(
						'no_found_rows' => true,
						'post_type' => 'program',
						'order' => 'ASC',
						'orderby' => 'title',
						'tax_query' => array(
							array(
								'taxonomy' => 'avail',
								'terms' => $tag,
								'field' => 'slug',
								'operator' => 'IN',
							)
						)
					);
					$programs = new WP_Query($args);
					if($programs->have_posts()):
						while($programs->have_posts()) : $programs->the_post();
							$programImgID = get_post_thumbnail_id($post->ID);
							$programAlt = get_post_meta($programImgID, '_wp_attachment_image_alt', true); ?>
							<a class="post-circle" href="<?php the_permalink(); ?>">
								<img src="<?php the_post_thumbnail_url('program'); ?>" alt="" />
								<h3><?php the_title(); ?></h3>
							</a>
							<?php
						endwhile;
					endif;
					wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
<?php if($subdomain == 'www') { ?>
	<div class="stmu-single-block">
		<div class="max-width">
			<h2>School of Law Online Programs</h2>
			<p>Please contact School of Law Admissions at 210-436-3523 or <a href="mailto:lawadmissions@stmarytx.edu">lawadmissions@stmarytx.edu</a> for questions regarding these programs or the application process.</p>
			<div class="post-circles">
			<?php
				$lawDegrees = '';
				$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/degree/?order=asc&orderby=name&per_page=100');
				if(!is_wp_error($response) && $response['response']['code'] == 200) {
					$allDegrees = json_decode($response['body']);
					foreach($allDegrees as $lawDegree) {
						// exclude "law degrees," which is a parent Degree with no Programs directly assigned to it
						if($lawDegree->count > 0) {
							$onlinePrograms = [];
							// get all Programs of this Degree
							$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/program?degree='. $lawDegree->id .'&order=asc&orderby=title&per_page=100&_embed');
							if(!is_wp_error($response) && $response['response']['code'] == 200) {
								$programs = json_decode($response['body']);
								// add any online programs to output
								foreach($programs as $program) {
									if(in_array($law_online_term_id, $program->avail)) {
										$lawDegrees .= '<a class="post-circle" href="' . $program->link . '">
											<img src="'
											. $program->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->program->source_url
											. '" alt="" />
											<h3>' . $program->title->rendered . '</h3>
										</a>';
									}
								}
							}
						}
					}
				}
				echo $lawDegrees;
			?>
			</div>
		</div>
	</div>
<?php } ?>
	<div class="stmu-single-block">
		<div class="max-width">
			<h2 id="all-programs">All Programs</h2>
			<a class="ghost-btn" href="https://law.stmarytx.edu/academics/programs/">Law Degrees and Programs</a>
			<a class="ghost-btn" href="https://www.stmarytx.edu/academics/programs/">St. Mary's University Degrees and Programs</a>
		</div>
	</div>
</main>
<?php get_footer(); ?>