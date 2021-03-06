<?php

function load_stylesheets()
{
  wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',
        array(), false, 'all');
  wp_enqueue_style('bootstrap');

  wp_register_style('style', get_template_directory_uri() . '/style.css',
        array(), false, 'all');
  wp_enqueue_style('style');
}
add_action('wp_enqueue_scripts', 'load_stylesheets');


function include_jquery()
{
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-3.4.1.min.js', '', '1', false);

    add_action('wp_enqueue_scripts', 'jquery');
}
add_action('wp_enqueue_scripts', 'include_jquery');


function loadjs()
{
  wp_register_script('customjs', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1', false);
  wp_enqueue_script('customjs');
}
add_action('wp_enqueue_scripts', 'loadjs');

add_theme_support('menus');

add_theme_support('post-thumbnails');

register_nav_menus(
  array(
      'top-menu' => __('Top Menu', 'theme'),
      'footer-menu' => __('Footer menu', 'theme'),
      'page-menu' => __('Page menu', 'theme')
  )
);

add_image_size('smallest', 300, 300, true);
add_image_size('largest', 800, 800, true);

/* Activate HTML5 feature */
add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));


function wpb_postsbycategory() {
// the query
$the_query = new WP_Query( array( 'category_name' => 'News', 'posts_per_page' => 1 ) );

// The Loop
if ( $the_query->have_posts() ) {
    $string .= '<ul class="postsbycategory widget_recent_entries">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
            if ( has_post_thumbnail() ) {
            $string .= '<li>';
            $string .= '<a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($post_id, array( 50, 50) ) . get_the_title() .'</a></li>';
            } else {
            // if no featured image is found
            $string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>';

return $string;

/* Restore original Post Data */
wp_reset_postdata();
}
// Add a shortcode
add_shortcode('categoryposts', 'wpb_postsbycategory');

// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');


// Add Widget Areas
function ourWidgetsInit() {

	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}

add_action('widgets_init', 'ourWidgetsInit');

function wpdocs_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );



// Get top ancestor
// function get_top_ancestor_id() {
//   global $cat;
//
//   if ($cat->parent) {
//     $ancestors = array_reverse(get_post_ancestors($cat->term_id));
//     return $ancestors[0];
//   }
//   return $cat->term_id;
// }
