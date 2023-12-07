<?php

/*
 * Please follow below structure to define Custom Post Types
 */

/*
 * SAMPLE MINIMAL OBJECT
 */

$config['cpt'] = [
  'meal' => []
];

/*
 * SAMPLE FULL OBJECT
 */

$config['cpt'] = [
  'cpost' => [
    'singular' => 'CPost',
    'plural' => 'CPosts',
    'description' => 'CPost CPT',
    'menu_icon' => 'dashicons-carrot',
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'query_var' => true,
    'rewrite' => ['slug' => 'cpost', 'with_front' => true],
    'capability_type' => 'post',
    'has_archive' => false,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => ['title', 'editor', 'thumbnail'],
    'labels' => [
      'name' => 'Name',
      'singular_name' => 'Singular Name',
      'menu_name' => 'Name',
      'name_admin_bar' => 'Name',
      'add_new' => 'Add CPost',
    ],
    'taxonomies' => [
      'cpost_categories' => [
        'hierarchical' => false,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => ['slug' => 'cpost_categories'],
        'labels' => [
          'search_items' =>  'Search Cpost Categories',
          'popular_items' =>  'Search Cpost Categories',
          'all_items' =>  'Search Cpost Categories',
          'parent_item' => null,
          'parent_item_colon' => null,
          'edit_item' =>   'Edit Cpost Category',
          'update_item' =>   'Update Cpost Category',
          'add_new_item' =>   'Add New Cpost Category',
          'new_item_name' =>   'New Cpost Category',
          'separate_items_with_commas' =>   'Separate Cpost Categories with commas',
          'add_or_remove_items' =>   'Add or remove Cpost Categories',
          'choose_from_most_used' =>   'Choose from the most used Cpost Categories',
          'menu_name' =>   'Cpost Categories',
        ]
      ]
    ]
  ]
];

