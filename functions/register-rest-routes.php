<?php
require_once(ABSPATH . 'wp-admin/includes/user.php');

class SOT_ROUTE extends WP_REST_Controller {

  // Endpoints
  public function register_routes() {
    $namespace = 'sot/v1';
    $base = 'logs';

    // Get All Ore Submissions
    register_rest_route( $namespace, '/' . $base,
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array( $this, 'get_all_logs')
      )
    );

    // Get single submission
    register_rest_route( $namespace, '/' . $base . '/(?P<id>\d+)',
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array( $this, 'get_single_log'),
        // 'permission_callback' => array( $this, 'is_admin' )
      )
    );

    // Create Ore Log
    register_rest_route( $namespace, '/' . $base . '/submit',
      array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => array( $this, 'submit_ore_log'),
        'permission_callback' => array( $this, 'validate_origin' ),
        'args' => array(
          'log_title' => array(
            'required' => true,
            'description' => 'Log Title'
          ),
          'log_description' => array(
            'required' => true,
            'description' => 'Log Description'
          ),
          'log_data' => array(
            'required' => true,
            'description' => 'Log Data'
          )
        )
      )
    );
  }
  // Endpoints

  // Auth
  public function validate_origin( WP_REST_Request $request ) {
    $headers = $request->get_headers();
    $origin = $headers['origin'][0];
    if ($origin === site_url()) {
      return true;
    }
    return false;
  }

  public function can_edit($request) {
    if ( current_user_can( 'administrator' ) ) {
      return true;
    }

    if ( current_user_can( 'partner' ) && wp_get_current_user()->ID === get_the_author_meta($request->get_param('id') ) ) {
      return true;
    }

    return new WP_Error( 'NOT_AUTHORIZED', 'Not logged in' );
  }

  public function is_admin() {
    return current_user_can('administrator');
  }

  public function is_member() {
    return current_user_can('member');
  }

  public function is_own_post($post_id) {
    if (!is_user_logged_in()) {
      return false;
    }
    $current_user_id = wp_get_current_user()->ID;
    $post_author_id = intval(get_post($post_id)->post_author);
    return $current_user_id === $post_author_id;
  }
  // Auth

  public function get_all_logs() {
    $args = array (
      'post_type' => array( 'ore_log' ),
      'posts_per_page' => -1,
      'order' => 'ASC',
      'orderby' => 'title',
      'post_status' => 'publish'
    );

    $query = new WP_Query( $args );
    $posts = $query->posts;
    $return_data = [];

    foreach($posts as $post) {
      array_push($return_data, array(
        'log_title' => $post->post_title,
        'log_description' => $post->post_content,
        'log_data' => get_post_meta( $post->ID, 'log_data')
      ));
    }

    return $return_data;
  }

  public function submit_ore_log( WP_REST_Request $request ) {
    $log_title = $request->get_param( 'log_title' );
    $log_description = $request->get_param( 'log_description' );
    $log_data = json_encode( $request->get_param( 'log_data' ) );
    $user_id = $request->get_param('id');

    // Create post object
    $ore_log = array(
      'post_title'    => $log_title,
      'post_content'  => $log_description,
      'post_status'   => 'pending',
      'post_type'     => 'ore_log',
      'post_author'   => $user_id
    );
    // Insert the post into the database & update meta
    $post_id = wp_insert_post( $ore_log );
    $result = update_post_meta( $post_id, 'log_data', $log_data );
    return $result;
  }

  public function get_single_submission( WP_REST_Request $request ) {
    $id = $request->get_param('id');
    $post = get_post($id);

    return $post;
  }
}
