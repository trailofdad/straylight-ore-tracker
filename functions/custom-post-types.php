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
      echo '<input type="hidden" name="logmeta_nonce" id="logmeta_nonce" value="' .
      wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
      // Get the log data
      $log_data = get_post_meta($post->ID, 'log_data');
      // Echo out the field
      // TODO: add save function
      echo '<textarea name="log_data" id="log_data" cols="60" rows="10">' . $log_data[0]  . '</textarea>';
    }

    function save_ore_log_meta_box($post_id, $post, $update) {
      if (!isset($_POST["logmeta_nonce"]) || !wp_verify_nonce($_POST["logmeta_nonce"], plugin_basename(__FILE__)))
          return $post_id;

      if(!current_user_can("edit_post", $post_id))
          return $post_id;

      if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
          return $post_id;

      $slug = "ore_log";
      if($slug != $post->post_type)
          return $post_id;

      $meta_box_text_value = "";

      if(isset($_POST["log_data"]))
      {
        $meta_box_text_value = $_POST["log_data"];
      }
      update_post_meta( $post_id, "log_data", $meta_box_text_value );
    }

add_action("save_post", "save_ore_log_meta_box", 10, 3);
