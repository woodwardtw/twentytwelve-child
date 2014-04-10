<?php


/**
 * Template Name: Featured image sort by page name/category
 *
 */
get_header('sort'); 
?>

  <div id="primary" class="content">
	<div id="content" role="main">


		<?php get_template_part( 'content', 'page' ); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); //this chunk puts the page text into play?>
		  <div class="entry-content">
			<?php the_content(); ?>
		  </div>
		 <?php global $post;
			$slug = get_post( $post )->post_name; // this gets the name of the page
		// 	echo $slug .'<br/>';  I was using this to test the response prior to writing the rest of the stuff. 
		 	$idObj = get_category_by_slug($slug);  // this takes the name and makes it a slug
		 	$idcat = $idObj->term_id; //this turns the slug into a category number
		// 	echo $idcat;  //this was for testing
;?>
<?php endwhile; endif; ?>

	  <ul id="filters">
		<li class="filter" data-filter="all">All</li>
		<?php  //this sets up the filtering buttons based on categories
		  $args = array('exclude' => $idcat); // Remember $idcat from above, this excludes it from the filter list - I need to expand to remove all page titles form the list. You can also add agruments here of other types.
		  $categories = get_categories($args);
		  foreach ($categories as $category) {
			echo '<li class="filter" data-filter="'. $category->slug .'">'. $category->name .'</li>'; // more slug category stuff for the filter buttons
		  }
		?>
	  </ul>
			<ul id="mixer">
		  <?php //this is where the thumbnails are generated
			$args = array('cat' => $idcat,'post_type' => 'post', 'posts_per_page' => 40);
			// make all attachments above
			// Change the arguments as you like
			$thumbnails = get_posts($args);
			if ($thumbnails) {
			  foreach ($thumbnails as $thumbnail) { //generates the thumbnails in a loop
				$post_id = $thumbnail;
				$post_cat = get_the_category($post_id);
				$post_title = get_the_title($post_id);
				$categories = get_the_category($post_id);
				$separator = ' '; //makes a space between categories but you could change it to other stuff
				$output = '';
				if ($categories){ //loops through the categories per post
					foreach ($categories as $category ) {
						$output .= $category->slug.$separator;
					}
				}

				echo '<li class="mix '.$output.'">'; // adds the categories as class elements 
				echo '<a href="'. get_permalink ($thumbnail) .'">';
				echo get_the_post_thumbnail($thumbnail->ID, 'thumbnail'); // get and display thumbnail based on the featured image- use the http://wordpress.org/plugins/auto-post-thumbnail/ to generate them automatically based on the first image in the post
				echo '<p>';
				echo $post_title .'<br />'; // post title which is probably obvious
				echo '</p></a></li>';
			  }
			}
	?>
	
		  <li class="break"></li>
		</ul>

	</div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>