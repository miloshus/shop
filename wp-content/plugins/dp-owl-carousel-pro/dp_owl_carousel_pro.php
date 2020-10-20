<?php

/** *
 * Plugin Name: DP Owl Carousel Pro
 * Plugin URI: http://www.diviplugins.com/divi/owl-carousel-pro-plugin/
 * Description: Adds two new modules to the Divi Builder. One module creates a carousel from posts and custom post types. The other module creates a carousel from images you add. The Pro version adds support for Custom Post Types, custom query, change thumbnail size, change number of images shown at once, open image in lightbox, and display custom fields.
 * Version: 2.1.2
 * Author: DiviPlugins
 * Author URI: http://www.diviplugins.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: dpocp-dp-owl-carousel-pro
 * Domain Path: /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DPOCP_NAME', 'dpocp-dp-owl-carousel-pro' );
define( 'DPOCP_VERSION', '2.1.2' );
define( 'DPOCP_DIR', plugin_dir_path( __FILE__ ) );
define( 'DPOCP_URL', plugin_dir_url( __FILE__ ) );
define( 'DPOCP_STORE_URL', 'https://diviplugins.com/' );
define( 'DPOCP_ITEM_NAME', 'Owl Carousel Pro' );
define( 'DPOCP_ITEM_ID', '4541' );

/**
 * The core plugin class that is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 */
require DPOCP_DIR . 'includes/class-dpocp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off the plugin from this point in the file does not affect the page life cycle.
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'run_dp_owl_carousel_pro' ) ) {
	function run_dp_owl_carousel_pro() {
		$plugin = new Dp_Owl_Carousel_Pro();
		$plugin->run();
	}

	run_dp_owl_carousel_pro();
}