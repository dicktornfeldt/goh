<?php

/**
 * Clean up wordpres <head>
 */
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
  $manifest = json_decode(file_get_contents(dirname(dirname(__FILE__)).'/build/assets.json', true));
  $main = $manifest->main;
  wp_enqueue_style('theme-css', get_template_directory_uri() . "/build/" . $main->css, false, null);
  wp_enqueue_script('theme-js', get_template_directory_uri() . "/build/" . $main->js, '', '', true);
}, 100);


/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
  /**
   * Enable features from Soil when plugin is activated
   * @link https://roots.io/plugins/soil/
   */
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-relative-urls');
  /**
   * Register navigation menus
   * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
   */
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'mini')
  ]);
  /**
   * Enable post thumbnails
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support('post-thumbnails');
  /**
   * Enable HTML5 markup support
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
   */
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
  /**
   * Enable selective refresh for widgets in customizer
   * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
   */
  // add_theme_support('customize-selective-refresh-widgets');
}, 20);




/**
 * Add page slug to body class, love this - Credit: Starkers Wordpress Theme
 */
add_filter('body_class', 'add_slug_to_body_class');
function add_slug_to_body_class($classes)
{
  global $post;
  if (is_home()) {
    $key = array_search('blog', $classes);
    if ($key > -1) {
      unset($classes[$key]);
    }
  } elseif (is_page()) {
    $classes[] = sanitize_html_class($post->post_name);
  } elseif (is_singular()) {
    $classes[] = sanitize_html_class($post->post_name);
  }
  return $classes;
}


/**
 * Disabled Gutenberg
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);
add_action('wp_print_styles', 'wps_deregister_styles', 100);
function wps_deregister_styles()
{
  wp_dequeue_style('wp-block-library');
}


/**
 * Remove default image sizes
 */
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');
function remove_default_image_sizes($sizes)
{
  /* Default WordPress */
  unset($sizes['medium']);          // Remove Medium resolution (300 x 300 max height 300px)
  unset($sizes['medium_large']);    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
  unset($sizes['large']);           // Remove Large resolution (1024 x 1024 max height 1024px)
  return $sizes;
}


/**
 * Add content to Timber $context
 */
add_filter('timber/context', 'add_to_context');
function add_to_context($context)
{
  $context['primary_navigation'] = new Timber\Menu('primary_navigation');
  $context['post']               = new Timber\Post();

  return $context;
}


/**
 * Remove admin bar
 */
add_filter('show_admin_bar', '__return_false');


/**
 * Style login page
 */
add_action('login_enqueue_scripts', 'my_login_stylesheet');
function my_login_stylesheet()
{
  $manifest = json_decode(file_get_contents(dirname(dirname(__FILE__)).'/build/assets.json', true));
  $main = $manifest->main;
  wp_enqueue_style('custom-login', get_template_directory_uri() . "/build/" . $main->css, false, null);
}
