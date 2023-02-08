<?php get_header(); ?>
<style type="text/css">
	.post-connector { justify-content:space-between; }
	.magazine-issue {
		display:flex; flex-wrap:wrap; justify-content:space-around;
	}
	.issue-description { margin:.5em; display:flex; flex-wrap:wrap; flex-direction:column; justify-content:space-around; display:grid; }
	.issue-description .wp-caption p { margin:0; }
	.category-magazine .wp-caption { max-width:none!important; margin:0 0 auto; background:#f2bf49; }
	.category-magazine .wp-caption p { color:#036; }
	.category-magazine .wp-caption a:hover p, .category-magazine .wp-caption a:focus p { color:#048; }
	.category-magazine .wp-caption a:hover, .category-magazine .wp-caption a:focus { text-decoration:none; }
	.issue-description .max-width > div.wp-caption:first-child { margin-bottom:1em; }
	
	@media screen and (min-width:537px) {
		.magazine-issue {
			display:flex; flex-wrap:wrap; justify-content:space-around;
			display:grid; grid-gap:1em; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); grid-template-rows:repeat(auto-fit, minmax(250px, 1fr));
		}
		div.issue-description { grid-column: 1 / span 1; grid-row: 1 / span 2;
	}
	
	@media screen and (min-width:1080px) {
		a.post-item.cover-post {
			flex:3 0 800px;
			grid-column: 1 / span 3; grid-row: 1 / span 2; max-width:100%; max-height:595px;
		}
		a.post-item.cover-post .overlay { background:rgba(242,191,73,.8); color:#036; }
		a.post-item.cover-post:hover .overlay, a.post-item.cover-post:focus .overlay { background:#f2bf49; border-top:2px solid #036; }
		div.issue-description { grid-column: 4 / span 1; grid-row: 1 / span 2; }
		a.post-item { max-width:280px; max-height:280px; }
	}
</style>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<?php
	// School-specific stories, linked from school homepages
	if(	$_GET['school'] == 'school-set' ||
		$_GET['school'] == 'school-humanities' ||
		$_GET['school'] == 'school-law' ||
		$_GET['school'] == 'school-business'
	) {
		$schoolterm = get_term_by('slug', $_GET['school'], 'school');
		$schooltermid = (int)$schoolterm->term_id;
		?>
		<div class="stmu-single-block">
			<div class="max-width"><p>This is a sampling of <em>Gold &amp; Blue</em> magazine stories from this school. To see stories from the Schools and College at St. Mary's, <a href="/magazine/">visit the full Magazine page</a>.</p></div>
		</div>
		<?php
		// Unpaginated
		$taxonomy = 'issue';
		$issues = get_terms(array('taxonomy' => 'issue', 'include' => 'all', 'offset' => $offset, 'orderby' => 'slug', 'order' => 'DESC'));
		if(count($issues) > 0) {
			foreach($issues as $issue) {
				// get posts in this issue
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => -1,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'issue',
							'field' => 'term_id',
							'terms' => $issue->term_id,
							'operator' => 'IN'
						),
						array(
							'taxonomy' => 'school',
							'field' => 'term_id',
							'terms' => $schooltermid,
							'operator' => 'IN'
						)
					) // include the cover story - as opposed to non-school-specific, which excludes the cover story
				);
				$spotlights = new WP_Query($args);
				// display posts
				if($spotlights->have_posts()) {
					echo '<div class="stmu-single-block"><div class="max-width">';
					echo '<h2>' . $issue->name . '</h2>';
					echo '<div class="magazine-issue">';
					while($spotlights->have_posts()): $spotlights->the_post();
						echo '<a class="post-item" href="' . get_the_permalink()  . '" style="background-image:url(\'';
						echo get_the_post_thumbnail_url(get_the_id(), 'spotlight') . '\');" />';
						if(has_tag('cover', get_the_ID())) {
							echo '<div class="news-overlay">Cover Story</div>';
						}
						echo '<div class="overlay">' . get_the_title() . '</div>';
						echo '</a>';
					endwhile;
					echo '</div>'; // div.magazine-issue
					echo '</div></div>'; // .max-width, .block to close this issue
				}
			}
		}
	// Default - show all stories	
	} else {
		// set up manual pagination, because get_terms() doesn't support it natively
		$taxonomy = 'issue';
		$number = 3; // number of issues to display per page
		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$offset = ($page > 0) ? $number * ($page - 1) :1;
		$totalterms = wp_count_terms($taxonomy, array('hide_empty' => TRUE));
		$totalpages = ceil($totalterms / $number); ?>
			<?php if(empty($_GET['issue'])) { ?>
			<div class="stmu-single-block">
				<div class="max-width twothirdssplit">
					<div class="twoleft">
						<p>
							<?php if($page == 1) { ?>
								Through the <em>Gold &amp; Blue</em> university magazine, St. Mary's shares news and unique stories in order to build a strong foundation of community and educate and showcase leaders for the common good. <em>Gold &amp; Blue</em> is produced for alumni and friends by the Office of University Communications.<?php
							} else {
								echo "Page $page of $totalpages";
							} ?>
						</p>
						<p>The <a href="https://law.stmarytx.edu/academics/about/law_magazine/"><em>Gold &amp; Blue Law Edition</em></a> is available on the School of Law website.</p>
						<p>Submit <a href="https://alumni.stmarytx.edu/connect/class-notes/">Class Notes online</a> or email story ideas to <a href="mailto:ucomm@stmarytx.edu">ucomm@stmarytx.edu</a>.</p>
					</div>
					<div class="text-right oneright">
						<form method="POST" class="search-container">
							<label for="st-post-search" class="show-for-sr">Search News and Magazine</label>
							<input type="text" class="st-default-search-input" id="st-post-search" data-st-install-key="HRGTzKaHX_Z-1ZZPwusc" placeholder="Search news and magazine" autocomplete="off" autocorrect="off" autocapitalize="off">
							<button type="submit" name="dirsearch">&#xf002;<span class="show-for-sr">Search</span></button>
						</form>
						<a class="ghost-btn" href="/news/">News</a>
					</div>
				</div>
			</div>
		<?php }
			// Single issue - linked from individual spotlights as "more from this issue"
			if(!empty($_GET['issue'])) {
				$issues = get_terms(array('taxonomy' => 'issue', 'include' => $_GET['issue']));
			// Default
			} else {
				$issues = get_terms(array('taxonomy' => 'issue', 'number' => $number, 'offset' => $offset, 'orderby' => 'slug', 'order' => 'DESC'));
			}
			if(count($issues) > 0) {
				foreach($issues as $issue) {
					echo '<div class="stmu-single-block"><div class="max-width">';
						echo '<h2>' . $issue->name . '</h2>';
						// Check whether there is a cover story for this issue
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => 1,
							'tax_query' => array(
								array(
									'taxonomy' => 'issue',
									'field' => 'term_id',
									'terms' => $issue->term_id
								)
							),
							'tag' => 'cover'
						);
						$cover = new WP_Query($args);
						// Yes cover story
						if($cover->have_posts()) {
							echo '<div class="magazine-issue">';
							while($cover->have_posts()): $cover->the_post();
								echo '<a class="post-item cover-post" href="' . get_the_permalink() . '" style="background-image:url(\'';
								echo get_the_post_thumbnail_url(get_the_id(), 'large') . '\');" />';
								echo '<div class="overlay">' . get_the_title() . '</div>';
								echo '</a>';
							endwhile;
							if($issue->description) {
								?><div class="issue-description"><?php echo apply_filters('the_content', $issue->description); ?></div><?php
							}
						}
						// No cover story
						else {
							// If description
							if($issue->description) {
								?><div class="issue-description"><?php echo apply_filters('the_content', $issue->description); ?></div><?php
							}
							// No description
							else {
								echo '<p>The new issue is on the way! Check back for more content as we continue to post web exclusives and full stories.</p>';
							}
							echo '<div class="magazine-issue">';
						}
						// get posts in this issue
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => -1,
							'tax_query' => array(
								array(
									'taxonomy' => 'issue',
									'field' => 'term_id',
									'terms' => $issue->term_id
								)
							),
							'tag__not_in' => array('791'), // exclude "Cover Story" tag
						);
						$spotlights = new WP_Query($args);
						// display posts
						if($spotlights->have_posts()) {
							while($spotlights->have_posts()): $spotlights->the_post();
								echo '<a class="post-item" href="' . get_the_permalink()  . '" style="background-image:url(\'';
								echo get_the_post_thumbnail_url(get_the_id(), 'spotlight') . '\');" />';
								if(has_tag('cover', get_the_ID())) {
									echo '<div class="news-overlay">Cover Story</div>';
								}
								echo '<div class="overlay">' . get_the_title() . '</div>';
								echo '</a>';
							endwhile;
						}
					echo '</div>'; // div.magazine-issue
					echo '</div></div>'; // .max-width, .stmu-single-block to close this issue
				}
				if(empty($_GET['issue'])) { ?>
				<div class="stmu-single-block">
					<div class="max-width"><p><?php
						$big = 999999999; // need an unlikely integer
						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $totalpages
						) ); ?>
					</p></div>
				</div><?php }
			}
	} // end "else" all stories (as opposed to "if" school-specific) ?>
</main>
<?php get_footer(); ?>