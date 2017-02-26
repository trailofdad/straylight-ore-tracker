<?php

    $labels = array(
      'name'               => 'Ore Logs',
      'singular_name'      => 'Ore Log',
      'menu_name'          => 'Ore Logs',
      'name_admin_bar'     => 'Ore Log',
      'add_new'            => _x('Add New', 'ore log'),
      'add_new_item'       => 'Add New Ore Log',
      'new_item'           => 'New Ore Log',
      'edit_item'          => 'Edit Ore Log',
      'view_item'          => 'View Ore Log',
      'all_items'          => 'All Ore Logs',
      'search_items'       => 'Search Ore Logs',
      'parent_item_colon'  => 'Parent Ore Logs:',
      'not_found'          => 'No ore logs found.',
      'not_found_in_trash' => 'No ore logs found in Trash.'
    );

    $args = array(
      'labels'             => $labels,
      'description'        => 'Holds information on a members ore mined during an op',
      'exclude_from_search'=> true,
      'publicly_queryable' => false,
      'show_in_nav_menus'  => true,
      'show_ui'            => true, 
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'ore-log' ),
      'capability_type'    => 'post',
      'hierarchical'       => false,
      'supports'           => array( 'title' ),
      'taxonomies'		 		 =>	array('Log Type'),
      'delete_with_user'   => false,
      'show_in_rest'       => true,
      'menu_icon'          => 'dashicons-book-alt',
      'menu_position'      => 2
    );

    register_post_type( 'ore_log', $args );