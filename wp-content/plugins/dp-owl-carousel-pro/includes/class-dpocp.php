<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.diviplugins.com
 * @since 1.5
 *
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @since 1.5
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/includes
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Owl_Carousel_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @since 1.5
	 * @access   protected
	 * @var      Dp_Owl_Carousel_Pro_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.5
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.5
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.5
	 */
	public function __construct() {
		if ( defined( 'DPOCP_VERSION' ) ) {
			$this->version = DPOCP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		if ( defined( 'DPOCP_NAME' ) ) {
			$this->plugin_name = DPOCP_NAME;
		} else {
			$this->plugin_name = 'dp-owl-carousel-pro';
		}
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dp_Owl_Carousel_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Dp_Owl_Carousel_Pro_i18n. Defines internationalization functionality.
	 * - Dp_Owl_Carousel_Pro_Admin. Defines all hooks for the admin area.
	 * - Dp_Owl_Carousel_Pro_Public. Defines all hooks for the public side of the site.
	 * - Dp_Owl_Carousel_Pro_Updater. Defines de automatic updates class provide by EDD.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 1.5
	 * @access   private
	 */
	private function load_dependencies() {
		require_once DPOCP_DIR . 'includes/class-dpocp-loader.php';
		require_once DPOCP_DIR . 'includes/class-dp-page.php';
		require_once DPOCP_DIR . 'includes/class-dpocp-i18n.php';
		require_once DPOCP_DIR . 'includes/class-dpocp-updater.php';
		require_once DPOCP_DIR . 'includes/class-dpocp-utils.php';
		require_once DPOCP_DIR . 'admin/class-dpocp-admin.php';
		require_once DPOCP_DIR . 'public/class-dpocp-public.php';
		$this->loader = new Dp_Owl_Carousel_Pro_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dp_Owl_Carousel_Pro_i18n class in order to set the domain and to register the hook with WordPress.
	 *
	 * @since 1.5
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Dp_Owl_Carousel_Pro_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 1.5
	 * @access   private
	 */
	private function define_admin_hooks() {
		$dp_page = new DiviPlugins_Menu_Page();
		$this->loader->add_action( 'admin_menu', $dp_page, 'add_dp_page' );
		$plugin_admin = new Dp_Owl_Carousel_Pro_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'add_plugin_row_meta', 10, 2 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		/*
		 * License activation hooks related
		 */
		$this->loader->add_action( 'admin_init', $plugin_admin, 'init_plugin_updater', 0 );
		$this->loader->add_action( 'diviplugins_page_add_license', $plugin_admin, 'license_html' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_license_option' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'activate_license' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'deactivate_license' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notice_license_result' );
		if ( get_option( 'dp_ocp_license_status' ) !== 'valid' ) {
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notice_license_activation' );
		}
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'dp-owl-carousel/dp-owl-carousel.php' ) ) {
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notice_error' );
		}
		if ( get_transient( 'ocp_need_to_clear_local_storage' ) ) {
			$this->loader->add_action( 'admin_head', $plugin_admin, 'remove_from_local_storage' );
			set_transient( 'ocp_need_to_clear_local_storage', false );
		}
		/*
		 *
		 */
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'register_img_size' );
		$this->loader->add_filter( 'image_size_names_choose', $plugin_admin, 'custom_size' );
		$this->loader->add_action( 'divi_extensions_init', $plugin_admin, 'initialize_extension' );
		/*
		 *
		 */
		$plugin_util = new Dp_Owl_Carousel_Pro_Utils();
		$this->loader->add_action( 'wp_ajax_dpocp_get_cpt_action', $plugin_util, 'ajax_get_cpt' );
		$this->loader->add_action( 'wp_ajax_dpocp_get_taxonomies_action', $plugin_util, 'ajax_get_taxonomies' );
		$this->loader->add_action( 'wp_ajax_dpocp_get_taxonomies_terms_action', $plugin_util, 'ajax_get_taxonomies_terms' );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.5
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.5
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.5
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Dp_Owl_Carousel_Pro_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_get_carousel_html_action', $plugin_public, 'get_carousel_items_data_ajax' );
		//$this->loader->add_action('wp_ajax_nopriv_get_carousel_html_action', $plugin_public, 'get_carousel_items_data_ajax');
		//$this->loader->add_action('wp_ajax_get_image_data_action', $plugin_public, 'get_image_data_ajax');
		//$this->loader->add_action('wp_ajax_nopriv_get_image_data_action', $plugin_public, 'get_image_data_ajax');
		//$this->loader->add_action('wp_ajax_get_image_sizes_action', $plugin_public, 'get_image_sizes_ajax');
		//$this->loader->add_action('wp_ajax_nopriv_get_image_data_action', $plugin_public, 'get_image_sizes_ajax');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.5
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Dp_Owl_Carousel_Pro_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.5
	 */
	public function get_loader() {
		return $this->loader;
	}

}
