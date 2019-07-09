<?php

/*
|--------------------------------------------------------------------------
| Create Custom Post Type
|--------------------------------------------------------------------------
|
| Custom function to create custom post type
|
*/


/**
 * Create Custom Post Types
 *
 * @return void
 */
add_action('init', 'create_post_type');
function create_post_type()
{
  // Post Type - Application
  $labels = [
    'name'               => _x('Ansökan', 'post type general name'),
    'singular_name'      => _x('Ansökan', 'post type singular name'),
    'add_new'            => _x('Lägg till Ansökan', 'Ansökan'),
    'add_new_item'       => __('Lägg till ny Ansökan'),
    'edit_item'          => __('Redigera Ansökan'),
    'new_item'           => __('Nytt Ansökan'),
    'all_items'          => __('Alla Ansökan'),
    'view_item'          => __('Se Ansökan'),
    'search_items'       => __('Sök Ansökan'),
    'not_found'          => __('Inga Ansökan hittade'),
    'not_found_in_trash' => __('Inga Ansökan hittade i papperskorgen'),
    'parent_item_colon'  => '',
    'menu_name'          => 'Ansökan'
  ];
  $args = [
    'labels'        => $labels,
    'description'   => 'Ansökan',
    'public'        => false,
    'show_ui'       => true,
    'show_in_menu'  => true,
    'publicly_queryable' => false,
    'supports'      => ['title', 'editor'],
    'menu_icon'     => 'dashicons-email-alt',
    'has_archive'   => false,
    'rewrite'       => ['slug' => 'application', 'with_front' => false],
  ];
  register_post_type('application', $args);
}
