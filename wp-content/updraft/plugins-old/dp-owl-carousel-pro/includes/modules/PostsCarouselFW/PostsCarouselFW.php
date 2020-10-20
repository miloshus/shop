<?php

class DPOCP_PostsCarouselFW extends ET_Builder_Module {

	public $slug = 'et_pb_dp_oc_fw';
	public $vb_support = 'on';
	protected $module_credits = array(
		'module_uri' => 'https://www.diviplugins.com/divi/owl-carousel-pro-plugin',
		'author'     => 'DiviPlugins',
		'author_uri' => 'https://www.diviplugins.com',
	);

	public function init() {
		$this->fullwidth        = true;
		$this->name             = __( 'DP Owl Carousel', 'dpocp-dp-owl-carousel-pro' );
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
					'content'  => esc_html__( 'Query Arguments', DPOCP_NAME ),
					'elements' => esc_html__( 'Posts Elements', DPOCP_NAME ),
					'carousel' => esc_html__( 'Carousel Options', DPOCP_NAME ),
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
				'post_title'      => array(
					'label'       => __( 'Post Title', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_oc_post_title, {$this->main_css_element} .dp_oc_item .dp_oc_post_title a",
					),
					"line_height" => array( "default" => "1.7em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'post_meta'       => array(
					'label'       => __( 'Post Meta', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_oc_post_meta, {$this->main_css_element} .dp_oc_item .dp_oc_post_meta a",
					),
					"line_height" => array( "default" => "1.7em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'post_excerpt'    => array(
					'label'       => __( 'Post Excerpt', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_oc_post_excerpt",
					),
					"line_height" => array( "default" => "1.5em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'read_more'       => array(
					'label'       => __( 'Read More Link', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_oc_post_excerpt .dp_oc_read_more_link",
					),
					"line_height" => array( "default" => "1.7em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'dp_custom_field' => array(
					'label'       => __( 'Custom Fields', DPOCP_NAME ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dp_oc_item .dp_custom_field",
					),
					"line_height" => array( "default" => "1em", ),
					"font_size"   => array( "default" => "14px", ),
				),
			),
			'custom_margin_padding' => array(),
			'max_width'             => array(),
			'border'                => array(),
			'filters'               => false
		);
	}

	public function get_custom_css_fields_config() {
		return array(
			'ocp_item'           => array(
				'label'    => __( 'Carousel Items Container', DPOCP_NAME ),
				'selector' => '.dp_oc_item',
			),
			'ocp_arrow_prev'     => array(
				'label'    => __( 'Previous Arrow', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-nav .owl-prev::before',
			),
			'ocp_arrow_next'     => array(
				'label'    => __( 'Next Arrow', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-nav .owl-next::before',
			),
			'ocp_control'        => array(
				'label'    => __( 'Controls', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-dots .owl-dot',
			),
			'ocp_control_active' => array(
				'label'    => __( 'Active Control', DPOCP_NAME ),
				'selector' => '.owl-carousel .owl-dots .owl-dot.active',
			),
			'ocp_item_image'     => array(
				'label'    => __( 'Post Image', DPOCP_NAME ),
				'selector' => 'img.dp_oc_post_thumb',
			),
			'ocp_item_title'     => array(
				'label'    => __( 'Post Title', DPOCP_NAME ),
				'selector' => '.dp_oc_post_title',
			),
			'ocp_item_meta'      => array(
				'label'    => __( 'Post Meta', DPOCP_NAME ),
				'selector' => '.dp_oc_post_meta',
			),
			'ocp_item_cf'        => array(
				'label'    => __( 'Custom Fields Container', DPOCP_NAME ),
				'selector' => '.dp_custom_field',
			),
			'ocp_cf_name'        => array(
				'label'    => __( 'Custom Field Label', DPOCP_NAME ),
				'selector' => '.dp_custom_field_name',
			),
			'ocp_cf_label'       => array(
				'label'    => __( 'Custom Field Value', DPOCP_NAME ),
				'selector' => '.dp_custom_field_value',
			),
			'ocp_item_excerpt'   => array(
				'label'    => __( 'Post Excerpt', DPOCP_NAME ),
				'selector' => '.dp_oc_post_excerpt',
			),
			'ocp_item_read_more' => array(
				'label'    => __( 'Read More Link', DPOCP_NAME ),
				'selector' => '.dp_oc_read_more_link',
			),
			'ocp_hash_container' => array(
				'label'    => __( 'Navigation Thumbnail Container', DPOCP_NAME ),
				'selector' => '.dp_ocp_hash_container',
			),
			'ocp_hash_image'     => array(
				'label'    => __( 'Navigation Thumbnail Images', DPOCP_NAME ),
				'selector' => '.dp_ocp_hash_image',
			),
		);
	}

	public function get_fields() {
		$fields = array(
			/*
			 * Query Fields
			 */
			'custom_query'             => array(
				'label'           => __( 'Custom Query', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn this option on if you want to create a custom query that is not possible using the options below. Once this option is turned on, all Content options below will be ignored and the module will load the 10 most recent blog posts by default. You can override this query using the following filter in your child theme\'s functions.php file: <strong>dp_ocp_custom_query_args</strong>. For more information and to see an example, see demo at <a href="https://www.diviplugins.com/divi-custom-queries/" target="_blank">Divi Plugins</a>', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'number_post'              => array(
				'label'           => __( 'Posts Number', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '10',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'How many posts you want to include in the carousel', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'offset_number'            => array(
				'label'           => __( 'Offset Number', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '0',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Choose how many posts you would like to offset by', DPOCP_NAME ),
			),
			'remove_current_post'      => array(
				'label'           => __( 'Remove Current Post', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Turn on if you want to remove the current post when you are using the carousel from the query. Useful if you want to show a carousel of related content.', DPOCP_NAME ),
			),
			'sticky_posts'             => array(
				'label'           => __( 'Ignore Sticky Posts', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', DPOCP_NAME ),
					'off' => __( 'No', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Turn this option on to ignore sticky posts.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'cpt_name'                 => array(
				'label'           => __( 'Custom Post Type Name', DPOCP_NAME ),
				'option_category' => 'configuration',
				'type'            => 'text',
				'default'         => 'post',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Check which posts types you would like to include in the layout', DPOCP_NAME ),
			),
			'cpt_categories'           => array(
				'label'           => __( 'Categories', DPOCP_NAME ),
				'option_category' => 'configuration',
				'type'            => 'text',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Check which categories you would like to include in the carousel', DPOCP_NAME ),
			),
			'taxonomy_tags'            => array(
				'label'           => __( 'Include/Exclude Taxonomy', DPOCP_NAME ),
				'option_category' => 'configuration',
				'type'            => 'text',
				'default'         => 'post_tag',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Here you can control which taxonomy the include/exclude terms apply to. Leave empty for posts tags. For other CPTs, enter the taxonomy name above. For projects, the tag taxonomy name is project_tag.', DPOCP_NAME ),
			),
			'include_tags'             => array(
				'label'           => __( 'Include Terms', DPOCP_NAME ),
				'option_category' => 'configuration',
				'type'            => 'text',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Enter a single term id or a comma separated list of terms ids. All posts in the categories above AND WITH these terms will load. Leave empty if you only want to filter using the categories above.', DPOCP_NAME ),
			),
			'exclude_tags'             => array(
				'label'           => __( 'Exclude Terms', DPOCP_NAME ),
				'option_category' => 'configuration',
				'type'            => 'text',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Enter a single term id or a comma separated list of terms ids. All posts in the categories above AND WITHOUT these terms will load. Leave empty if you only want to filter using the categories above.', DPOCP_NAME ),
			),
			'orderby'                  => array(
				'label'           => __( 'Order By', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'ID'            => __( 'Post ID', DPOCP_NAME ),
					'date'          => __( 'Date', DPOCP_NAME ),
					'title'         => __( 'Title', DPOCP_NAME ),
					'name'          => __( 'Slug', DPOCP_NAME ),
					'rand'          => __( 'Random', DPOCP_NAME ),
					'menu_order'    => __( 'Menu Order', DPOCP_NAME ),
					'modified'      => __( 'Last Modified Date', DPOCP_NAME ),
					'comment_count' => __( 'Comments Count', DPOCP_NAME ),
					'parent'        => __( 'Parent ID', DPOCP_NAME ),
					'type'          => __( 'Post Type', DPOCP_NAME ),
					'author'        => __( 'Author', DPOCP_NAME ),
					'meta_value'    => __( 'Custom Field', DPOCP_NAME ),
				),
				'default'         => 'date',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Choose how to sort posts', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'meta_key'                 => array(
				'label'           => __( 'Custom Field Name', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '',
				'show_if'         => array(
					'custom_query' => 'off',
					'orderby'      => array( 'meta_value' )
				),
				'description'     => __( 'Enter the custom field name.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'meta_type'                => array(
				'label'           => __( 'Custom Field Type', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'NUMERIC',
					'BINARY',
					'CHAR',
					'DATE',
					'DATETIME',
					'DECIMAL',
					'SIGNED',
					'TIME',
					'UNSIGNED'
				),
				'default'         => 'CHAR',
				'show_if'         => array(
					'custom_query' => 'off',
					'orderby'      => array( 'meta_value' )
				),
				'description'     => __( 'Enter the custom field type.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'order'                    => array(
				'label'           => __( 'Order', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'DESC' => __( 'Desc', DPOCP_NAME ),
					'ASC'  => __( 'Asc', DPOCP_NAME ),
				),
				'default'         => 'DESC',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Choose which order to display posts', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			/*
			 * Elements Fields
			 */
			'show_thumbnail'           => array(
				'label'           => __( 'Show Featured Image', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', DPOCP_NAME ),
					'off' => __( 'No', DPOCP_NAME ),
				),
				'default'         => 'on',
				'description'     => __( 'This will turn thumbnails on and off.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_post_title'          => array(
				'label'           => __( 'Show Title', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn the title on or off.', DPOCP_NAME ),
			),
			'show_author'              => array(
				'label'           => __( 'Show Author', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', DPOCP_NAME ),
					'off' => __( 'No', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn on or off the author link.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'author_prefix_text'       => array(
				'label'           => __( 'Author Prefix', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => __( 'By ', DPOCP_NAME ),
				'show_if'         => array( 'show_author' => 'on' ),
				'description'     => __( 'Custom prefix displayed before author name.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_post_category'       => array(
				'label'           => __( 'Show Category', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn the category on or off.', DPOCP_NAME ),
			),
			'show_post_date'           => array(
				'label'           => __( 'Show Date', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn the post date on or off.', DPOCP_NAME ),
			),
			'show_comments'            => array(
				'label'           => __( 'Show Comment Count', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', DPOCP_NAME ),
					'off' => __( 'No', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn comment count on or off.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_fields'            => array(
				'label'           => __( 'Show Custom Fields', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Displays custom fields set in each post.', DPOCP_NAME ),
			),
			'custom_field_names'       => array(
				'label'       => __( 'Custom Field Names', DPOCP_NAME ),
				'type'        => 'text',
				'show_if'     => array( 'custom_fields' => 'on' ),
				'default'     => '',
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
				'description' => __( 'Enter a single custom field name or a comma separated list of names.', DPOCP_NAME ),
			),
			'custom_field_labels'      => array(
				'label'       => __( 'Custom Field Labels', DPOCP_NAME ),
				'type'        => 'text',
				'show_if'     => array( 'custom_fields' => 'on' ),
				'default'     => '',
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
				'description' => __( 'Enter custom field label (including separator and spaces) or a comma separated list of labels in the same order as the names above. The number of labels must equal the number of names above, otherwise the name above will be used as the label for each custom field. For more information, see demo at <a href="http://www.diviplugins.com/owl-carousel-pro-plugin/">Divi Plugins</a>', DPOCP_NAME ),
			),
			'show_post_excerpt'        => array(
				'label'           => __( 'Show Excerpt', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn the post excerpt on or off.', DPOCP_NAME ),
			),
			'post_excerpt_length'      => array(
				'label'           => __( 'Automatic Excerpt Length', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '270',
				'show_if'         => array( 'show_post_excerpt' => 'on' ),
				'description'     => __( 'Define the length of automatically generated excerpts. Leave blank for default ( 270 ) ', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'read_more'                => array(
				'label'           => __( 'Show Read More Link', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array( 'show_post_excerpt' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'description'     => __( 'Turn the read more link on or off.', DPOCP_NAME ),
			),
			'read_more_text'           => array(
				'label'           => __( 'Read More Text', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array(
					'show_post_excerpt' => 'on',
					'read_more'         => 'on'
				),
				'default'         => 'read more',
				'description'     => __( 'Define the read more text. Leave blank for default ( read more ) ', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_custom_content'      => array(
				'label'           => __( 'Show Custom Content', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'Off', DPOCP_NAME ),
					'on'  => __( 'On', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Show or hide custom content via dp_ocp_custom_content filter.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_url'               => array(
				'label'           => __( 'Use Custom URL', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'description'     => __( 'Changes the URL to a custom field value set in each post.', DPOCP_NAME ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_url_field_name'    => array(
				'label'       => __( 'Custom Field for URL', DPOCP_NAME ),
				'type'        => 'text',
				'show_if'     => array( 'custom_url' => 'on' ),
				'description' => __( 'Enter custom field name (NOT the URL). The URL value needs to be set in each post using the custom field you input here. If no value is set, defaults to post URL.', DPOCP_NAME ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			/*
			 * Carousel Options
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
				'toggle_slug'     => 'carousel',
				'description'     => __( 'This setting allows you to turn the navigation arrows on or off. Arrows will only display if the number of available posts exceeds the number of thumbnails set to display per slide.', DPOCP_NAME ),
			),
			'items_per_slide'          => array(
				'label'           => __( 'Items Per Slide Action', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '1',
				'show_if'         => array( 'show_arrow' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
				'description'     => __( 'Turn navigation controls on or off. Controls will only display if the number of available posts exceeds the number of thumbnails set to display.', DPOCP_NAME ),
			),
			'items_per_dot'            => array(
				'label'           => __( 'Items Per Control Action', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '3',
				'show_if'         => array( 'show_control' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
				'description'     => __( 'Activate carousel navigation using the mouse wheel.', DPOCP_NAME ),
			),
			'mousewheel_delay'         => array(
				'label'           => __( 'Mousewheel Delay', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '160',
				'show_if'         => array( 'use_mousewheel' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'carousel'
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
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
				'toggle_slug'     => 'carousel',
			),
			/*
			 * Thumbnail Options
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
			 * On click
			 */
			'lightbox'                 => array(
				'label'           => __( 'Open In Lightbox', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'onclick',
				'description'     => __( 'Image opens in lightbox instead of opening blog post.', DPOCP_NAME ),
			),
			'lightbox_gallery'         => array(
				'label'           => __( 'Use Lightbox Gallery', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'show_if'         => array( 'lightbox' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'onclick',
				'description'     => __( 'Turn this option on if you want the lightbox to display all images from the carousel in a gallery. Leave this option off if you only want the clicked image to display in the lightbox.', DPOCP_NAME ),
			),
			'gallery_cf'               => array(
				'label'           => __( 'Open Custom Lightbox Gallery', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'onclick',
				'description'     => __( 'Turn this option on to display a custom lightbox gallery of images when the featured image is clicked. Enter the custom field name below containing the image or array of images to load for each post. You can also provide an image or array of images using the <a href="https://diviplugins.com/documentation/owl-carousel-pro/custom-lightbox/">Custom Lightbox filter</a>.', DPOCP_NAME ),
			),
			'gallery_cf_name'          => array(
				'label'           => __( 'Custom Field Name for Images', DPOCP_NAME ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'default'         => '',
				'show_if'         => array( 'gallery_cf' => 'on' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'onclick',
				'description'     => __( 'Enter the custom field name containing the image or array of images you would like to load in the custom lightbox gallery. Leave this empty to use the <a href="https://diviplugins.com/documentation/portfolio-posts-pro/custom-lightbox/">Custom Lightbox filter</a>.', DPOCP_NAME ),
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
			'thumbnail_original'       => array(
				'label'           => __( 'Original Size', DPOCP_NAME ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( "No", DPOCP_NAME ),
					'on'  => __( 'Yes', DPOCP_NAME ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thumbnail',
				'default'         => 'off',
				'description'     => __( 'Load the original image instead of looking for image thumbnail. If images are small and do not have a thumbnail in the size selected, this option will load the full size of the image.', DPOCP_NAME ),
			),
			'thumbnail_size'           => array(
				'label'           => __( 'Thumbnail Size', DPOCP_NAME ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => $this->image_sizes,
				'default'         => 'et-pb-portfolio-image',
				'show_if'         => array( 'thumbnail_original' => 'off' ),
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
		parent::before_render();
		/*
		 * Enqueue styles and scripts
		 */
		wp_enqueue_style( 'dp-ocp-owl-carousel' );
		wp_enqueue_script( 'dp-ocp-owl-carousel' );
		wp_enqueue_script( 'dp-owl-carousel-pro-frontend-bundle' );
		if ( $this->props['use_mousewheel'] === 'on' ) {
			wp_enqueue_script( 'dp-ocp-mousewheel' );
		}
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
		$gallery_images = 0;
		if ( $props['use_hash_thumbnail'] === 'on' ) {
			$props['show_control'] = 'off';
		}
		/*
		 * Add class names
		 */
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
				'selector'    => '%%order_class%%.et_pb_dp_oc_fw .dp_oc_item',
				'declaration' => sprintf(
					'background-color: %1$s;', esc_html( $props['module_bg'] )
				),
			) );
		}
		if ( '' !== $props['arrow_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_fw .owl-carousel .owl-nav',
				'declaration' => sprintf(
					'color: %1$s;', esc_html( $props['arrow_color'] )
				),
			) );
		}
		if ( '' !== $props['control_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_fw .owl-carousel .owl-dots .owl-dot',
				'declaration' => sprintf(
					'background-color: %1$s;', esc_html( $props['control_color'] )
				),
			) );
		}
		if ( '' !== $props['control_size'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.et_pb_dp_oc_fw .owl-carousel .owl-dots .owl-dot',
				'declaration' => sprintf(
					'width: %1$s; height: %1$s', esc_html( $props['control_size'] )
				),
			) );
		}
		/*
		 *
		 */
		$posts = Dp_Owl_Carousel_Pro_Utils::get_carousel_items_data( $props, $module_order );
		ob_start();
		if ( ! isset( $posts['no_results'] ) ) {
			echo sprintf( '<div class="owl-carousel" data-rotate="%1$s" data-speed="%2$s" data-hover="%3$s" data-arrow="%4$s" data-control="%5$s" data-items="%6$s" data-items-tablet="%7$s" data-items-phone="%8$s" data-margin="%9$s" data-behaviour="%10$s" data-direction="%11$s" data-center="%12$s" data-items-per-dot="%13$s" data-items-per-slide="%14$s" data-arrow-size="%15$s" data-use-hash="%16$s" data-use-auto-width="%17$s" data-module="%18$s" data-animation-speed="%19$s" data-arrows-speed="%20$s" data-controls-speed="%21$s" data-lazy="%22$s" data-url-anchor="%23$s" data-mousewheel="%24$s" data-mousewheel-delay="%26$s" data-drag="%25$s">', $props['slide_auto'], $props['slide_speed'], $props['slide_hover'], $props['show_arrow'], $props['show_control'], $props['number_thumb'], $props['number_thumb_tablet'], $props['number_thumb_phone'], $props['item_margin'], $props['behavior'], $props['direction'], $props['center'], $props['items_per_dot'], $props['items_per_slide'], $props['arrow_size'], $props['use_hash_thumbnail'], $props['auto_width'], $module_order, $props['animation_speed'], $props['arrows_speed'], $props['dots_speed'], $props['lazy_load'], $props['url_anchors'], $props['use_mousewheel'], $props['mouse_drag'] . "|" . $props['touch_drag'] . "|" . $props['pull_drag'], $props['mousewheel_delay'] );
			foreach ( $posts['posts'] as $post ) {
				echo sprintf( '<div class="dp_oc_item" %1$s %2$s>', ( $props['url_anchors'] === 'on' ) ? $post['data_hash'] : "", $post['image_size_width'] );
				/*
				 * Add post thumbnail
				 */
				if ( $props['show_thumbnail'] === 'on' && $post['has_thumbnail'] ) {
					if ( $props['lightbox'] === "on" ) {
						echo sprintf( '<a href="#" data-ref="%1$s" class="dp_ocp_lightbox_image" ><img class="dp_oc_post_thumb %6$s" %7$ssrc="%2$s" alt="%3$s" data-lightbox-gallery="%4$s" data-gallery-image="%5$s"></a>', $post['thumbnail_original'], $post['thumbnail'], $post['title'], ( $props['lightbox_gallery'] === 'on' ) ? 'on' : 'off', $gallery_images ++, ( $props['lazy_load'] === 'on' ) ? 'owl-lazy' : '', ( $props['lazy_load'] === 'on' ) ? 'data-' : '' );
					} else {
						$post_images = array();
						if ( $props['gallery_cf'] === "on" ) {
							$custom_field_images = array();
							if ( $props['gallery_cf_name'] !== "" ) {
								$custom_field_images = get_post_meta( $post['post_id'], $props['gallery_cf_name'] );
							}
							$post_images = apply_filters( 'dp_ocp_custom_lightbox', $custom_field_images, $props );
						}
						echo sprintf( '<a href="%1$s" %6$s %7$s><img class="dp_oc_post_thumb %4$s" %5$ssrc="%2$s" alt="%3$s"></a>', $post['permalink'], $post['thumbnail'], $post['title'], ( $props['lazy_load'] === 'on' ) ? 'owl-lazy' : '', ( $props['lazy_load'] === 'on' ) ? 'data-' : '',
							( ! empty( $post_images ) ) ? 'class="dp_ocp_gallery_cf"' : "",
							( ! empty( $post_images ) ) ? 'data-images="' . implode( "||", $post_images ) . '"' : "" );
					}
				}
				/*
				 * Add post title
				 */
				if ( $props['show_post_title'] === 'on' ) {
					if ( $props['lightbox'] === 'on' ) {
						echo sprintf( '<h2 class="dp_oc_post_title">%1$s</h2>', $post['title'] );
					} else {
						echo sprintf( '<h2 class="dp_oc_post_title"><a  href="%1$s">%2$s</a></h2>', $post['permalink'], $post['title'] );
					}
				}
				/*
				 * Add post author
				 */
				if ( $props['show_author'] === 'on' ) {
					echo sprintf( '<p class="post-meta dp_oc_post_meta dp_oc_post_author"><a href="%2$s">%3$s %1$s</a></p>', $post['author'], $post['author_link'], $props['author_prefix_text'] );
				}
				/*
				 * Add post terms
				 */
				if ( $props['show_post_category'] === 'on' && ! empty( $post['categories'] ) ) {
					echo '<p class="post-meta dp_oc_post_meta dp_oc_post_categories">';
					for ( $index = 0; $index < count( $post['categories'] ); $index ++ ) {
						$cat = $post['categories'][ $index ];
						echo sprintf( '<a href="%1$s">%2$s</a>', $cat['url'], $cat['name'] );
						if ( $index !== ( count( $post['categories'] ) - 1 ) ) {
							echo ', ';
						}
					}
					echo '</p>';
				}
				/*
				 * Add post date
				 */
				if ( $props['show_post_date'] === 'on' ) {
					echo sprintf( '<p class="post-meta dp_oc_post_meta dp_oc_post_date">%1$s</p>', $post['date'] );
				}
				/*
				 * Add comments count
				 */
				if ( $props['show_comments'] === 'on' ) {
					echo sprintf( '<p class="post-meta dp_oc_post_meta dp_oc_post_comments">%1$s</p>', $post['comments'] );
				}
				/*
				 * Add post custom fields
				 */
				if ( $props['custom_fields'] === 'on' && ! empty( $post['post_custom_fields'] ) ) {
					foreach ( $post['post_custom_fields'] as $cf ) {
						if ( $cf['value'] != '' ) {
							echo sprintf( '<p class="post-meta dp_custom_field"><span class="dp_custom_field_name">%1$s</span> <span class="dp_custom_field_value">%2$s</span></p>', $cf['label'], $cf['value'] );
						}
					}
				}
				/*
				 * Add post excerpts
				 */
				if ( $props['show_post_excerpt'] === 'on' ) {
					echo '<div class="post-excerpt dp_oc_post_excerpt">';
					echo $post['excerpt'];
					if ( $props['read_more'] === 'on' ) {
						echo sprintf( '<a href="%1$s" class="dp_oc_read_more_link">%2$s</a>', $post['permalink'], ( ! empty( $props['read_more_text'] ) ? $props['read_more_text'] : 'read more' ) );
					}
					echo '</div>';
				}
				/*
				 * Custom content
				 */
				if ( $props['show_custom_content'] === 'on' ) {
					echo $post['custom_content'];
				}
				echo '</div>';
			}
			echo '</div>';
		} else {
			echo sprintf( '<p>%1$s</p>', $posts['no_results'] );
		}
		$carousel_content = ob_get_clean();

		$hash_output = '';
		if ( $props['use_hash_thumbnail'] === 'on' ) {
			$hash_output = '<div class="dp_ocp_hash_container ' . $props['hash_thumbnail_align'] . '">';
			if ( $props['url_anchors'] === 'on' ) {
				foreach ( $posts['hash_thumbnail_array'] as $key => $value ) {
					$hash_output .= '<a href="#' . trim( $module_class ) . '_' . $key . '" ><img class="dp_ocp_hash_image" src="' . $value . '" /></a> ';
				}
			} else {
				foreach ( $posts['hash_thumbnail_array'] as $key => $value ) {
					$hash_output .= '<a href="#" class="dp_ocp_nav_link" data-position="' . ( $key ) . '"><img class="dp_ocp_hash_image" src="' . $value . '" /></a> ';
				}
			}
			$hash_output .= '</div>';
		}

		$output = sprintf( '%1$s%2$s', $carousel_content, $hash_output );

		return $output;
	}

}

new DPOCP_PostsCarouselFW;
