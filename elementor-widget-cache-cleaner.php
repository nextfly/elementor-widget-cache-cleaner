<?php
/*
Plugin Name: Elementor Widget Cache Cleaner
Description: Clears Elementor element cache meta when specific widgets are detected on a page/post.
Version: 0.1.0
Author: NEXTFLY® Web Design
Author URI: https://nextflywebdesign.com/
Requires Plugins: elementor
Requires at least: 5.9
Requires PHP: 7.4
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) || exit;

// Only run the plugin code if Elementor is active.
add_action( 'plugins_loaded', function () {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_action( 'template_redirect', function () {
		if ( ! is_singular() ) {
			return;
		}

		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return;
		}

		$document = \Elementor\Plugin::$instance->documents->get( $post_id );

		if ( ! $document || ! $document->is_built_with_elementor() ) {
			return;
		}

		$data = $document->get_elements_data();

		if ( empty( $data ) ) {
			return;
		}

		$widget_types_to_find = ['pp-gravity-forms', 'shortcode'];
        $widget_types_to_find = apply_filters( 'ewcc_widget_types_to_find', $widget_types_to_find );
        
		$widget_found = false;

		if ( ! function_exists( 'find_elementor_widget_recursive' ) ) {
			function find_elementor_widget_recursive( $elements, $widget_types, &$found ) {
				foreach ( $elements as $element ) {
					if ( $found ) {
						return;
					}

					if (
						isset( $element['elType'], $element['widgetType'] )
						&& 'widget' === $element['elType']
						&& in_array( $element['widgetType'], $widget_types, true )
					) {
						$found = true;
						return;
					}

					if ( ! empty( $element['elements'] ) ) {
						find_elementor_widget_recursive( $element['elements'], $widget_types, $found );
					}
				}
			}
		}

		find_elementor_widget_recursive( $data, $widget_types_to_find, $widget_found );

		if ( $widget_found ) {
			$meta_key = '_elementor_element_cache';
			$meta_value = get_post_meta( $post_id, $meta_key, true );
			if ( $meta_value ) {
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}, 11 );
});

register_activation_hook( __FILE__, function () {
	if ( ! did_action( 'elementor/loaded' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( 'This plugin requires Elementor to be installed and active.', 'Plugin dependency check', ['back_link' => true] );
	}
});
