<?php
require_once(ABSPATH . 'wp-admin/includes/user.php');

class SOT_ROUTE extends WP_REST_Controller {

  // Endpoints
  public function register_routes() {
    $namespace = 'sot/v1';
    $base = 'logs';

    // middlewares
    // array($this, 'validate_nonce'), // validate the nonce
    // array($this, 'can_edit')

    // Get All Ore Submissions
    register_rest_route( $namespace, '/' . $base,
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array( $this, 'get_all_logs'),
        // 'permission_callback' => array( $this, 'is_admin' )
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
  }
  // Endpoints

  // Auth
  public function validate_nonce($request) {
    $nonce = isset($_SERVER['HTTP_X_WP_NONCE']) ? $_SERVER['HTTP_X_WP_NONCE'] : '';

    $nonce = wp_verify_nonce($nonce, 'wp_rest');

    return $nonce || new WP_Error( 'LOGIN', 'Not logged in' );
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

    return $posts;
  }

  public function get_single_submission( WP_REST_Request $request ) {
    $id = $request->get_param('id');
    $post = get_post($id);

    return $post;
  }
}
