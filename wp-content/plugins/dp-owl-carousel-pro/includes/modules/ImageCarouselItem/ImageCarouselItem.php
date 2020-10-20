<?php

class DPOCP_ImageCarouselItem extends ET_Builder_Module {

	public $slug = 'et_pb_dp_oc_custom_item';
	public $vb_support = 'on';
	protected $module_credits = array(
		'module_uri' => 'https://www.diviplugins.com/divi/owl-carousel-pro-plugin',
		'author'     => 'DiviPlugins',
		'author_uri' => 'https://www.diviplugins.com',
	);

	public function init() {
		$this->name                        = __( 'Image', DPOCP_NAME );
		$this->plural                      = __( 'Images', DPOCP_NAME );
		$this->slug                        = 'et_pb_dp_oc_custom_item';
		$this->type                        = 'child';
		$this->child_title_var             = 'admin_title';
		$this->advanced_setting_title_text = __( 'New Image', DPOCP_NAME );
		$this->settings_text               = __( 'Image Settings', DPOCP_NAME );
		$this->main_css_element            = '%%order_class%% ';
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'                 => false,
			'custom_margin_padding' => false,
			'max_width'             => false,
			'text'                  => false,
			'filters'               => false,
		);
	}

	public function get_fields() {
		$fields = array(
			'upload_image'     => array(
				'label'              => __( 'Image URL', DPOCP_NAME ),
				'type'               => 'upload',
				'option_category'    => 'configuration',
				'upload_button_text' => __( 'Upload an image', DPOCP_NAME ),
				'choose_text'        => __( 'Choose an Image', DPOCP_NAME ),
				'update_text'        => __( 'Set As Image', DPOCP_NAME ),
				'description'        => __( 'Upload your desired image, or type in the URL to the image you would like to display.', DPOCP_NAME ),
			),
			'show_in_lightbox' => array(
				'label'           => __( 'Open in Lightbox', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( "No", DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Here you can choose whether or not the image should open in Lightbox. Note: if you select to open the image in Lightbox, url options below will be ignored.', DPOCP_NAME ),
			),
			'use_original'     => array(
				'label'           => __( 'Use Original Image', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( "No", DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Load the original image instead of looking for image thumbnail. If images are small and do not have a thumbnail in the size selected, this option will load the full size of the image.', DPOCP_NAME ),
			),
			'url'              => array(
				'label'           => __( 'Link URL', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'show_in_lightbox' => 'off' ),
				'description'     => __( 'If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', DPOCP_NAME ),
			),
			'url_new_window'   => array(
				'label'           => __( 'Url Opens', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'In The Same Window', DPOCP_NAME ),
					'on'  => __( 'In The New Tab', DPOCP_NAME ),
				),
				'show_if'         => array( 'show_in_lightbox' => 'off' ),
				'description'     => __( 'Here you can choose whether or not your link opens in a new window', DPOCP_NAME ),
			),
			'image_title'      => array(
				'label'           => __( 'Image Title', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'description'     => __( 'Image title displays below image', DPOCP_NAME ),
			),
			'content'          => array(
				'label'           => __( 'Image Content', DPOCP_NAME ),
				'type'            => 'tiny_mce',
				'option_category' => 'configuration',
				'description'     => __( 'Image content displays below image title', DPOCP_NAME ),
			),
			'image_alt_text'   => array(
				'label'           => __( 'Image Alternative Text', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'description'     => __( 'This defines the HTML ALT text. A short description of your image can be placed here.', DPOCP_NAME ),
			),
			'image_title_text' => array(
				'label'           => __( 'Image Title Text', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'description'     => __( 'This defines the HTML Title text.', DPOCP_NAME ),
			),
			'admin_title'      => array(
				'label'           => __( 'Admin Label', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'description'     => __( 'This will change the label of the image in the builder for easy identification.', DPOCP_NAME ),
			),
		);

		return $fields;
	}

	public function render( $attrs, $content = null, $render_slug ) {
		/*
		 * Init values
		 */
		$props = $this->props;
		global $dpocp_image_parent_module;
		$image_size_width    = '';
		$selected_size       = $dpocp_image_parent_module['thumbnail_size'];
		$selected_size_width = explode( 'x', Dp_Owl_Carousel_Pro_Utils::get_custom_sizes()[ $selected_size ] )[0];
		$auto_width          = $dpocp_image_parent_module['auto_width'];
		$lazy_load           = $dpocp_image_parent_module['lazy_load'];
		$lightbox_gallery    = $dpocp_image_parent_module['lightbox_gallery'];
		$gallery_images      = $dpocp_image_parent_module['gallery_images'];
		$parent_class        = $dpocp_image_parent_module['parent_class'];
		$parent_hash         = $dpocp_image_parent_module['use_hash_thumbnail'];
		$parent_url_anchors  = $dpocp_image_parent_module['url_anchors'];
		/*
		 *
		 */
		if ( ! empty( $props['upload_image'] ) ) {
			$attachment_id           = Dp_Owl_Carousel_Pro_Utils::get_attachment_id( $props['upload_image'] );
			$this->props['image_id'] = $attachment_id;
			if ( $auto_width === 'on' && $attachment_id ) {
				$attachment_data = wp_get_attachment_metadata( $attachment_id );
				if ( $props['use_original'] === 'on' ) {
					if ( isset( $attachment_data['width'] ) ) {
						$image_size_width = 'style="width: ' . $attachment_data['width'] . 'px"';
					}
				} else {
					if ( isset( $attachment_data['sizes'][ $selected_size ] ) && isset( $attachment_data['sizes'][ $selected_size ]['width'] ) ) {
						$image_size_width = $attachment_data['sizes'][ $selected_size ]['width'];
					}
					if ( $image_size_width !== '' ) {
						$image_size_width = 'style="width: ' . $image_size_width . 'px"';
					} else {
						$image_size_width = 'style="width: ' . $selected_size_width . 'px"';
					}
				}
			}
		} else {
			$this->props['image_id'] = 'No Image';
			if ( $auto_width === 'on' ) {
				$image_size_width = 'style="width: ' . $selected_size_width . 'px"';
			}
		}
		$image_number = DPOCP_ImageCarousel::add_child_data( $this->props, $parent_class );
		/*
		 *
		 */
		ob_start();
		echo sprintf( '<div class="dp_oc_item" %1$s %2$s>', $image_size_width, ( $parent_hash === "on" && $parent_url_anchors === "on" ) ? sprintf( 'data-item="_%1$s" data-hash="%2$s"', $image_number, trim( $parent_class ) . "_" . $image_number ) : "" );
		if ( ! empty( $props['upload_image'] ) ) {
			if ( $props['use_original'] === 'on' ) {
				$image_src = $props['upload_image'];
			} else {
				$image_src = wp_get_attachment_image_url( $this->props['image_id'], $selected_size );
			}
			if ( $props['url_new_window'] === "on" ) {
				$target = "_blank";
			} else {
				$target = "";
			}
			if ( $props['show_in_lightbox'] === "on" ) {
				echo sprintf( '<a href="#" data-ref="%1$s" class="dp_ocp_lightbox_image" ><img class="dp_oc_image_thumb %7$s" %8$ssrc="%2$s" title="%6$s" alt="%3$s" data-lightbox-gallery="%4$s" data-gallery-image="%5$s" ></a>', $props['upload_image'], $image_src, $props['image_alt_text'], ( $lightbox_gallery === 'on' ) ? 'on' : 'off', $gallery_images ++, $props['image_title_text'], ( $lazy_load === 'on' ) ? 'owl-lazy' : '', ( $lazy_load === 'on' ) ? 'data-' : '' );
			} elseif ( ! empty( $props['url'] ) ) {
				echo sprintf( '<a href="%1$s" target="%2$s"><img class="dp_oc_image_thumb %6$s" %7$ssrc="%3$s" title="%4$s" alt="%5$s"></a>', $props['url'], $target, $image_src, $props['image_title_text'], $props['image_alt_text'], ( $lazy_load === 'on' ) ? 'owl-lazy' : '', ( $lazy_load === 'on' ) ? 'data-' : '' );
			} else {
				echo sprintf( '<img class="dp_oc_image_thumb %4$s" %5$ssrc="%1$s" title="%2$s" alt="%3$s">', $image_src, $props['image_title_text'], $props['image_alt_text'], ( $lazy_load === 'on' ) ? 'owl-lazy' : '', ( $lazy_load === 'on' ) ? 'data-' : '' );
			}
		}
		if ( ! empty( $props['image_title'] ) ) {
			echo sprintf( '<h2 class="dp_oc_image_title">%1$s</h2>', $props['image_title'] );
		}
		if ( ! empty( $props['content'] ) ) {
			echo sprintf( '<div class="dp_oc_image_content">%1$s</div>', $props['content'] );
		}
		echo '</div>';
		$output = ob_get_contents();
		ob_get_clean();

		return $output;
	}

}

new DPOCP_ImageCarouselItem;

