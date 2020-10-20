<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it is ready for translation.
 *
 * @since 1.5
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/includes
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Owl_Carousel_Pro_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.5
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( DPOCP_NAME, false, 'dp-owl-carousel-pro/languages/' );
	}

}
