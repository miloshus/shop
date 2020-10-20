<?php

class Dp_Owl_Carousel_Pro_Utils {

	/**
	 * Get url and width selected image based on thumbnail size.
	 *
	 * @param $props
	 *
	 * @return array
	 */
	public static function get_image_data( $props ) {
		$image_data          = array();
		$image_size_width    = '';
		$selected_size       = ( ! isset( $props['thumbnail_size'] ) || $props['thumbnail_size'] === 'undefined' ) ? 'et-pb-portfolio-image' : $props['thumbnail_size'];
		$selected_size_width = explode( 'x', self::get_custom_sizes()[ $selected_size ] )[0];
		$auto_width          = ( ! isset( $props['auto_width'] ) || $props['auto_width'] === 'undefined' ) ? 'off' : $props['auto_width'];
		/*
		 *
		 */
		if ( isset( $props['upload_image'] ) && ! empty( $props['upload_image'] ) ) {
			$attachment_id = self::get_attachment_id( $props['upload_image'] );
			if ( $auto_width === 'on' ) {
				if ( $props['use_original'] === 'on' ) {
					$image_size_width = wp_get_attachment_metadata( $attachment_id )['width'];
				} else {
					$image_size_width = wp_get_attachment_metadata( $attachment_id )['sizes'][ $selected_size ]['width'];
					if ( $image_size_width !== '' ) {
						$image_size_width = $image_size_width;
					} else {
						$image_size_width = $selected_size_width;
					}
				}
			}
			$image_src = '';
			if ( $props['use_original'] === 'on' ) {
				$image_src = $props['upload_image'];
			} else {
				$image_src = wp_get_attachment_image_url( $attachment_id, $selected_size );
			}
			$image_data['image_src']        = $image_src;
			$image_data['image_size_width'] = $image_size_width;
		} else {
			if ( $auto_width === 'on' ) {
				$image_size_width = $selected_size_width;
			}
		}

		return $image_data;
	}

	/**
	 * Get all registered images sizes
	 *
	 * @return array
	 */
	public static function get_custom_sizes() {
		$options = array();
		global $_wp_additional_image_sizes;
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array(
				'thumbnail',
				'medium',
				'medium_large',
				'large'
			) ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				);
			}
			$options[ $_size ] = $sizes[ $_size ]['width'] . 'x' . $sizes[ $_size ]['height'];
		}

		return $options;
	}

	/**
	 * Get an attachment ID given a URL.
	 *
	 * @param string $url
	 *
	 * @return int Attachment ID on success, 0 on failure
	 * @since 2.0
	 */
	public static function get_attachment_id( $url ) {
		$attachment_id = 0;
		$dir           = wp_upload_dir();
		if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) {
			$file       = basename( $url );
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata',
					),
				),
			);
			$query      = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$meta                = wp_get_attachment_metadata( $post_id );
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = array();
					if ( isset( $meta['sizes'] ) ) {
						$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
					}
					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
				}
			}
			wp_reset_postdata();
		}
		/*
		 * Fallback to old method
		 */
		if ( $attachment_id === 0 ) {
			global $wpdb;
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='attachment' AND guid='%s';", $url ) );
		}

		return $attachment_id;
	}

	/**
	 * Get posts data
	 *
	 * @param $props
	 * @param $module_order
	 *
	 * @return array
	 */
	public static function get_carousel_items_data( $props, $module_order ) {
		/*
		 * Init values
		 */
		$posts_data                         = array();
		$posts_data['hash_thumbnail_array'] = array();
		$hash_thumbnail_counter             = 0;
		$gallery_images                     = 0;
		if ( $props['use_hash_thumbnail'] === 'on' ) {
			$props['show_control'] = 'off';
		}
		$image_sizes         = self::get_custom_sizes();
		$selected_size_width = ( isset( $image_sizes[ $props['thumbnail_size'] ] ) ) ? explode( 'x', $image_sizes[ $props['thumbnail_size'] ] )[0] : '400';
		$default_size_width  = ( isset( $image_sizes['et-pb-portfolio-image'] ) ) ? explode( 'x', $image_sizes['et-pb-portfolio-image'] )[0] : '400';
		/*
		 *
		 */
		$posts = new WP_Query( self::set_query_arguments( $props ) );
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$data            = array();
				$data['post_id'] = get_the_ID();
				/*
				 * Custom URL
				 */
				if ( ( $props['custom_url'] === 'on' ) && ( $props['custom_url_field_name'] !== '' ) ) {
					$data['permalink'] = get_post_meta( $data['post_id'], $props['custom_url_field_name'], true );
				} else {
					$data['permalink'] = get_the_permalink();
				}
				$data['has_thumbnail'] = has_post_thumbnail();
				$data['post_type']     = get_post_type();
				/*
				 * Get all custom field names and display as names
				 */
				$data['post_custom_fields'] = array();
				if ( ( $props['custom_fields'] === 'on' ) && ( $props['custom_field_names'] != '' ) ) {
					$custom_fields_array = self::process_comma_separate_list( $props['custom_field_names'] );
					if ( $props['custom_field_labels'] != '' ) {
						$custom_fields_display = self::process_comma_separate_list( $props['custom_field_labels'] );
						if ( is_array( $custom_fields_array ) && is_array( $custom_fields_display ) && count( $custom_fields_array ) == count( $custom_fields_display ) ) {
							$data['post_custom_fields'] = self::dp_get_keyed_custom_fields( $custom_fields_array, $custom_fields_display, $data['post_id'] );
						} else {
							$data['post_custom_fields'] = self::dp_get_custom_fields( $custom_fields_array, $data['post_id'] );
						}
					} else {
						$data['post_custom_fields'] = self::dp_get_custom_fields( $custom_fields_array, $data['post_id'] );
					}
				}
				/*
				 * Init item warp an activate data-hash navigation
				 */
				$data['data_hash']    = '';
				$data['data_hash_vb'] = '';
				if ( $props['use_hash_thumbnail'] === 'on' && $data['has_thumbnail'] ) {
					$data['data_hash']    = ' data-hash="' . $module_order . '_' . $hash_thumbnail_counter . '" ';
					$data['data_hash_vb'] = $module_order . '_' . $hash_thumbnail_counter;
					$hash_thumbnail_counter ++;
				}
				/*
				 * Determine the image size width that will be apply to the item size
				 */
				$data['image_size_width'] = '';
				$data['image_vb']         = '';
				if ( $props['auto_width'] === 'on' ) {
					if ( $data['has_thumbnail'] ) {
						$thumbnail_id = get_post_thumbnail_id();
						$image_data   = wp_get_attachment_metadata( $thumbnail_id );
						if ( $props['thumbnail_original'] === 'on' ) {
							$width = ( isset( $image_data['width'] ) ) ? $image_data['width'] : $selected_size_width;
						} else {
							$width = ( isset( $image_data['sizes'][ $props['thumbnail_size'] ] ) ) ? $image_data['sizes'][ $props['thumbnail_size'] ]['width'] : $selected_size_width;
						}
						$data['image_vb']         = $width;
						$data['image_size_width'] = 'style="width: ' . $width . 'px"';
					} else {
						$data['image_vb']         = $default_size_width;
						$data['image_size_width'] = 'style="width: ' . $default_size_width . 'px"';
					}
				}
				/*
				 * Add post thumbnail
				 */
				$data['gallery_id'] = '';
				if ( $data['has_thumbnail'] ) {
					if ( $props['use_hash_thumbnail'] === 'on' ) {
						$posts_data['hash_thumbnail_array'][] = get_the_post_thumbnail_url( $data['post_id'], $props['hash_thumbnail_size'] );
					}
					if ( $props['thumbnail_original'] === 'on' ) {
						$data['thumbnail'] = $data['thumbnail_original'] = get_the_post_thumbnail_url( $data['post_id'] );
					} else {
						$data['thumbnail']          = get_the_post_thumbnail_url( $data['post_id'], $props['thumbnail_size'] );
						$data['thumbnail_original'] = get_the_post_thumbnail_url( $data['post_id'] );
					}
					if ( $props['lightbox'] === 'on' ) {
						$data['gallery_id'] = $gallery_images ++;
					}
				}
				/*
				 * Add post title, date, author and comments counts
				 */
				$data['title']       = get_the_title();
				$data['date']        = get_the_date();
				$data['author']      = get_the_author();
				$data['author_link'] = get_author_posts_url( get_post_field( 'post_author', $data['post_id'] ) );
				$data['comments']    = sprintf( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', DPOCP_NAME ), number_format_i18n( get_comments_number() ) );
				/*
				 * Add post terms
				 */
				$data['categories'] = array();
				$taxonomies         = get_post_taxonomies();
				foreach ( $taxonomies as $tax ) {
					if ( is_taxonomy_hierarchical( $tax ) ) {
						$terms = get_the_terms( $data['post_id'], $tax );
						if ( $terms ) {
							foreach ( $terms as $term ) {
								$term_data['url']     = get_term_link( $term );
								$term_data['name']    = $term->name;
								$data['categories'][] = $term_data;
							}
						}
					}
				}
				/*
				 * Add post excerpts
				 */
				$data['excerpt'] = apply_filters( 'dp_ocp_custom_excerpt', self::custom_excerpt( $props ), $props );
				/*
				 * Add custom_content
				 */
				$data['custom_content'] = apply_filters( 'dp_ocp_custom_content', '', $props );
				/*
				 * Add post data
				 */
				$posts_data['posts'][] = $data;
			}
		} else {
			$posts_data['no_results'] = apply_filters( 'dp_ocp_no_results', sprintf( '%1$s', __( 'No posts found', DPOCP_NAME ) ) );
		}
		wp_reset_postdata();

		return $posts_data;
	}

	/**
	 * Set the arguments for WP_Query
	 *
	 * @param $props
	 *
	 * @return array|mixed|void
	 */
	public static function set_query_arguments( $props ) {
		$args = array();
		if ( 'on' == $props['custom_query'] ) {
			$args = apply_filters(
				'dp_ocp_custom_query_args',
				array(
					'posts_per_page' => 10,
					'post_type'      => 'post',
					'post_status'    => 'publish',
				),
				$props
			);
		} else {
			$args['posts_per_page'] = intval( $props['number_post'] );
			if ( is_user_logged_in() ) {
				$args['post_status'] = array( 'publish', 'private' );
			} else {
				$args['post_status'] = array( 'publish' );
			}
			if ( ! empty( $props['offset_number'] ) ) {
				$args['offset'] = intval( $props['offset_number'] );
			}
			if ( ! empty( $props['cpt_name'] ) ) {
				$args['post_type'] = self::process_comma_separate_list( $props['cpt_name'] );
			} else {
				$args['post_type'] = array( 'post' );
			}
			$tax_query = array();
			if ( ! empty( $props['cpt_categories'] ) ) {
				$post_categories  = self::process_comma_separate_list( $props['cpt_categories'] );
				$taxonomies_terms = self::get_taxonomies_terms_array( $post_categories );
				foreach ( $taxonomies_terms as $tax => $terms ) {
					$tax_query[] = array(
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
					);
				}
				if ( count( $tax_query ) >= 2 ) {
					$tax_query['relation'] = 'OR';
				}
			}
			if ( $props['taxonomy_tags'] === '' ) {
				$props['taxonomy_tags'] = 'post_tag';
			}
			$tag_query = array();
			if ( ! empty( $props['include_tags'] ) ) {
				$tag_query[] = array(
					'taxonomy' => $props['taxonomy_tags'],
					'field'    => 'term_id',
					'terms'    => explode( ',', $props['include_tags'] ),
					'operator' => 'IN',
				);
			}
			if ( ! empty( $props['exclude_tags'] ) ) {
				$tag_query[] = array(
					'taxonomy' => $props['taxonomy_tags'],
					'field'    => 'term_id',
					'terms'    => explode( ',', $props['exclude_tags'] ),
					'operator' => 'NOT IN',
				);
			}
			if ( count( $tag_query ) >= 2 ) {
				$tag_query['relation'] = 'AND';
			}
			if ( ! empty( $tax_query ) && empty( $tag_query ) ) {
				$args['tax_query'] = $tax_query;
			} elseif ( empty( $tax_query ) && ! empty( $tag_query ) ) {
				$args['tax_query'] = $tag_query;
			} elseif ( ! empty( $tax_query ) && ! empty( $tag_query ) ) {
				$args['tax_query'][]           = $tax_query;
				$args['tax_query'][]           = $tag_query;
				$args['tax_query']['relation'] = 'AND';
			}
			$args['order']   = $props['order'];
			$args['orderby'] = $props['orderby'];
			if ( $props['orderby'] === 'meta_value' && $props['meta_key'] !== '' ) {
				$args['meta_key']  = $props['meta_key'];
				$args['meta_type'] = $props['meta_type'];
			}
			if ( 'on' === $props['sticky_posts'] ) {
				$args['ignore_sticky_posts'] = 1;
			}
			if ( $props['remove_current_post'] === 'on' && is_single() ) {
				$args['post__not_in'] = array( get_the_ID() );
			}
		}

		return $args;
	}

	/**
	 * Process comma separate list
	 *
	 * @param $list
	 *
	 * @return array|false
	 */
	public static function process_comma_separate_list( $list ) {
		$array = explode( ',', $list );
		if ( is_array( $array ) ) {
			foreach ( $array as $key => $value ) {
				$array[ $key ] = trim( $value );
			}
		}

		return $array;
	}

	/**
	 * Get multidimensional array with taxonomies and its terms
	 *
	 * @param $terms
	 *
	 * @return array
	 */
	public static function get_taxonomies_terms_array( $terms ) {
		$taxonomies_terms = array();
		foreach ( $terms as $term_id ) {
			$taxonomy = get_term( $term_id )->taxonomy;
			if ( ! isset( $taxonomies_terms[ $taxonomy ] ) ) {
				$taxonomies_terms[ $taxonomy ] = array();
				array_push( $taxonomies_terms[ $taxonomy ], $term_id );
			} else {
				array_push( $taxonomies_terms[ $taxonomy ], $term_id );
			}
		}

		return $taxonomies_terms;
	}

	/**
	 * Get custom fields with labels
	 *
	 * @param $custom_fields_array
	 * @param $custom_fields_display
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public static function dp_get_keyed_custom_fields( $custom_fields_array, $custom_fields_display, $post_id ) {
		foreach ( $custom_fields_array as $key => $field_value ) {
			$custom_field = trim( $field_value );
			if ( $custom_field !== '' ) {
				if ( function_exists( 'get_field' ) ) {
					$value = get_field( $custom_field, $post_id, true );
				} else {
					$value = get_post_meta( $post_id, $custom_field, true );
				}
				$post_custom_fields[] = array(
					'label' => $custom_fields_display[ $key ],
					'value' => $value,
				);
			}
		}

		return $post_custom_fields;
	}

	/**
	 * Get custom fields
	 *
	 * @param $custom_fields_array
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public static function dp_get_custom_fields( $custom_fields_array, $post_id ) {
		foreach ( $custom_fields_array as $field_display ) {
			$custom_field  = trim( $field_display );
			$field_display = ucfirst( str_replace( '_', ' ', ltrim( $field_display ) ) );
			$field_display .= ' - ';
			if ( $custom_field !== '' ) {
				if ( function_exists( 'get_field' ) ) {
					$value = get_field( $custom_field, $post_id, true );
				} else {
					$value = get_post_meta( $post_id, $custom_field, true );
				}
				$post_custom_fields[] = array(
					'label' => $field_display,
					'value' => $value,
				);
			}
		}

		return $post_custom_fields;
	}

	/**
	 * Return excerpt or generate it from post content
	 *
	 * @param $props
	 *
	 * @return string
	 */
	public static function custom_excerpt( $props ) {
		if ( has_excerpt() ) {
			return get_the_excerpt();
		} else {
			$post_content = wp_strip_all_tags( get_the_content() );
			$post_content = self::et_strip_shortcodes( $post_content );
			if ( isset( $props['post_excerpt_length'] ) && intval( $props['post_excerpt_length'] ) ) {
				return self::truncate_content( $post_content, $props['post_excerpt_length'] );
			} else {
				return $post_content;
			}
		}
	}

	/**
	 * Remove ET shortcodes
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public static function et_strip_shortcodes( $content ) {
		$content                  = trim( $content );
		$strip_content_shortcodes = array( 'et_pb_code', 'et_pb_fullwidth_code' );
		foreach ( $strip_content_shortcodes as $shortcode_name ) {
			$regex   = sprintf( '(\[%1$s[^\]]*\][^\[]*\[\/%1$s\])', esc_html( $shortcode_name ) );
			$content = preg_replace( $regex, '', $content );
		}
		$content = preg_replace( '(\[[^\]]+\])', '', $content );

		return $content;
	}

	/**
	 * Create excerpt from post content
	 *
	 * @param $excerpt
	 * @param $excerpt_limit
	 *
	 * @return string
	 */
	public static function truncate_content( $excerpt, $excerpt_limit ) {
		$charlength = $excerpt_limit;
		$charlength ++;
		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut ) . '...';
			} else {
				return $subex;
			}
		} else {
			return $excerpt;
		}
	}

	/**
	 * Ajax get cpt names for VB modal
	 */
	public static function ajax_get_cpt() {
		$html_output = '<form id="dp-ocp-cpt-form">';
		$html_output .= sprintf( '<p>%1$s</p>', __( 'Select one or more post types below. Use CTRL or SHIFT to select multiple.', DPOCP_NAME ) );
		$html_output .= '<select class="dp-ocp-vb-select" name="dp-ocp-vb-select" multiple size="6">';
		foreach ( self::get_cpt() as $key => $cpt ) {
			$html_output .= sprintf( '<option value="%1$s">%2$s</option>', $key, $cpt );
		}
		$html_output .= '</select>';
		$html_output .= self::vb_modal_actions();
		$html_output .= '</form';
		echo $html_output;
		wp_die();
	}

	/**
	 * Get cpt names for VB modal
	 *
	 * @return array
	 */
	public static function get_cpt() {
		$options           = array();
		$default_post_type = apply_filters( 'dpocp_default_post_types', array( 'post' => get_post_type_object( 'post' ) ) );
		$post_types        = array_merge(
			$default_post_type,
			get_post_types(
				array(
					'_builtin' => false,
					'public'   => true,
				),
				'objects'
			)
		);
		foreach ( $post_types as $pt ) {
			$options[ $pt->name ] = $pt->label;
		}

		return $options;
	}

	/**
	 * VB modal action buttons
	 */
	public static function vb_modal_actions() {
		$html_output = '<div class="dp-ocp-vb-actions">';
		$html_output .= sprintf( '<input class="dp-ocp-vb-submit" type="button" value="%1$s" />', __( 'Set Values', DPOCP_NAME ) );
		$html_output .= sprintf( '<input class="dp-ocp-vb-clean" type="button" value="%1$s" />', __( 'Clean Values', DPOCP_NAME ) );
		$html_output .= sprintf( '<input class="dp-ocp-vb-finish" type="button" value="%1$s" />', __( 'Exit', DPOCP_NAME ) );
		$html_output .= '</div>';

		return $html_output;
	}

	/**
	 * Ajax get taxonomies names for VB modal
	 */
	public static function ajax_get_taxonomies() {
		$cpt_array = array( 'post' );
		if ( isset( $_POST['cpt'] ) ) {
			if ( substr_count( $_POST['cpt'], ',' ) > 0 ) {
				$cpt_array = self::process_comma_separate_list( $_POST['cpt'] );
			} else {
				$cpt_array = array( $_POST['cpt'] );
			}
		}
		$html_output = '<form id="dp-ocp-tax-form">';
		$html_output .= sprintf( '<p>%1$s</p>', __( 'Select one or more taxonomies below. Use CTRL or SHIFT to select multiple.', DPOCP_NAME ) );
		$html_output .= '<select class="dp-ocp-vb-select" name="dp-ocp-vb-select" multiple size="6">';
		foreach ( self::get_taxonomies( $cpt_array ) as $key => $tax ) {
			$html_output .= sprintf( '<option value="%1$s">%2$s</option>', $key, $tax );
		}
		$html_output .= '</select>';
		$html_output .= self::vb_modal_actions();
		$html_output .= '</form';
		echo $html_output;
		wp_die();
	}

	/**
	 * Get taxonomies names for VB modal
	 *
	 * @param $cpt
	 *
	 * @return array
	 */
	public static function get_taxonomies( $cpt ) {
		$options                = array();
		$blacklisted_taxonomies = apply_filters( 'dpocp_blacklisted_taxonomies', array(
			'layout_category',
			'layout_pack',
			'layout_type',
			'scope',
			'module_width',
			'post_format'
		) );
		$taxonomies             = array_diff(
			get_taxonomies(
				array(
					'public'    => true,
					'query_var' => true,
				)
			),
			$blacklisted_taxonomies
		);
		if ( $cpt[0] === 'all' ) {
			foreach ( $taxonomies as $tax ) {
				$tax_obj         = get_taxonomy( $tax );
				$options[ $tax ] = $tax_obj->label;
			}
		} else {
			foreach ( $taxonomies as $tax ) {
				$tax_obj  = get_taxonomy( $tax );
				$is_there = array_intersect( $cpt, $tax_obj->object_type );
				if ( ! empty( $is_there ) ) {
					$options[ $tax ] = $tax_obj->label;
				}
			}
		}

		return $options;
	}

	/**
	 * Ajax get taxonomy terms for VB modal
	 */
	public static function ajax_get_taxonomies_terms() {
		$tax_array = array( 'category' );
		if ( isset( $_POST['tax'] ) ) {
			if ( substr_count( $_POST['tax'], ',' ) > 0 ) {
				$tax_array = self::process_comma_separate_list( $_POST['tax'] );
			} else {
				$tax_array = array( $_POST['tax'] );
			}
		}
		$cpt_array = array( 'post' );
		if ( isset( $_POST['cpt'] ) ) {
			if ( substr_count( $_POST['cpt'], ',' ) > 0 ) {
				$cpt_array = self::process_comma_separate_list( $_POST['cpt'] );
			} else {
				$cpt_array = array( $_POST['cpt'] );
			}
		}
		$html_output = '<form id="dp-ocp-terms-form">';
		$html_output .= sprintf( '<p>%1$s</p>', __( 'Select one or more terms below. Use CTRL or SHIFT to select multiple.', DPOCP_NAME ) );
		$html_output .= '<select class="dp-ocp-vb-select" name="dp-ocp-vb-select" multiple size="12">';
		foreach ( self::get_taxonomies_terms( $tax_array, $cpt_array ) as $tax => $terms ) {
			$html_output .= '<optgroup label="' . esc_html( $tax ) . '">';
			$html_output .= self::show_taxonomy_hierarchy( '', $terms );
			$html_output .= '</optgroup>';
		}
		$html_output .= '</select>';
		$html_output .= self::vb_modal_actions();
		$html_output .= '</form>';
		echo $html_output;
		wp_die();
	}

	public static function show_taxonomy_hierarchy( $html_output, $terms, $level = 0 ) {
		foreach ( $terms as $term ) {
			$html_output .= sprintf( '<option value="%1$s">%3$s %2$s</option>', esc_html( $term->term_id ), esc_html( $term->name ) . ' (' . $term->count . ')', str_repeat( '-', $level ) );
			if ( ! empty( $term->children ) ) {
				$html_output .= self::show_taxonomy_hierarchy( '', $term->children, ( $level + 1 ) );
			}
		}

		return $html_output;
	}

	public static function get_taxonomy_hierarchy( $taxonomy, $parent = 0 ) {
		$terms    = get_terms( $taxonomy, array(
			'parent'     => $parent,
			'hide_empty' => false
		) );
		$children = array();
		foreach ( $terms as $term ) {
			$term->children             = self::get_taxonomy_hierarchy( $taxonomy, $term->term_id );
			$children[ $term->term_id ] = $term;
		}

		return $children;
	}

	/**
	 * Get taxonomy terms for VB modal
	 *
	 * @param $tax
	 * @param $cpt
	 *
	 * @return array
	 */
	public static function get_taxonomies_terms( $tax, $cpt ) {
		$options            = array();
		$all_cpt_taxonomies = self::get_taxonomies( $cpt );
		foreach ( $all_cpt_taxonomies as $tax_name => $tax_label ) {
			if ( 'all' === $tax[0] || in_array( $tax_name, $tax, true ) ) {
				$terms = self::get_taxonomy_hierarchy( $tax_name );
				if ( ! empty( $terms ) ) {
					$options[ $tax_label . ' (' . $tax_name . ')' ] = $terms;
				}
			}
		}

		return $options;
	}

	/**
	 * Localize the script that handles the custom modal for the cpt, tax and terms selection
	 */
	public static function enqueue_and_localize_cpt_modal_script() {
		wp_enqueue_style( 'dp-owl-carousel-pro-admin-cpt-modal', DPOCP_URL . 'admin/css/dpocp-admin.min.css', array(), DPOCP_VERSION );
		wp_enqueue_script( 'dp-owl-carousel-pro-admin-cpt-modal', DPOCP_URL . 'admin/js/dpocp-admin.min.js', array( 'jquery' ), DPOCP_VERSION, true );
		wp_localize_script(
			'dp-owl-carousel-pro-admin-cpt-modal',
			'dpocp',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);
	}

}
