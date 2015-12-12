<?php

// Register Custom Post Type
// If you need any help doing this, just go on https://generatewp.com/post-type/
function custom_post_type() {

    $labels = array(
        'name'                => _x( 'Post Types', 'Post Type General Name', 'genesis-foundation-child-theme' ),
        'singular_name'       => _x( 'Post Type', 'Post Type Singular Name', 'genesis-foundation-child-theme' ),
        'menu_name'           => __( 'Post Type', 'genesis-foundation-child-theme' ),
        'name_admin_bar'      => __( 'Post Type', 'genesis-foundation-child-theme' ),
        'parent_item_colon'   => __( 'Parent Item:', 'genesis-foundation-child-theme' ),
        'all_items'           => __( 'All Items', 'genesis-foundation-child-theme' ),
        'add_new_item'        => __( 'Add New Item', 'genesis-foundation-child-theme' ),
        'add_new'             => __( 'Add New', 'genesis-foundation-child-theme' ),
        'new_item'            => __( 'New Item', 'genesis-foundation-child-theme' ),
        'edit_item'           => __( 'Edit Item', 'genesis-foundation-child-theme' ),
        'update_item'         => __( 'Update Item', 'genesis-foundation-child-theme' ),
        'view_item'           => __( 'View Item', 'genesis-foundation-child-theme' ),
        'search_items'        => __( 'Search Item', 'genesis-foundation-child-theme' ),
        'not_found'           => __( 'Not found', 'genesis-foundation-child-theme' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'genesis-foundation-child-theme' ),
    );
    $args = array(
        'label'               => __( 'Post Type', 'genesis-foundation-child-theme' ),
        'description'         => __( 'Post Type Description', 'genesis-foundation-child-theme' ),
        'labels'              => $labels,
        'supports'            => array( ),
        'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,          
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'post_type', $args );

}
add_action( 'init', 'custom_post_type', 0 );
