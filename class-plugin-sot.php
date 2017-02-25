<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * Use PHPDoc tags if you wish to be able to document the code using a documentation
 * generator.
 *
 * @package StraylightOreTracker
 * @author  Christian Hapgood <christian.hapgood@gmail.com>
 * @license GPL-2.0+
 * @link    http://straylight.systems
 * @version 0.0.1
 */
class StraylightOreTracker {

	/**
	* Refers to a single instance of this class.
	*
	* @var    object
	*/
	protected static $instance = null;

	/**
	* Refers to the slug of the plugin screen.
	*
	* @var    string
	*/
	protected $plugin_screen_slug = null;

	// note that if you changet this you must also update the activate function...
	protected $BASE_URL = 'ore-tracker';

	/**
	* Creates or returns an instance of this class.
	*
	* @since     1.0.0
	* @return    StraylightOreTracker    A single instance of this class.
	*/
	public function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	* Initializes the plugin by setting localization, filters, and administration functions.
	*
	* @since    1.0.0
	*/
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		/*
		 * Add the options page and menu item.
		 * Uncomment the following line to enable the Settings Page for the plugin:
		 */
		//add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		/*
		 * Register admin styles and scripts
		 * If the Settings page has been activated using the above hook, the scripts and styles
		 * will only be loaded on the settings page. If not, they will be loaded for all
		 * admin pages.
		 *
		 * add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );
		 * add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		 */

		// Register site stylesheets and JavaScript
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

		/*
		 * TODO:
		 *
		 * Define the custom functionality for your plugin. The first parameter of the
		 * add_action/add_filter calls are the hooks into which your code should fire.
		 *
		 * The second parameter is the function name located within this class. See the stubs
		 * later in the file.
		 *
		 * For more information:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */

		add_action( 'init', array( $this, 'register_sot_post_types' ) );
		add_action( 'admin_init', array($this, 'redirect_non_admin_users') );

		add_action( 'init', array( $this, 'add_sot_rewrites') );
		add_action( 'wp_head', array( $this, 'add_sot_base_url' ) );
		add_action( 'template_include', array( $this, 'ore_tracker_template' ) );
		add_filter( 'body_class', array( $this, 'add_sot_body_class' ) );

		add_action( 'rest_api_init', array( $this, 'initialize_rest_routes') );
		// add_action( 'TODO', array( $this, 'action_method_name' ) );
		// add_filter( 'TODO', array( $this, 'filter_method_name' ) );

	}

	/**
	* Redirect non-admin users to home page
	*
	* This function is attached to the 'admin_init' action hook.
	*/
	public function redirect_non_admin_users() {
		if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
			wp_redirect( home_url() );
			exit;
		}
	}

		// include functions
	public function register_sot_post_types() {
		include 'functions/custom-post-types.php';
		include 'functions/register-rest-routes.php';
	}

	public function initialize_rest_routes() {
		$member_controller = new SOT_ROUTE();
		$member_controller->register_routes();
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	 public static function activate( $network_wide ) {
		// Adds member role
		$role = "member";
    $display_name = "Member";
    $capabilities = array(
      'read' => true
    );
    add_role( $role, $display_name, $capabilities );

		// Create Ore Tracker holding page
		$url = 'ore-tracker';
		if ( is_null( get_page_by_path($url) ) ) {
			$id = wp_insert_post(array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title' => 'Straylight Ore Tracker',
				'post_name' => $url
			));

			update_option('ore_tracker_id', $id);
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 * @since    1.0.0
	 */
	 public static function deactivate( $network_wide ) {
		remove_role( 'member' );
	}

	/**
	 * Loads the plugin text domain for translation
	 */
	public function load_plugin_textdomain() {

		$domain = 'straylight-ore-tracker-locale';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	}

	/**
	 * Registers and enqueues admin-specific styles.
	 *
	 * @since    1.0.0
	 */
	public function register_admin_styles() {

		/*
		 * Check if the plugin has registered a settings page
		 * and if it has, make sure only to enqueue the scripts on the relevant screens
		 */

		if ( isset( $this->plugin_screen_slug ) ) {

			/*
			 * Check if current screen is the admin page for this plugin
			 * Don't enqueue stylesheet or JavaScript if it's not
			 */

			// $screen = get_current_screen();
			// if ( $screen->id == $this->plugin_screen_slug ) {
			// 	wp_enqueue_style( 'sot-admin-styles', plugins_url( 'dist/css/admin.css', __FILE__ ), PLUGIN_NAME_VERSION );
			// }

		}

	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 *
	 * @since    1.0.0
	 */
	public function register_admin_scripts() {

		/*
		 * Check if the plugin has registered a settings page
		 * and if it has, make sure only to enqueue the scripts on the relevant screens
		 */

		if ( isset( $this->plugin_screen_slug ) ) {

			/*
			 * Check if current screen is the admin page for this plugin
			 * Don't enqueue stylesheet or JavaScript if it's not
			 */

			$screen = get_current_screen();
			if ( $screen->id == $this->plugin_screen_slug ) {
				wp_enqueue_script( 'sot-admin-script', plugins_url('dist/js/admin.min.js', __FILE__), array( 'jquery' ), PLUGIN_NAME_VERSION );
			}

		}

	}

	/**
	 * Registers and enqueues public-facing stylesheets.
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_styles() {
		wp_enqueue_style( 'sot-plugin-styles', plugins_url( 'dist/css/bundle.css', __FILE__ ), PLUGIN_NAME_VERSION );
	}

	/**
	 * Registers and enqueues public-facing JavaScript.
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_scripts() {
		wp_enqueue_script( 'sot-plugin-script', plugins_url( 'dist/js/all.min.js', __FILE__ ), array( 'jquery' ), PLUGIN_NAME_VERSION );
	}

	/**
	 * Registers the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */
		$this->plugin_screen_slug = add_plugins_page(
			__('Page Title', 'plugin-name-locale'),
			__('Menu Text', 'plugin-name-locale'),
			'read',
			'plugin-name',
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Renders the options page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once('views/admin.php');
	}

	/*
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action method here
	}

	/*
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since       1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter method here
	}

		public function add_sot_base_url() {
		$id = get_option('ore_tracker_id');
		if ( is_page( $id ) ) {
			echo "<base href=\"/" . $this->BASE_URL . "/\" />";
		}
	}

	public function add_sot_body_class($classes) {
		$id = get_option('ore_tracker_id');
		if ( is_page( $id ) ) {
			return array('page', 'ore-tracker');
		}

		return $classes;
	}

	public function ore_tracker_template( $template ) {
		$id = get_option('ore_tracker_id');
		if ( is_page( $id ) ) {
				//Check plugin directory next
				$p_template = plugin_dir_path( __FILE__ ) . 'templates/ore-tracker.php';

				if ( file_exists( $p_template ) ) {
					return $p_template;
				}
		}

		// fall back to original template
		return $template;
	}

	public function add_sot_rewrites() {
		$id = get_option('ore_tracker_id');
		$url = $this->BASE_URL;

		add_rewrite_rule("^${url}.*$", "index.php?page_id=${id}", 'top');
	}

}