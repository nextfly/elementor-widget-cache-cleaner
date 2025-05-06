=== Elementor Widget Cache Cleaner ===
Contributors: nextflywebdesign
Tags: elementor, cache, widget, performance, gravity forms
Requires at least: 5.9
Tested up to: 6.8.1
Requires PHP: 7.4
Stable tag: 0.1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Clears Elementor element cache meta when specific widgets are detected on a page or post.

== Description ==

Elementor Widget Cache Cleaner automatically clears the `_elementor_element_cache` meta for posts or pages built with Elementor when certain widgets are present. This helps ensure dynamic widgets like Gravity Forms or custom shortcodes always display up-to-date content.

* Only runs if Elementor is installed and active.
* Detects widgets by type (`pp-gravity-forms`, `shortcode` by default).
* Developers can filter the widget types using the `ewcc_widget_types_to_find` filter.
* No settings page-just activate and go.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/` or install via the WordPress admin.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure [Elementor](https://wordpress.org/plugins/elementor/) is installed and active.

== Frequently Asked Questions ==

= What widgets does this plugin check for? =
By default, it checks for the `pp-gravity-forms` and `shortcode` Elementor widgets. Developers can modify this list using the `ewcc_widget_types_to_find` filter.

= Does this plugin have any settings? =
No. It works automatically in the background.

= What happens if Elementor is not active? =
The plugin will deactivate itself and show an admin notice if Elementor is not active.

== Changelog ==

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 0.1.0 =
First release. Clears Elementor element cache meta for posts containing specific widgets.

== Credits ==

Developed by [NEXTFLY® Web Design](https://nextflywebdesign.com/).
