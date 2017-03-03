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
      'supports'           => array( 'title', 'content', 'editor' ),
      'taxonomies'		 		 =>	array('Log Type'),
      'delete_with_user'   => false,
      'show_in_rest'       => true,
      'menu_icon'          => 'dashicons-book-alt',
      'menu_position'      => 2,
      'register_meta_box_cb' => 'add_ore_data_metabox'
    );

    register_post_type( 'ore_log', $args );

    function add_ore_data_metabox() {
      add_meta_box( 'ore_data_id', 'Ore Data', 'ore_metabox_template', 'ore_log', 'normal', 'high' );
    }

    function ore_metabox_template() {
      global $post;

      // Noncename needed to verify where the data originated
      echo '<input type="hidden" name="logmeta_noncename" id="logmeta_noncename" value="' .
      wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
      // Get the location data if its already been entered
      $log_data = get_post_meta($post->ID, 'log_data');
      // Echo out the field
      // TODO: add save function
      echo '<textarea name="" id="" cols="60" rows="10">' . json_encode($log_data) . '</textarea>';
    }
