			<?php // School banner
			// If this is a singular school CPT
			if(is_singular(array('business', 'humanities', 'set'))) {
				if(is_singular('business')) { $school = 'school-business'; }
				elseif(is_singular('humanities')) { $school = 'school-humanities'; }
				elseif(is_singular('set')) { $school = 'school-set'; }
				$singleTerm = get_term_by('slug', "$school", 'school');
				$terms[0] = $singleTerm;
			}
			// If a school taxonomy is assigned
			elseif(has_term('', 'school')) {
				$terms = get_the_terms('', 'school');
			} if($terms) {
				?>
				<div class="schoolBanner" style="background-image:url('<?php echo get_field('school_image', $terms[0]); ?>');">
					<a href="<?php echo get_field('school_homepage_url', $terms[0]); ?>"><div class="blueFader">
						<div class="schoolInfo">
							<h2><?php echo $terms[0]->description; ?></h2>
							<p><?php echo get_field('school_text', $terms[0]); ?></p>
						</div>
					</div></a>
				</div><?php
			} ?>