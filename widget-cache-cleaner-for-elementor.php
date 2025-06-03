<?php
/**
 * Plugin Name: Widget Cache Cleaner for Elementor
 * Description: Clears Elementor element cache meta when specific widgets are detected on a page/post.
 * Version: 0.1.0
 * Author: NEXTFLY® Web Design
 * Author URI: https://nextflywebdesign.com/
 * Text Domain: widget-cache-cleaner-for-elementor
 * Requires Plugins: elementor
 * Requires at least: 5.9
 * Requires PHP: 7.4
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package WidgetCacheCleanerForElementor
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recursive function to find specific widget types in Elementor data.
 *
 * @since 0.1.0
 * @param array $elements    The elements to search through.
 * @param array $widget_types The widget types to look for.
 * @param bool  &$found      Reference to the found status.
 * @return void
 */
function wccfe_find_elementor_widget_recursive( $elements, $widget_types, &$found ) {
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
			wccfe_find_elementor_widget_recursive( $element['elements'], $widget_types, $found );
		}
	}
}

/**
 * Check for specific widgets on the current page and clear cache if found.
 *
 * @since 0.1.0
 * @return void
 */
function wccfe_check_widgets() {
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
	$widget_types_to_find = apply_filters( 'wccfe_widget_types_to_find', $widget_types_to_find );
	$widget_found = false;

	wccfe_find_elementor_widget_recursive( $data, $widget_types_to_find, $widget_found );

	if ( $widget_found ) {
		$meta_key = '_elementor_element_cache';
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( $meta_value ) {
			// Delete the cache meta to ensure fresh content is displayed
			delete_post_meta( $post_id, $meta_key );
		}
	}
}

/**
 * Main plugin functionality.
 *
 * Only runs if Elementor is active.
 *
 * @since 0.1.0
 * @return void
 */
function wccfe_init() {
	// Check if Elementor is active
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_action( 'template_redirect', 'wccfe_check_widgets', 11 );
}

/**
 * Plugin activation hook.
 * Checks if Elementor is active, otherwise deactivates the plugin.
 *
 * @since 0.1.0
 * @return void
 */
function wccfe_activation_check() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( esc_html__( 'This plugin requires Elementor to be installed and active.', 'widget-cache-cleaner-for-elementor' ), 'Plugin dependency check', ['back_link' => true] );
	}
}

// Initialize the plugin
add_action( 'plugins_loaded', 'wccfe_init' );

// Register activation hook
register_activation_hook( __FILE__, 'wccfe_activation_check' );
