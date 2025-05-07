<?php

if (!defined('ABSPATH')) {
    exit;
}

function reh_register_post_type_house() {
    $labels = array(
        'name'               => 'Houses',
        'singular_name'      => 'House',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New House',
        'edit_item'          => 'Edit House',
        'new_item'           => 'New House',
        'all_items'          => 'All Houses',
        'view_item'          => 'View House',
        'search_items'       => 'Search Houses',
        'not_found'          => 'No houses found',
        'not_found_in_trash' => 'No houses found in Trash',
        'menu_name'          => 'Houses',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'houses'),
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-admin-home',
        'show_in_rest'       => true,
    );

    register_post_type('house', $args);
}
add_action('init', 'reh_register_post_type_house');
