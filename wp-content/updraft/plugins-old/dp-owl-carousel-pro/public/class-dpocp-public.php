<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.diviplugins.com
 * @since      1.5
 *
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/public
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Owl_Carousel_Pro_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since 1.5
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.5
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since 1.5
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.5
	 */
	public function enqueue_styles() {
		wp_register_style( 'dp-ocp-owl-carousel', DPOCP_URL . 'vendor/owl.carousel/assets/owl.carousel.min.css', false, DPOCP_VERSION );
		wp_register_style( 'dp-ocp-custom', DPOCP_URL . 'public/css/dpocp-public.min.css', array(), DPOCP_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since 1.5
	 */
	public function enqueue_scripts() {
		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() && ! wp_script_is( 'dp-owl-carousel-pro-admin-cpt-modal' ) ) {
			Dp_Owl_Carousel_Pro_Utils::enqueue_and_localize_cpt_modal_script();
		}
		wp_register_script( 'dp-ocp-owl-carousel', DPOCP_URL . 'vendor/owl.carousel/owl.carousel.min.js', array( 'jquery' ), DPOCP_VERSION, true );
		wp_register_script( 'dp-ocp-mousewheel', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js', array( 'jquery' ), DPOCP_VERSION, true );
	}

	public function get_carousel_items_data_ajax() {
		if ( isset( $_POST['module_props'] ) && isset( $_POST['module_class'] ) ) {
			echo json_encode( Dp_Owl_Carousel_Pro_Utils::get_carousel_items_data( $_POST['module_props'], $_POST['module_class'] ) );
		}
		wp_die();
	}

	public function get_image_data_ajax() {
		if ( isset( $_POST['module_props'] ) ) {
			echo json_encode( Dp_Owl_Carousel_Pro_Utils::get_image_data( $_POST['module_props'] ) );
		}
		wp_die();
	}

	public function get_image_sizes_ajax() {
		echo json_encode( Dp_Owl_Carousel_Pro_Utils::get_custom_sizes() );
		wp_die();
	}

}
