<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.diviplugins.com
 * @since      1.5
 *
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dp_Owl_Carousel_Pro
 * @subpackage Dp_Owl_Carousel_Pro/admin
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Owl_Carousel_Pro_Admin {

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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since 1.5
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @param $hook
	 *
	 * @since 1.5
	 */
	public function enqueue_styles( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'divi_page_et_theme_builder' ) ) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dpocp-admin.min.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param $hook
	 *
	 * @since 1.5
	 */
	public function enqueue_scripts( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'divi_page_et_theme_builder' ) ) ) {
			Dp_Owl_Carousel_Pro_Utils::enqueue_and_localize_cpt_modal_script();
		}
	}

	public function remove_from_local_storage() {
		echo '<script>for (var prop in localStorage) {localStorage.removeItem(prop);}</script>';
	}

	public function register_img_size() {
		add_image_size( 'dp-ocp-square-thumb', 400, 400, true );
	}

	public function custom_size( $sizes ) {
		return array_merge( $sizes, array( 'dp-ocp-square-thumb' => __( 'Owl Carousel Square', DPOCP_NAME ), ) );
	}

	public function initialize_extension() {
		require_once DPOCP_DIR . 'includes/DpOwlCarouselPro.php';
	}

	public function add_plugin_row_meta( $links, $file ) {
		if ( $file === "dp-owl-carousel-pro/dp_owl_carousel_pro.php" ) {
			$links['license'] = sprintf( '<a href="%s"> %s </a>', admin_url( 'plugins.php?page=dp_divi_plugins_menu' ), __( 'License', DPOCP_NAME ) );
			$links['support'] = sprintf( '<a href="%s" target="_blank"> %s </a>', 'https://diviplugins.com/documentation/owl-carousel-pro/', __( 'Get support', DPOCP_NAME ) );
		}

		return $links;
	}

	public function init_plugin_updater() {
		$license_key = trim( get_option( 'dp_ocp_license_key' ) );
		new Dp_Owl_Carousel_Pro_Updater( DPOCP_STORE_URL, DPOCP_DIR . 'dp_owl_carousel_pro.php', array(
				'version'   => DPOCP_VERSION,
				'license'   => $license_key,
				'item_id'   => DPOCP_ITEM_ID,
				'item_name' => DPOCP_ITEM_NAME,
				'author'    => 'Divi Plugins',
				'beta'      => false
			)
		);
	}

	public function license_html() {
		$license = get_option( 'dp_ocp_license_key' );
		$status  = get_option( 'dp_ocp_license_status' );
		echo sprintf( '<div class="dp-license-block"><h2>%1$s</h2>', __( 'Owl Carousel Pro License' ) );
		echo '<form method="post" action="options.php">';
		settings_fields( 'dp_ocp_license' );
		echo sprintf( '<table class="form-table"><tbody><tr><th scope="row">%1$s</th>', __( 'License Key', DPOCP_ITEM_NAME ) );
		echo sprintf( '<td><input id="dp_ocp_license_key" name="dp_ocp_license_key" type="text" class="regular-text" value="%1$s" placeholder="%2$s"/><label class="description" for="dp_ocp_license_key"></label></td></tr>', esc_attr__( $license ), __( ' Enter your license key', DPOCP_ITEM_NAME ) );
		echo sprintf( '<tr><th scope="row">%1$s</th><td>', __( 'License Status', DPOCP_ITEM_NAME ) );
		if ( $status == 'valid' ) {
			echo sprintf( '<span class="active">%1$s</span>', __( 'Active', DPOCP_ITEM_NAME ) );
			wp_nonce_field( 'dp_ocp_license_nonce', 'dp_ocp_license_nonce' );
			echo sprintf( ' <input type="submit" class="button-secondary" name="dp_ocp_license_deactivate" value="%1$s"/>', __( 'Deactivate License', DPOCP_ITEM_NAME ) );
		} else {
			echo sprintf( '<span class="inactive">%1$s</span>', __( 'Inactive', DPOCP_ITEM_NAME ) );
			wp_nonce_field( 'dp_ocp_license_nonce', 'dp_ocp_license_nonce' );
			echo sprintf( ' <input type="submit" class="button-secondary" name="dp_ocp_license_activate" value="%1$s"/>', __( 'Activate License', DPOCP_ITEM_NAME ) );
		}
		echo '</td></tr>';
		echo '</tbody></table>';
		echo '</form></div>';
	}

	public function register_license_option() {
		register_setting( 'dp_ocp_license', 'dp_ocp_license_key', array(
			$this,
			'sanitize_license'
		) );
	}

	public function sanitize_license( $new ) {
		$old = get_option( 'dp_ocp_license_key' );
		if ( $old && $old != $new ) {
			delete_option( 'dp_ocp_license_status' );
		}

		return $new;
	}

	public function activate_license() {
		if ( isset( $_POST['dp_ocp_license_activate'] ) ) {
			if ( ! check_admin_referer( 'dp_ocp_license_nonce', 'dp_ocp_license_nonce' ) ) {
				return;
			}
			if ( $_POST['dp_ocp_license_key'] !== get_option( 'dp_ocp_license_key' ) ) {
				update_option( 'dp_ocp_license_key', $_POST['dp_ocp_license_key'] );
				$license = trim( $_POST['dp_ocp_license_key'] );
			} else {
				$license = trim( get_option( 'dp_ocp_license_key' ) );
			}
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_name'  => urlencode( DPOCP_ITEM_NAME ),
				'url'        => home_url()
			);
			$response   = wp_remote_post( DPOCP_STORE_URL, array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params
			) );
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred on the license server, please try again.', DPOCP_NAME );
				}
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );
				if ( false === $license_data->success ) {
					switch ( $license_data->error ) {
						case 'expired' :
							$message = sprintf(
								__( 'Your license key expired on %s.', DPOCP_NAME ), date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;
						case 'revoked' :
							$message = __( 'Your license key has been disabled.', DPOCP_NAME );
							break;
						case 'missing' :
							$message = __( 'Invalid license.', DPOCP_NAME );
							break;
						case 'invalid' :
						case 'site_inactive' :
							$message = __( 'Your license is not active for this URL.', DPOCP_NAME );
							break;
						case 'item_name_mismatch' :
							$message = sprintf( __( 'This appears to be an invalid license key for %s.', DPOCP_NAME ), DPOCP_ITEM_NAME );
							break;
						case 'no_activations_left':
							$message = __( 'Your license key has reached its activation limit.', DPOCP_NAME );
							break;
						default :
							$message = __( 'An error occurred with the license data, please try again.', DPOCP_NAME );
							break;
					}
				}
			}
			if ( ! empty( $message ) ) {
				$base_url = admin_url( 'plugins.php?page=dp_divi_plugins_menu&product=DPOCP' );
				$redirect = add_query_arg( array(
					'sl_activation' => 'false',
					'message'       => urlencode( $message )
				), $base_url );
				wp_redirect( $redirect );
				exit();
			}
			update_option( 'dp_ocp_license_status', $license_data->license );
			wp_redirect( admin_url( 'plugins.php?page=dp_divi_plugins_menu&product=DPOCP&sl_activation=true&message=OK' ) );
			exit();
		}
	}

	public function deactivate_license() {
		if ( isset( $_POST['dp_ocp_license_deactivate'] ) ) {
			if ( ! check_admin_referer( 'dp_ocp_license_nonce', 'dp_ocp_license_nonce' ) ) {
				return;
			}
			$license    = trim( get_option( 'dp_ocp_license_key' ) );
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_name'  => urlencode( DPOCP_ITEM_NAME ),
				'url'        => home_url()
			);
			$response   = wp_remote_post( DPOCP_STORE_URL, array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params
			) );
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.' );
				}
				$base_url = admin_url( 'plugins.php?page=dp_divi_plugins_menu$&product=DPOCP' );
				$redirect = add_query_arg( array(
					'sl_activation' => 'false',
					'message'       => urlencode( $message )
				), $base_url );
				wp_redirect( $redirect );
				exit();
			}
			delete_option( 'dp_ocp_license_status' );
			wp_redirect( admin_url( 'plugins.php?page=dp_divi_plugins_menu' ) );
			exit();
		}
	}

	public function admin_notice_license_result() {
		if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) && $_GET['page'] === 'dp_divi_plugins_menu' && $_GET['product'] === 'DPOCP' ) {
			if ( $_GET['sl_activation'] === 'false' ) {
				$message = urldecode( $_GET['message'] );
				echo sprintf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
			} else {
				echo sprintf( '<div class="notice notice-success is-dismissible"><p>%1$s</p></div>', __( 'Thank you for purchasing and activating DP Owl Carousel Pro.', DPOCP_NAME ) );
			}
		}
	}

	public function admin_notice_license_activation() {
		echo sprintf( '<div class="notice notice-info is-dismissible"><p>%1$s <a href="plugins.php?page=dp_divi_plugins_menu">%2$s</a></p></div>', __( 'Please activate your Owl Carousel Pro license to receive support and automatic updates.', DPOCP_NAME ), __( 'Activation Page', DPOCP_NAME ) );
	}

	public function admin_notice_error() {
		echo sprintf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', __( 'We noticed that you have DP Owl Carousel Free version activated. We just deactivated it for you. These plugins cannot be activated at the same time.', DPOCP_NAME ) );
		deactivate_plugins( 'dp-owl-carousel/dp-owl-carousel.php' );
	}

}
