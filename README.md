# Widget Cache Cleaner for Elementor

**Version:** 0.1.0  
**Author:** [NEXTFLY® Web Design](https://nextflywebdesign.com/)

## Description

Widget Cache Cleaner for Elementor automatically clears the `_elementor_element_cache` meta for posts or pages built with Elementor when specific widgets are detected. This ensures dynamic widgets like Gravity Forms or shortcodes always display the latest content.

- **Requires Elementor** to be installed and active
- Detects `pp-gravity-forms` and `shortcode` widgets by default
- Developers can filter widget types using the `wccfe_widget_types_to_find` filter
- No settings page - just activate and it works

## Installation

1. Upload the plugin to your `/wp-content/plugins/` directory or install via the WordPress admin.
2. Activate the plugin through the 'Plugins' menu.
3. Ensure [Elementor](https://wordpress.org/plugins/elementor/) is active.

## FAQ

**What widgets does this plugin check for?**  
By default, `pp-gravity-forms` and `shortcode`. Developers can adjust this with the `wccfe_widget_types_to_find` filter.

**Does this plugin have a settings page?**  
No, it works automatically.

**What if Elementor is not active?**  
The plugin will deactivate itself and show an admin notice.

## Changelog

### 0.1.0
- Initial release.

---

Developed by [NEXTFLY® Web Design](https://nextflywebdesign.com/)
