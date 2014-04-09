<?php


/**
 * Template Name: Attached images sort gallery by category POST
 *
 */
get_header('sort'); 
?>

  <div id="primary" class="content">
	<div id="content" role="main">


		<?php get_template_part( 'content', 'page' ); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post();?>
		  <div class="entry-content">
			<?php the_content(); ?>
		  </div>
		 <?php global $post;
			$slug = get_post( $post )->post_name;
		// 	echo $slug .'<br/>';  I was using this line and the one below to test the responses prior to using them. 
		 	$idObj = get_category_by_slug($slug); 
		 	$idcat = $idObj->term_id;
		// 	echo $idcat;
;?>
<?php endwhile; endif; ?>

	  <ul id="filters">
		<li class="filter" data-filter="all">All</li>
		<?php
		  $args = array('exclude' => $idcat);
		  // List all categories, we want to exclude 
		  // Change the arguments as you like
		  $categories = get_categories($args);
		  foreach ($categories as $category) {
			echo '<li class="filter" data-filter="'. $category->slug .'">'. $category->name .'</li>';
		  }
		?>
	  </ul>
			<ul id="mixer">
		  <?php
			$args = array('cat' => $idcat,'post_type' => 'post', 'posts_per_page' => 40);
			// Get all attachments
			// Change the arguments as you like
			$thumbnails = get_posts($args);
			if ($thumbnails) {
			  foreach ($thumbnails as $thumbnail) {
				$post_id = $thumbnail;
				$post_cat = get_the_category($post_id);
				$post_title = get_the_title($post_id);
				$categories = get_the_category($post_id);
				$separator = ' ';
				$output = '';
				if ($categories){
					foreach ($categories as $category ) {
						$output .= $category->slug.$separator;
					}
				}

				echo '<li class="mix '.$output.'">';
				// We are using the category slug to order the images
				echo '<a href="'. get_permalink ($thumbnail) .'">';
				// Let's link everything to the full size image URL
				echo get_the_post_thumbnail($thumbnail->ID, 'thumbnail');
				// Display the thumbnail
				echo '<p>';
				echo $post_title .'<br />';
				echo '</p></a></li>';
				// Display the post category name, the post title, and the image title
			  }
			}
	?>
	
		  <li class="break"></li>
		</ul>

	</div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>