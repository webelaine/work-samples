<?php get_header(); global $subdomain; get_header();
global $post;
$degrees = get_the_terms($post, 'degree');
if(is_array($degrees)) { // Nursing has no degree attached, so skip this logic if we're on that program
	foreach($degrees as $degree) {
		// If it's a top-level term (Graduate or Undergraduate)
		if($degree->parent == 0) {
			if($degree->slug == 'undergraduate') {
				$prereq = 'High school diploma';
			} elseif($degree->slug == 'graduate') {
				$prereq = "Bachelor's degree";
			}
		// If it's not a top-level term (it's an actual specific degree - there may be multiple offered)
		} else {
			if(stripos($degree->slug, 'doctor' != false)) {
				$prereq = "Master's degree";
			}
			// Full degree name
			$stripped_title = str_replace('Master of ', '', get_the_title());
			$stripped_title = str_replace('Doctor of ', '', $stripped_title);
			$award = $degree->name . ' in ' . $stripped_title;
		?>
			<script type="application/ld+json">
				{
					"@context": "https://schema.org/",
					"@type": "EducationalOccupationalProgram",
					"name": "<?php the_title(); ?>",
					"url": "<?php the_permalink(); ?>",
					"provider": {
						"@type": "CollegeOrUniversity",
						"name": "St. Mary's University",
						"address": {
							"@type": "PostalAddress",
							"streetAddress": "1 Camino Santa Maria",
							"addressLocality": "San Antonio",
							"addressRegion": "TX",
							"postalCode": "78228"
						}
					},
					"programPrerequisites": {
						"@type": "EducationalOccupationalCredential",
						"credentialCategory": "<?php echo $prereq; ?>"
					},
					"educationalCredentialAwarded": {
						"@type": "EducationalOccupationalCredential",
						"credentialCategory": "<?php echo $award; ?>"
					}
				}
			</script><?php
		}
	}
}
?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<?php global $post;
		// If Child (Concentration)
		if($post->post_parent != 0) { ?>
		<div class="stmu-single-block"><div class="max-width"><?php
			$parent_program = get_post($post->post_parent);
			$pretext = '<h2><i class="fa fa-certificate" aria-hidden="true"></i> ' . $parent_program->post_title . '</h2>
				<p>The <strong>' . get_the_title() . '</strong> is just one of your options. See the main <a href="' . get_the_permalink($parent_program) . '">' . $parent_program->post_title . '</a> page for details about the overall program and other available options.</p></div></div>';
			echo $pretext;
		}
		// if Parent, use a block to list the Children (Concentrations), so intro text appears first
	?>
	<?php the_content(); ?>
</main>
<?php get_footer(); ?>