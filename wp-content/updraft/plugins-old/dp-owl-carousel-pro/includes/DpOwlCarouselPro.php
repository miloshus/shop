<?php

class DPOCP_DpOwlCarouselPro extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'dpocp-dp-owl-carousel-pro';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'dp-owl-carousel-pro';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = DPOCP_VERSION;

	/**
	 * DPOCP_DpOwlCarouselPro constructor.
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function __construct( $name = 'dp-owl-carousel-pro', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );
		parent::__construct( $name, $args );
	}

	protected function _enqueue_bundles() {
		// Frontend Bundle
		$bundle_url = "{$this->plugin_dir_url}scripts/frontend-bundle.min.js";
		if ( et_core_is_fb_enabled() ) {
			wp_enqueue_script( "{$this->name}-frontend-bundle", $bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );
			// Builder Bundle
			$bundle_url = "{$this->plugin_dir_url}scripts/builder-bundle.min.js";
			wp_enqueue_script( "{$this->name}-builder-bundle", $bundle_url, $this->_bundle_dependencies['builder'], $this->version, true );
		} else {
			wp_register_script( "{$this->name}-frontend-bundle", $bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );
		}
	}

}

new DPOCP_DpOwlCarouselPro;
