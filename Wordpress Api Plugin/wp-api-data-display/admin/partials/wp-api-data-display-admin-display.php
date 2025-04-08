<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 * @package    WP_API_Data_Display
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        // Output security fields
        settings_fields('wp-api-data-display');
        
        // Output setting sections and their fields
        do_settings_sections('wp-api-data-display');
        
        // Output save settings button
        submit_button();
        ?>
    </form>
    
    <div class="card" style="max-width: 800px; margin-top: 20px;">
        <h2><?php _e('Shortcode Usage', 'wp-api-data-display'); ?></h2>
        <p><?php _e('Use the following shortcode to display API data on any page or post:', 'wp-api-data-display'); ?></p>
        <code>[api_data]</code>
        
        <h3><?php _e('Shortcode Attributes', 'wp-api-data-display'); ?></h3>
        <ul>
            <li><strong>location</strong>: <?php _e('Override the default location (for weather API)', 'wp-api-data-display'); ?><br>
                <code>[api_data location="New York"]</code>
            </li>
            <li><strong>cache_time</strong>: <?php _e('Set custom cache time in seconds (default: 1800)', 'wp-api-data-display'); ?><br>
                <code>[api_data cache_time="3600"]</code>
            </li>
        </ul>
    </div>
</div>