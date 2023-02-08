<nav class="child-nav-wrapper" aria-labelledby="leftHead">
	<h2 class="hidePrint child-nav-heading" id="leftHead">In this Section</h2>
	<ul class="childNav open">
		<?php
		if(is_page()) {
			if($post->post_parent) {
				$ancestors = get_post_ancestors($post->ID);
				$root = count($ancestors)-1;
				$parent = $ancestors[$root];
			} else {
				$parent = $post->ID;
			}
			$children = wp_list_pages("title_li=&child_of=".$parent."&echo=0&post_status=publish&sort_column=post_title&sort_order=ASC");
			if($children) {
				$parent_title = get_the_title($parent); ?>
				<li class="page_parent"><a href="<?php echo get_permalink($parent) ?>"><?php echo $parent_title; ?></a></li>
				<?php echo wp_list_pages("title_li=&child_of=".$parent."&echo=0&post_status=publish&sort_column=post_title&sort_order=ASC");
			}
		// CPTs - i.e. "business" pages
		} else {
			$post_type = get_post_type();
			if($post_type) {
				$object = get_post_type_object($post_type);
				echo '<li class="page_parent">';
				if(!is_archive()) {
					echo '<a href="/' . $object->rewrite['slug'] . '/">' . $object->labels->name . '</a>';
				} else {
					echo $object->labels->name;
				}
				echo '</li>';
				wp_list_pages(array(
					'post_type' => "$post_type",
					'title_li' => '',
					'post_status' => 'publish',
					'sort_column' => 'post_title',
					'walker' => new childNav_walker)
				);
			}
		}
		?>
	</ul>
</nav>