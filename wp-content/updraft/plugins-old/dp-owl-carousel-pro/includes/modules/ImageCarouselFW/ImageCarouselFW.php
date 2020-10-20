<?php

class DPOCP_ImageCarouselFW extends ET_Builder_Module {

	public static $images_ids = array();
	public $slug = 'et_pb_dp_oc_custom_fw';
	public $vb_support = 'on';
	protected $module_credits = array(
		'module_uri' => 'https://www.diviplugins.com/divi/owl-carousel-pro-plugin',
		'author'     => 'DiviPlugins',
		'author_uri' => 'https://www.diviplugins.com',
	);

	public static function add_child_data( $img_data, $parent_class ) {
		if ( $img_data['image_id'] !== 'No Image' ) {
			self::$images_ids[ $parent_class ][] = $img_data['image_id'];
			$img_id                              = count( self::$images_ids[ $parent_class ] ) - 1;

			return $img_id;
		} else {
			return '';
		}
	}

	public function init() {
		$this->fullwidth        = true;
		$this->name             = esc_html__( 'DP Owl Image Carousel', DPOCP_NAME );
		$this->child_slug       = 'et_pb_dp_oc_custom_fw_item';
		$this->child_item_text  = __( 'Image', DPOCP_NAME );
		$this->main_css_element = '%%order_class%%';
		$this->image_sizes      = Dp_Owl_Carousel_Pro_Utils::get_custom_sizes();
		$this->fields_defaults  = array(
			'number_thumb_last_edited' => array(
				'on|desktop',
				'add_default_setting'
			),
			'number_thumb_tablet'      => array( '3', 'add_default_setting' ),
			'number_thumb_phone'       => array( '1', 'add_default_setting' ),
		);
	}

	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'elements' => esc_html__( 'Carousel Options', DPOCP_NAME ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'arrows'        => array(
						'title'    => esc_html__( 'Arrow', DPOCP_NAME ),
						'priority' => 94
					),
					'controls'      => array(
						'title'    => esc_html__( 'Controls', DPOCP_NAME ),
						'priority' => 95
					),
					'thumbnail'     => array(
						'title'    => esc_html__( 'Thumbnails', DPOCP_NAME ),
						'priority' => 97
					),
					'thumbnail_nav' => array(
						'title'    => esc_html__( 'Thumbnails Navigation', DPOCP_NAME ),
						'priority' => 98
					),
					'onclick'       => array(
						'title'    => esc_html__( 'Click Action', DPOCP_NAME ),
						'priority' => 99
					),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'                 => array(
				'image_title'   => array(
					'label'       => __( 'Image Title', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_oc_image_title",
					),
					"line_height" => array( "default" => "1.7em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'image_content' => array(
					'label'       => __( 'Image Content', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_oc_image_content",
					),
					"line_height" => array( "default" => "1.7em", ),
					"font_size"   => array( "default" => "14px", ),
				),
			),
			'custom_margin_padding' => array(),
			'max_width'             => array(),
			'border'                => array(),
			'filters'               => false,
		);
	}

	public function get_custom_css_fields_config() {
		return array(
			'ocp_item'               => array(
				'label'    => __( 'Carousel Items Container', DPOCP_NAME ),
				'selector' => '.dp_oc_item',
			),
			'ocp_arrow_prev'         => array(
				'label'    => __( 'Previous Arrow', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-nav .owl-prev::before',
			),
			'ocp_arrow_next'         => array(
				'label'    => __( 'Next Arrow', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-nav .owl-next::before',
			),
			'ocp_control'            => array(
				'label'    => __( 'Controls', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-dots .owl-dot',
			),
			'ocp_control_active'     => array(
				'label'    => __( 'Active Control', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-dots .owl-dot.active',
			),
			'ocp_item_image'         => array(
				'label'    => __( 'Image', DPOCP_NAME ),
				'selector' => 'img.dp_oc_image_thumb',
			),
			'ocp_item_image_title'   => array(
				'label'    => __( 'Image Title', DPOCP_NAME ),
				'selector' => '.dp_oc_image_title',
			),
			'ocp_item_image_content' => array(
				'label'    => __( 'Image Content', DPOCP_NAME ),
				'selector' => '.dp_oc_image_content',
			),
			'ocp_hash_container'     => array(
				'label'    => __( 'Navigation Thumbnail Container', DPOCP_NAME ),
				'selector' => '.dp_ocp_hash_container',
			),
			'ocp_hash_image'         => array(
				'label'    => __( 'Navigation Thumbnail Images', DPOCP_NAME ),
				'selector' => '.dp_ocp_hash_image',
			),
		);
	}

	public function get_fields() {
		$fields = array(
			/*
			 * Carousel
			 */
			'show_arrow'               => array(
				'label'           => __( 'Show Arrows', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'This setting allows you to turn the navigation arrows on or off. Arrows will only display if the number of available posts exceeds the number of thumbnails set to display per slide.', DPOCP_NAME ),
			),
			'items_per_slide'          => array(
				'label'           => __( 'Items Per Slide Action', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '1',
				'show_if'         => array( 'show_arrow' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Number of posts to slide left or right when clicking the arrows.', DPOCP_NAME ),
			),
			'show_control'             => array(
				'label'           => __( 'Show Controls', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn navigation controls on or off. Controls will only display if the number of available posts exceeds the number of thumbnails set to display.', DPOCP_NAME ),
			),
			'items_per_dot'            => array(
				'label'           => __( 'Items Per Control Action', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '3',
				'show_if'         => array( 'show_control' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Number of posts to slide left or right when clicking the control dots. Disabled if Center option is turned on.', DPOCP_NAME ),
			),
			'use_hash_thumbnail'       => array(
				'label'           => __( 'Use Navigation Thumbnail Images', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array( 'show_control' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Use navigation thumbnails images instead of controls.', DPOCP_NAME ),
			),
			'url_anchors'              => array(
				'label'           => __( 'URL Anchors', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array(
					'show_control'       => 'on',
					'use_hash_thumbnail' => 'on'
				),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn this option on if you want to link to a specific carousel image using an URL anchor.', DPOCP_NAME ),
			),
			'behavior'                 => array(
				'label'           => __( 'Carousel Behavior', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'loop'   => __( 'Loop', DPOCP_NAME ),
					'rewind' => __( 'Rewind', DPOCP_NAME ),
					'linear' => __( 'Linear', DPOCP_NAME ),
				),
				'default'         => 'loop',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Choose whether carousel should advance in an infinite loop, jump to first item when it reaches the end, or stop when it reaches the end.', DPOCP_NAME ),
			),
			'direction'                => array(
				'label'           => __( 'Carousel Direction', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'rtl' => __( 'Right to left', DPOCP_NAME ),
					'ltr' => __( 'Left to right', DPOCP_NAME ),
				),
				'default'         => 'rtl',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Choose which direction the carousel should advance.', DPOCP_NAME ),
			),
			'center'                   => array(
				'label'           => __( 'Center', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'First carousel item will always start in the center of the carousel. This option must be turned on to center the clicked image in the carousel when using Navigation Thumbnails.', DPOCP_NAME ),
			),
			'auto_width'               => array(
				'label'           => __( 'Auto Width Images', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn this option on if you want to display images in the size set in the Thumbnail Size option in the Design tab. Leave this option off if you want images to display evenly and adhere to Thumbnails Per Slide option in the Design tab.', DPOCP_NAME ),
			),
			'lazy_load'                => array(
				'label'           => __( 'Lazy Load', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn this option on if you want images to load on demand. This option may not be compatible with some caching and optimizing plugins and should be turned off if you experience any display issues with the carousel.', DPOCP_NAME ),
			),
			'use_mousewheel'           => array(
				'label'           => __( 'Use Mousewheel', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Activate carousel navigation using the mouse wheel.', DPOCP_NAME ),
			),
			'mousewheel_delay'         => array(
				'label'           => __( 'Mousewheel Delay', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '160',
				'show_if'         => array( 'use_mousewheel' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements'
			),
			'mouse_drag'               => array(
				'label'           => __( 'Mouse Drag', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'touch_drag'               => array(
				'label'           => __( 'Touch Drag', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'pull_drag'                => array(
				'label'           => __( 'Pull Drag', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			/*
			 * Arrows
			 */
			'arrow_color'              => array(
				'label'           => __( 'Arrows color', DPOCP_NAME ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'custom_color'    => true,
				'show_if'         => array( 'show_arrow' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrows',
			),
			'arrow_size'               => array(
				'label'           => __( 'Arrows size', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'2em' => __( 'Small', DPOCP_NAME ),
					'4em' => __( 'Medium', DPOCP_NAME ),
					'6em' => __( 'Large', DPOCP_NAME ),
				),
				'default'         => '4em',
				'show_if'         => array( 'show_arrow' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrows',
			),
			/*
			 * Controls
			 */
			'control_color'            => array(
				'label'           => __( 'Control color', DPOCP_NAME ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'custom_color'    => true,
				'show_if'         => array( 'show_control' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'controls',
			),
			'control_size'             => array(
				'label'           => __( 'Control size', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'8px'  => __( 'Small', DPOCP_NAME ),
					'16px' => __( 'Medium', DPOCP_NAME ),
					'24px' => __( 'Large', DPOCP_NAME ),
				),
				'default'         => '16px',
				'show_if'         => array( 'show_control' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'controls',
			),
			/*
			 * Click
			 */
			'lightbox_gallery'         => array(
				'label'           => __( 'Use Lightbox Gallery', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'onclick',
				'description'     => __( 'Turn this option on if you want the lightbox to display all images from the carousel in a gallery. Leave this option off if you only want the clicked image to display in the lightbox.', DPOCP_NAME ),
			),
			/*
			 * Animation Fields
			 */
			'slide_auto'               => array(
				'label'           => __( 'Automatic Rotate', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( "No", DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'default'         => 'on',
				'description'     => __( 'If you would like the carousel to rotate automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', DPOCP_NAME ),
			),
			'slide_speed'              => array(
				'label'           => __( 'Automatic Rotate Speed (in ms)', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '5000',
				'show_if'         => array( 'slide_auto' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => __( 'Here you can designate how fast the carousel rotates between each slide, if \'Automatic Rotate\' option is enabled above. The higher the number the longer the pause between each rotation.', DPOCP_NAME ),
			),
			'animation_speed'          => array(
				'label'           => __( 'Auto Rotate Animation Speed (in ms)', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '500',
				'show_if'         => array( 'slide_auto' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => __( 'Here you can designate how long it takes for the carousel to complete a rotation. The higher the number the slower the animation.', DPOCP_NAME ),
			),
			'arrows_speed'             => array(
				'label'           => __( 'Arrow Animation Speed (in ms)', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '500',
				'show_if'         => array( 'show_arrow' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => __( 'Here you can designate how long it takes for the carousel to complete a rotation when the arrows are clicked. The higher the number the slower the animation.', DPOCP_NAME ),
			),
			'dots_speed'               => array(
				'label'           => __( 'Control Animation Speed (in ms)', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '500',
				'show_if'         => array( 'show_control' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => __( 'Here you can designate how long it takes for the carousel to complete a rotation when the control dots are clicked. The higher the number the slower the animation.', DPOCP_NAME ),
			),
			'slide_hover'              => array(
				'label'           => __( 'Pause on Hover', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( "No", DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array( 'slide_auto' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => __( 'Pause carousel rotation when user hovers over the slides', DPOCP_NAME ),
			),
			/*
			 * Thumbnail Fields
			 */
			'hash_thumbnail_align'     => array(
				'label'           => __( 'Navigation Thumbnail Alignment', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'dpoc-align-center' => __( 'Center', DPOCP_NAME ),
					'dpoc-align-right'  => __( 'Right', DPOCP_NAME ),
					'dpoc-align-left'   => __( 'Left', DPOCP_NAME ),
				),
				'default'         => 'dpoc-align-center',
				'show_if'         => array(
					'show_control'       => 'on',
					'use_hash_thumbnail' => 'on'
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thumbnail_nav',
				'description'     => __( 'Navigation thumbnails image alignment.', DPOCP_NAME ),
			),
			'hash_thumbnail_size'      => array(
				'label'           => __( 'Navigation Thumbnail Size', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => $this->image_sizes,
				'default'         => 'thumbnail',
				'show_if'         => array(
					'show_control'       => 'on',
					'use_hash_thumbnail' => 'on'
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thumbnail_nav',
				'description'     => __( 'Navigation thumbnails image source size. You can further adjust the image size using CSS in the Navigation Thumbnail Image box in the Advanced tab.', DPOCP_NAME ),
			),
			'thumbnail_size'           => array(
				'label'           => __( 'Thumbnail Size', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => $this->image_sizes,
				'default'         => 'et-pb-portfolio-image',
				'description'     => __( 'Change image size. <b>This option is currently not rendering in the live preview. You’ll need to view your changes on the front end.</b>', DPOCP_NAME ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thumbnail'
			),
			'number_thumb'             => array(
				'label'           => __( 'Thumbnails to Display', DPOCP_NAME ),
				'type'            => 'range',
				'mobile_options'  => true,
				'validate_unit'   => false,
				'default_unit'    => '',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '20',
					'step' => '1',
				),
				'default'         => '5',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thumbnail',
				'description'     => 'This setting determines how many carousel items will be initially displayed on the screen.'
			),
			'number_thumb_tablet'      => array(
				'type'        => 'skip',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'thumbnail'
			),
			'number_thumb_phone'       => array(
				'type'        => 'skip',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'thumbnail'
			),
			'number_thumb_last_edited' => array(
				'type'        => 'skip',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'thumbnail'
			),
			'item_margin'              => array(
				'label'           => __( 'Item Margin', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '8',
				'description'     => __( 'Define the margin for each item at the carousel. Leave blank for default ( 8 ) ', DPOCP_NAME ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thumbnail',
			),
			/*
			 * Background Fields
			 */
			'module_bg'                => array(
				'label'           => __( 'Items Background', DPOCP_NAME ),
				'type'            => 'color-alpha',
				'option_category' => 'layout',
				'custom_color'    => true,
				'tab_slug'        => 'general',
				'toggle_slug'     => 'background',
			),
			'background_layout'        => array(
				'label'           => __( 'Text Color', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'light' => __( 'Dark', DPOCP_NAME ),
					'dark'  => __( 'Light', DPOCP_NAME ),
				),
				'default'         => 'light',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'description'     => __( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', DPOCP_NAME ),
			),
		);

		return $fields;
	}

	public function before_render() {
		global $dpocp_image_parent_module;
		/*
		 * Enqueue styles and scripts
		 */
		wp_enqueue_style( 'dp-ocp-owl-carousel' );
		wp_enqueue_script( 'dp-ocp-owl-carousel' );
		wp_enqueue_script( 'dp-owl-carousel-pro-frontend-bundle' );
		if ( $this->props['use_mousewheel'] === 'on' ) {
			wp_enqueue_script( 'dp-ocp-mousewheel' );
		}
		$dpocp_image_parent_module                       = array();
		$dpocp_image_parent_module['thumbnail_size']     = $this->props['thumbnail_size'];
		$dpocp_image_parent_module['lazy_load']          = $this->props['lazy_load'];
		$dpocp_image_parent_module['auto_width']         = $this->props['auto_width'];
		$dpocp_image_parent_module['lightbox_gallery']   = $this->props['lightbox_gallery'];
		$dpocp_image_parent_module['parent_class']       = ET_Builder_Element::add_module_order_class( $this->props['module_class'], $this->slug );
		$dpocp_image_parent_module['gallery_images']     = 0;
		$dpocp_image_parent_module['use_hash_thumbnail'] = $this->props['use_hash_thumbnail'];
		$dpocp_image_parent_module['url_anchors']        = $this->props['url_anchors'];
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$props           = $this->props;
		$props['the_ID'] = get_queried_object_id();
		/*
		 * Localize owl carousel initialization options from filter
		 */
		$module_order = trim( ET_Builder_Element::add_module_order_class( '', $render_slug ) );
		wp_localize_script( "dp-owl-carousel-pro-frontend-bundle", $module_order, array(
			'ocp_init' => apply_filters( 'dp_ocp_owl_init', array(), $props )
		) );
		/*
		 * Init values
		 */
		if ( $props['use_hash_thumbnail'] === 'on' ) {
			$props['show_control'] = 'off';
		}
		/*
		 * Add class names
		 */
		$module_class = ET_Builder_Element::add_module_order_class( $props['module_class'], $render_slug );
		$this->add_classname( array(
			$this->get_text_orientation_classname(),
			"et_pb_bg_layout_{$props['background_layout']}",
		) );
		if ( 'dark' === $props['background_layout'] ) {
			$this->add_classname( 'et_pb_text_color_light' );
		}
		/*
		 * Set styles
		 */
		if ( '' !== $props['module_bg'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_custom_fw .dp_oc_item',
				'declaration' => sprintf(
					'background-color: %1$s;', esc_html( $props['module_bg'] )
				),
			) );
		}
		if ( '' !== $props['arrow_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_custom_fw .owl-carousel .owl-nav',
				'declaration' => sprintf(
					'color: %1$s;', esc_html( $props['arrow_color'] )
				),
			) );
		}
		if ( '' !== $props['control_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_custom_fw .owl-carousel .owl-dots .owl-dot',
				'declaration' => sprintf(
					'background-color: %1$s;', esc_html( $props['control_color'] )
				),
			) );
		}
		if ( '' !== $props['control_size'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_custom_fw .owl-carousel .owl-dots .owl-dot',
				'declaration' => sprintf(
					'width: %1$s; height: %1$s', esc_html( $props['control_size'] )
				),
			) );
		}
		/*
		 * Init output
		 */
		ob_start();
		$content = apply_filters( 'dp_ocp_items_carousel_content', $props['content'], $props );
		echo sprintf( '<div class="owl-carousel" data-rotate="%1$s" data-speed="%2$s" data-hover="%3$s" data-arrow="%4$s" data-control="%5$s" data-items="%6$s" data-items-tablet="%7$s" data-items-phone="%8$s" data-margin="%9$s" data-behaviour="%10$s" data-direction="%11$s" data-center="%12$s" data-items-per-dot="%13$s" data-items-per-slide="%14$s" data-arrow-size="%15$s" data-use-hash="%16$s" data-use-auto-width="%17$s" data-module="%18$s" data-animation-speed="%19$s" data-arrows-speed="%20$s" data-controls-speed="%21$s" data-lazy="%22$s" data-url-anchor="%23$s" data-mousewheel="%24$s" data-mousewheel-delay="%26$s" data-drag="%25$s">%27$s</div>', $props['slide_auto'], $props['slide_speed'], $props['slide_hover'], $props['show_arrow'], $props['show_control'], $props['number_thumb'], $props['number_thumb_tablet'], $props['number_thumb_phone'], $props['item_margin'], $props['behavior'], $props['direction'], $props['center'], $props['items_per_dot'], $props['items_per_slide'], $props['arrow_size'], $props['use_hash_thumbnail'], $props['auto_width'], trim( $module_class ), $props['animation_speed'], $props['arrows_speed'], $props['dots_speed'], $props['lazy_load'], $props['url_anchors'], $props['use_mousewheel'], $props['mouse_drag'] . "|" . $props['touch_drag'] . "|" . $props['pull_drag'], $props['mousewheel_delay'], $content );
		$carousel_content = ob_get_clean();

		$hash_output = '';
		if ( $props['use_hash_thumbnail'] === 'on' ) {
			$hash_output = '<div class="dp_ocp_hash_container ' . $props['hash_thumbnail_align'] . '">';
			if ( $props['url_anchors'] === 'on' ) {
				foreach ( self::$images_ids[ $module_class ] as $key => $value ) {
					$hash_output .= '<a href="#' . trim( $module_class ) . '_' . $key . '" ><img class="dp_ocp_hash_image" src="' . wp_get_attachment_image_url( $value, $props['hash_thumbnail_size'] ) . '" /></a> ';
				}
			} else {
				foreach ( self::$images_ids[ $module_class ] as $key => $value ) {
					$hash_output .= '<a href="#" class="dp_ocp_nav_link" data-position="' . ( $key ) . '"><img class="dp_ocp_hash_image" src="' . wp_get_attachment_image_url( $value, $props['hash_thumbnail_size'] ) . '" /></a> ';
				}
			}
			$hash_output .= '</div>';
		}

		$output = sprintf( '%1$s%2$s', $carousel_content, $hash_output );

		return $output;
	}

}

new DPOCP_ImageCarouselFW;

