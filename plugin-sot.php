<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package PluginName
 * @author  Your Name <email@example.com>
 * @license GPL-2.0+
 * @link    TODO
 *
 * @wordpress-plugin
 * Plugin Name: Straylight Ore Tracker
 * Plugin URI: http://straylight.systems
 * Description: An ore tracker for Straylight Systems
 * Version: 0.0.1
 * Author: Christian Hapgood
 * Author URI: https://github.com/trailofdad
 * Author Email: christian.hapgood@gmail.com
 * Text Domain: plugin-name-locale
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang/
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * The following constant is used to define a constant for this plugin to make it
 * easier to provide cache-busting functionality on loading stylesheets
 * and JavaScript.
 *
 * After you've defined these constants, do a find/replace on the constants
 * used throughout the rest of this file.
 */
if ( ! defined( 'STRAYLIGHT_ORE_TRACKER_VERSION' ) ) {

	define( 'STRAYLIGHT_ORE_TRACKER_VERSION', '0.0.1' );

}

require_once( plugin_dir_path( __FILE__ ) . 'class-plugin-sot.php' );

register_activation_hook( __FILE__, array( 'StraylightOreTracker', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'StraylightOreTracker', 'deactivate' ) );

StraylightOreTracker::get_instance();