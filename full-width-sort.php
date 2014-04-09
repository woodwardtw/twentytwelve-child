<?php


/**
 * Template Name: Attached images sort gallery
 *
 */
get_header('sort'); 
?>

  <div id="primary" class="content">
    <div id="content" role="main">
    
				<?php get_template_part( 'content', 'page' ); ?>

      <ul id="filters">
        <li class="filter" data-filter="all">All</li>
        <?php
          $args = array('exclude' => '108');
          // List all categories, we want to exclude 
          // Change the arguments as you like
          $categories = get_categories($args);
          foreach ($categories as $category) {
            echo '<li class="filter" data-filter="'. $category->slug .'">'. $category->name .'</li>';
          }
        ?>
      </ul>
      <?php 
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();  // start the loop ?>
        <ul id="mixer">
          <?php
            $args = array('post_type' => 'attachment', 'posts_per_page' => 35);
            // Get all attachments
            // Change the arguments as you like
            $attachments = get_posts($args);
            if ($attachments) {
              foreach ($attachments as $attachment) {
                $post_id = $attachment->post_parent;
                $post_cat = get_the_category($post_id);
                $post_title = get_the_title($post_id);
                $cat_name = $post_cat[0]->cat_name;
                $cat_slug = $post_cat[0]->slug;

                echo '<li class="mix '.$cat_slug.'">';
                // We are using the category slug to order the images
                echo '<a href="'. wp_get_attachment_url($attachment->ID) .'">';
                // Let's link everything to the full size image URL
                echo wp_get_attachment_image($attachment->ID, 'thumbnail');
                // Display the thumbnail
                echo '<p>';
                echo 'Cat: '. $cat_name .'<br />';
                echo 'Post title: '. $post_title .'<br />';
                echo 'Image: '. apply_filters('the_title', $attachment->post_title);
                echo '</p></a></li>';
                // Display the post category name, the post title, and the image title
              }
            }
            }
            }
          ?>
          <li class="break"></li>
        </ul>

    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>