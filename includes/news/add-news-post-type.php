<?php

function wpdocs_kantbtrue_init() {
    $labels = array(
        'name'                  => __( 'News' ),
        'singular_name'         => __( 'New'),
        'menu_name'             => __( 'News'),
        'name_admin_bar'        => __( 'New'),
        'add_new'               => __( 'Add New', 'new' ),
        'add_new_item'          => __( 'Add New new', 'new' ),
        'new_item'              => __( 'New news', 'new' ),
        'edit_item'             => __( 'Edit new', 'new'),
        'view_item'             => __( 'View new', 'new' ),
        'all_items'             => __( 'All news', 'new' ),
        'search_items'          => __( 'Search news', 'new' ),
        'parent_item_colon'     => __( 'Parent news:', 'new' ),
        'not_found'             => __( 'No news found.', 'new' ),
       
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Add News',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'news' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 60,
        'supports'           => array( 'title', 'editor', 'author', 'comment' ),
        'taxonomies'         => array(),
        'show_in_rest'       => true
    );
     
    register_post_type( 'News', $args );


    $args = array(
        'label'         => "Categories",
        'public'        => true,
        'hierarchical'  => true,
        'query_var'     => true,
        'has_archive'   => true,
        'show_admin_column' => true,
        "show_in_nav_menus" => true,
        'show_ui'           => true,
        "show_in_rest"  => true,
		'rewrite'       => array( 'slug' => 'news-cat' ),
        
    );

    register_taxonomy('news_cat', 'news', $args);
}
add_action( 'init', 'wpdocs_kantbtrue_init' );