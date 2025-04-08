<?php
/**
 * Plugin Name: WP API Data Display
 * Plugin URI: https://example.com/wp-api-data-display
 * Description: A simple WordPress plugin to fetch and display data from an external API using shortcodes.
 * Version: 1.0.0
 * Author: WordPress Developer
 * Author URI: https://example.com
 * Text Domain: wp-api-data-display
 * License: GPL-2.0+
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('WPADD_VERSION', '1.0.0');
define('WPADD_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPADD_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WPADD_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Include required files
require_once WPADD_PLUGIN_DIR . 'includes/class-wp-api-data-display.php';
require_once WPADD_PLUGIN_DIR . 'admin/class-wp-api-data-display-admin.php';
require_once WPADD_PLUGIN_DIR . 'public/class-wp-api-data-display-public.php';

/**
 * Begins execution of the plugin.
 */
function run_wp_api_data_display() {
    // Initialize the main plugin class
    $plugin = new WP_API_Data_Display();
    $plugin->run();
    
    // Initialize admin functionality if in admin area
    if (is_admin()) {
        $plugin_admin = new WP_API_Data_Display_Admin();
        $plugin_admin->init();
    }
    
    // Initialize public functionality
    $plugin_public = new WP_API_Data_Display_Public();
    $plugin_public->init();
}

// Run the plugin
run_wp_api_data_display();