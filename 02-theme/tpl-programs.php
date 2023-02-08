<?php
/*
 * Template Name: Programs
 */
get_header();
// www site
if($subdomain == 'www') {
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
	?>
	<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
		<div id="secondary-nav" class="headerContainer">
			<ul class="menu">
				<li><a href="#byInterest"><span>by</span> Interest</a></li>
				<li><a href="#byDegree"><span>by</span> Degree</a></li>
				<li><a href="#bySchool"><span>by</span> School</a></li>
				<li><a href="#special">Special Programs</a></li>
			</ul>
		</div>
		<section class="stmu-single-block text-center">
			<div class="max-width programSearch">
				<h2 id="byInterest">Search by Interest</h2>
					<p>Type in a subject you enjoy, and we'll show you a list of majors, minors and programs that match your interests.</p>
					<form class="search-container">
						<label for="st-program-search" class="show-for-sr">Search Programs</label>
						<input type="text" class="st-program-search-input" id="st-program-search" data-st-install-key="xTxbyUaoBzaWdR_g62Cs" placeholder="Art, math, geometry, business..." autocomplete="off"><button type="submit" name="program">&#xf002;<span class="show-for-sr">Search</span></button>
					</form>
			</div>
		</section>
		<section class="stmu-single-block text-center">
			<div class="max-width">
				<h2 id="special">Special Programs</h2>
				<p>In addition to majors, minors and graduate programs, St. Mary's offers a variety of special academic programs. Most special programs can be combined with any degree or certificate.</p>
				<div class="post-circles">
					<?php
						$specialPrograms = get_posts(array(
								'post_type' => 'specialprogram',
								'numberposts' => -1,
								'posts_per_page' => -1,
								'order' => 'ASC',
								'orderby' => 'title',
								'post_status' => 'publish',
								'post_parent' => 0	// only get top-level special programs, not children
							)
						);
						foreach($specialPrograms as $specialProgram) {
							$id = $specialProgram->ID;
							$imgID = get_post_thumbnail_id($id);
							if(!$imgID) {
								$imgInfo[0] = get_site_icon_url('200');
							} else {
								$imgInfo = wp_get_attachment_image_src($imgID, 'program');
							}
							echo '<a class="post-circle" href="' . get_permalink($id) . '"><img src="' . $imgInfo[0] .'" alt="" /><h3>' . $specialProgram->post_title . '</h3></a>';
						}
					?>
				</div>
			</div>
		</section>
		<section class="stmu-single-block text-center">
			<div class="max-width">
				<h2 id="byDegree">Browse Programs by Degree</h2>
				<hr/>
				<h3 id="undergradPrograms">Undergraduate Degrees</h3>
					<?php // undergraduate
					$undergraduate_data = get_term_by('slug', 'undergraduate', 'degree');
					$undergraduate_id = $undergraduate_data->term_id;
					$undergraduate_degree_terms = get_terms('degree', array('child_of' => $undergraduate_id));
					foreach($undergraduate_degree_terms as $degree) {
						$degrees = '';
						$myposts = get_posts(array(
							'post_type' => 'program',
							'numberposts' => -1,
							'posts_per_page' => -1,
							'offset' => 0,
							'order' => 'ASC',
							'orderby' => 'title',
							'tax_query' => array(
								array(
								'taxonomy' => 'degree',
								'field' => 'slug',
								'terms' => array($degree->slug))
								)
							)
						);
						foreach($myposts as $mypost) {
							$postID = $mypost->ID;
							$availability_terms = get_the_terms($postID, 'avail');
							$available = '';
							if(false != $availability_terms) {
								foreach($availability_terms as $term) {
									if($term->term_id == $www_online_term_id) {
										$available = '<em> - available online</em>';
									}
								}
							}
							$degrees .= '<li><a href="' . get_permalink($postID) . '">' . $mypost->post_title . $available . '</a></li>';
						}
						echo '<details><summary><h4>' . $degree->name . '</h4></summary><ul>' . $degrees . '</ul></details>';
					} ?>
				<hr/>
				<h3 id="gradPrograms">Graduate Degrees and Programs</h3>
					<?php // graduate
					$graduate_data = get_term_by('slug', 'graduate', 'degree');
					$graduate_id = $graduate_data->term_id;
					$graduate_degree_terms = get_terms('degree', array('child_of' => $graduate_id));
					foreach($graduate_degree_terms as $degree) {
						$degrees = '';
						$myposts = get_posts(array(
							'post_type' => 'program',
							'numberposts' => -1,
							'posts_per_page' => -1,
							'offset' => 0,
							'order' => 'ASC',
							'orderby' => 'title',
							'tax_query' => array(
								array(
								'taxonomy' => 'degree',
								'field' => 'slug',
								'terms' => array($degree->slug))
								)
							)
						);
						foreach($myposts as $mypost) {
							$postID = $mypost->ID;
							$availability_terms = get_the_terms($postID, 'avail');
							$available = '';
							if(false != $availability_terms) {
								foreach($availability_terms as $term) {
									if($term->term_id == $www_online_term_id) {
										$available = '<em> - available online</em>';
									}
								}
							}
							$degrees .= '<li><a href="' . get_permalink($postID) . '">' . $mypost->post_title . $available . '</a></li>';
						}
						echo '<details><summary><h4>' . $degree->name . '</h4></summary><ul>' . $degrees . '</ul></details>';
					} ?>
					<a class="ghost-btn" href="/academics/online-learning/">Online Graduate Programs</a>
				<hr/>
				<h3 id="lawDegrees">Law Degrees</h3>
					<?php // law
						// get degrees
						$lawDegrees = '';
						$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/degree/?order=asc&orderby=name&per_page=100');
						if(!is_wp_error($response) && $response['response']['code'] == 200) {
							$allDegrees = json_decode($response['body']);
							foreach($allDegrees as $lawDegree) {
								// exclude "law degrees," which is a parent Degree with no Programs directly assigned to it
								$lawDegrees = '';
								if($lawDegree->count > 0) {
									// now get the PROGRAMS of this degree
									$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/program?degree='. $lawDegree->id .'&order=asc&orderby=title&per_page=100');
									if(!is_wp_error($response) && $response['response']['code'] == 200) {
										$programs = json_decode($response['body']);
										// first loop: output parent
										foreach($programs as $program) {
											if($program->parent == 0) {
												if(in_array($law_online_term_id, $program->avail)) { $available = '<em> - available online</em>'; } else { $available = ''; }
												$lawDegrees .= '<li><a href="' . $program->link . '">' . $program->title->rendered . $available . '</a></li>';
											}
										}
										// second loop: output children
										foreach($programs as $program) {
											if($program->parent != 0) {
												if(in_array($law_online_term_id, $program->avail)) { $available = '<em> - available online</em>'; } else { $available = ''; }
												$lawDegrees .= '<li><a href="' . $program->link . '">' . $program->title->rendered . $available . '</a></li>';
											}
										}
									}
									echo '<details><summary><h4>' . $lawDegree->name . '</h4></summary><ul>' . $lawDegrees . '</ul></details>';
								}
							}
						}
					?>
				<hr/>
				<h3 id="combined">Combined Degrees</h3>
				<p><a href="/academics/special-programs/combined-programs/">Learn more about combined Bachelor's and Master's Programs</a></p>
			</div>
		</section>
		<section class="stmu-single-block text-center shade-headings">
			<div class="max-width">
				<h2 id="bySchool">Browse Programs by School</h2>
				<?php $schools = get_terms('school', array('hide_empty' => false,));
				foreach($schools as $school) {
					// www schools: pull with get_posts()
					if($school->slug != 'school-law') {
						// undergrad for this school
						$undergradDegrees = '';
						$unDegrees = get_posts(array(
							'post_type' => 'program',
							'numberposts' => -1,
							'posts_per_page' => -1,
							'offset' => 0,
							'order' => 'ASC',
							'orderby' => 'title',
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => 'school',
									'field' => 'slug',
									'terms' => array($school->slug)
								),
								array(
									'taxonomy' => 'degree',
									'field' => 'slug',
									'terms' => array('undergraduate')
								)
							)
						));
						foreach ($unDegrees as $unDegree) {
							$postID = $unDegree->ID;
							$undergradDegrees .= '<li><a href="' . get_permalink($postID) . '">' . $unDegree->post_title . '</a></li>';
						}
						// grad for this school
						$gradDegrees = '';
						$grDegrees = get_posts(array(
							'post_type' => 'program',
							'numberposts' => -1,
							'posts_per_page' => -1,
							'offset' => 0,
							'order' => 'ASC',
							'orderby' => 'title',
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => 'school',
									'field' => 'slug',
									'terms' => array($school->slug)
								),
								array(
									'taxonomy' => 'degree',
									'field' => 'slug',
									'terms' => array('graduate')
								)
							)
						));
						foreach ($grDegrees as $grDegree) {
							$postID = $grDegree->ID;
							$gradDegrees .= '<li><a href="' . get_permalink($postID) . '">' . $grDegree->post_title . '</a></li>';
						}
						echo '<details><summary><h3>' . $school->name . '</h3></summary>
								<h4>Undergraduate Programs</h4>
								<ul>' . $undergradDegrees . '</ul>
								<h4>Graduate Programs</h4>
								<ul>' . $gradDegrees . '</ul>
							</details>';
					// law school: pull with REST API
					} else { // law
						// get degrees
						$lawDegrees = '';
						$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/degree/?order=asc&orderby=name&per_page=100');
						if(!is_wp_error($response) && $response['response']['code'] == 200) {
							$allDegrees = json_decode($response['body']);
							foreach($allDegrees as $lawDegree) {
								// exclude "law degrees," which is a parent Degree with no Programs directly assigned to it
								if($lawDegree->count > 0) {
									// show a heading for this degree
									$lawDegrees .= '<h4>' . $lawDegree->name . '</h4><ul>';
									// now get the PROGRAMS of this degree
									$response = wp_remote_get('https://law.stmarytx.edu/wp-json/wp/v2/program?degree='. $lawDegree->id .'&order=asc&orderby=title&per_page=100');
									if(!is_wp_error($response) && $response['response']['code'] == 200) {
										$programs = json_decode($response['body']);
										// first loop: output parent
										foreach($programs as $program) {
											if($program->parent == 0) {
												if(in_array($law_online_term_id, $program->avail)) { $available = '<em> - available online</em>'; } else { $available = ''; }
												$lawDegrees .= '<li><a href="' . $program->link . '">' . $program->title->rendered . $available . '</a></li>';
											}
										}
										// second loop: output children
										foreach($programs as $program) {
											if($program->parent != 0) {
												if(in_array($law_online_term_id, $program->avail)) { $available = '<em> - available online</em>'; } else { $available = ''; }
												$lawDegrees .= '<li><a href="' . $program->link . '">' . $program->title->rendered . $available . '</a></li>';
											}
										}
									}
									$lawDegrees .= '</ul>';
								}
							}
						}
						echo '<details><summary><h3>' . $school->name . '</h3></summary>' . $lawDegrees . '</details>';
					}
				} ?>
			</div>
		</section>
	</main><?php
// law site
} else { ?>
	<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
		<section id="byDegree" class="stmu-single-block">
			<div class="max-width">
				<?php the_content(); ?>
			</div>
		</section>
		<section class="stmu-single-block">
			<div class="max-width">
				<div class="text-center">
					<h2>All Law Degree Programs</h2>
						<?php // all law degrees
						$law_data = get_term_by('slug', 'law-degrees', 'degree');
						$law_degrees = get_terms('degree', array('child_of' => $law_data->term_id));
						foreach($law_degrees as $law_degree) {
							$degrees = '';
							$myposts = get_posts(array(
								'post_type' => 'program',
								'numberposts' => -1,
								'post_parent' => 0,			// get just the parent program for the current degree
								'posts_per_page' => -1,
								'offset' => 0,
								'order' => 'ASC',
								'orderby' => 'title',
								'tax_query' => array(
									array(
										'taxonomy' => 'degree',
										'field' => 'slug',
										'terms' => array($law_degree->slug))
									)
								)
							);
							foreach($myposts as $mypost) {
								$postID = $mypost->ID;
								$degrees .= '<li><a href="' . get_permalink($postID) . '">' . $mypost->post_title;
								$availability_terms = get_the_terms($postID, 'avail');
								$evening = 0;
								$online = 0;
								if(false != $availability_terms) {
									foreach($availability_terms as $availability) {
										if($availability->slug == 'evening') { $evening = 1; }
										if($availability->slug == 'online') { $online = 1; }
									}
								}
								if($online == '1') {
									$degrees .= '<em> - available online</em>';
								}
								$degrees .= '</a></li>';

								// Child programs (MJur concentrations, or JD options)
								// This part has to be nested for special cases like LLM, where we'll eventually have
								// LLM (general) with its child concentrations; followed by LLMs which are separate parent-level degrees with no children
								$children = get_pages(array('child_of' => $postID, 'post_type' => 'program'));
								if(count($children) > 0) {
									foreach($children as $child) {
										$degrees .= '<li><a href="' . get_permalink($child->ID) . '">' . $child->post_title;
										$availability_terms = get_the_terms($child->ID, 'avail');
										$evening = 0;
										$online = 0;
										if(false != $availability_terms) {
											foreach($availability_terms as $availability) {
												if($availability->slug == 'evening') { $evening = 1; }
												if($availability->slug == 'online') { $online = 1; }
											}
										}
										if($online == '1') {
											$degrees .= '<em> - available online</em>';
										}
										$degrees .= '</a></li>';
									}
								}
							}
							echo '<details open><summary><h3>' . $law_degree->name . '</h3></summary><ul>' . $degrees . '</ul></details>';	
						} ?>
					</ul>
				</div>
			</div>
		</section>
	</main>
<?php }
get_footer(); ?>