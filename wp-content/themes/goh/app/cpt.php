<?php

/*
|--------------------------------------------------------------------------
| Create Custom Post Type
|--------------------------------------------------------------------------
|
| Here are the custom post types of the project:
| - Application
| - Raid
|
*/


add_action('init', 'create_post_type');
function create_post_type()
{
  /**
   * Post Type - Application
   */
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


  /**
   * Post Type - Raid
   */
  $labels = [
    'name'               => _x('Raid', 'post type general name'),
    'singular_name'      => _x('Raid', 'post type singular name'),
    'add_new'            => _x('Lägg till Raid', 'Raid'),
    'add_new_item'       => __('Lägg till ny Raid'),
    'edit_item'          => __('Redigera Raid'),
    'new_item'           => __('Nytt Raid'),
    'all_items'          => __('Alla Raid'),
    'view_item'          => __('Se Raid'),
    'search_items'       => __('Sök Raid'),
    'not_found'          => __('Inga Raid hittade'),
    'not_found_in_trash' => __('Inga Raid hittade i papperskorgen'),
    'parent_item_colon'  => '',
    'menu_name'          => 'Raid'
  ];
  $args = [
    'labels'        => $labels,
    'description'   => 'Raid',
    'public'        => true,
    'show_ui'       => true,
    'show_in_menu'  => true,
    'publicly_queryable' => true,
    'supports'      => ['title', 'editor'],
    'has_archive'   => false,
    'rewrite'       => ['slug' => 'raid', 'with_front' => false],
  ];
  register_post_type('raid', $args);
}
