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
		<?php if (have_posts()) : while (have_posts()) : the_post(); //this chunk displays the page text ?>
		  <div class="entry-content">
			<?php the_content(); ?>
		  </div>
		
<?php endwhile; endif; ?>

	  <div class="controls">
		<button class="filter" data-filter="all">All</li>
		<?php  //this sets up the filtering buttons based on categories and removes all categories that are the same as page titles
		    $pages = get_pages(); //what pages exist?
		    	  $idcat = array(); //make them a list
		    	  foreach ( $pages as $page ) { //for each page
		    		$option = $page->post_title; //get the name of the page
		    		$idObj = get_category_by_slug($option); //make that name into the slug (essentially add the dashes)
		    		$idcat[] = $idObj->term_id; //Take that name and change it into the ID of the category so it can be removed from the sorting diplsay below. I also now know the square brackets build an array thanks to Alan Levine (@cogdog). 
		    	}
		    
		     $args = array('exclude' => implode(",", $idcat)); // takes $idcat list from above to exclude the categories that are the same as the page names from the filter list. Implode changes it from an array into a string which get_categories needs. You can also add agruments here of other types.
		 	$categories = get_categories($args);
		  	foreach ($categories as $category) {
			echo '<button class="filter" data-filter="'. $category->slug .'">'. $category->name .'</button>'; // more category stuff to create the filter buttons- sets the class to the slug and displays the actual category name
		  }
		?>
	  </div>
	  
	  <?php global $post;
	  			$slug = get_post( $post )->post_name; // this gets the name of the page
	  		 	$idObj = get_category_by_slug($slug);  // this takes the name and makes it a slug
	  		 	$include = $idObj->term_id; //this turns the slug into a category number so it can be used to pull in all the posts with the same category as the page name. A page named 'Bob' will pull in all posts with the category 'Bob'
	  ?>
	  
			<ul id="mixer">
		  <?php //this is where the thumbnails are generated
			$args = array('cat' => $include,'post_type' => 'post', 'posts_per_page' => 40);//I limited display to 40 posts out of performance fears. You could add other arguments here.
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