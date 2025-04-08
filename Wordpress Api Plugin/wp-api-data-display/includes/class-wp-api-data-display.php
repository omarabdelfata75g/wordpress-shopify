<?php
/**
 * The main plugin class.
 *
 * This class defines all code necessary to run the plugin's core functionality.
 *
 * @since      1.0.0
 * @package    WP_API_Data_Display
 */

class WP_API_Data_Display {

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'wp-api-data-display';
        $this->version = WPADD_VERSION;
    }

    /**
     * Register all of the hooks related to the plugin functionality.
     *
     * @since    1.0.0
     */
    public function run() {
        // Register activation and deactivation hooks
        register_activation_hook(WPADD_PLUGIN_BASENAME, array($this, 'activate'));
        register_deactivation_hook(WPADD_PLUGIN_BASENAME, array($this, 'deactivate'));
        
        // Register shortcode
        add_shortcode('api_data', array($this, 'api_data_shortcode'));
    }

    /**
     * The code that runs during plugin activation.
     *
     * @since    1.0.0
     */
    public function activate() {
        // Add default options
        add_option('wpadd_api_key', '');
        add_option('wpadd_api_endpoint', 'https://api.openweathermap.org/data/2.5/weather');
        add_option('wpadd_api_params', 'q=London&units=metric');
    }

    /**
     * The code that runs during plugin deactivation.
     *
     * @since    1.0.0
     */
    public function deactivate() {
        // Cleanup if needed
    }

    /**
     * Shortcode callback function to display API data.
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string   Formatted API data.
     */
    public function api_data_shortcode($atts) {
        // Extract shortcode attributes
        $atts = shortcode_atts(
            array(
                'location' => '',
                'cache_time' => 1800, // 30 minutes default cache time
            ),
            $atts,
            'api_data'
        );

        // Get API settings
        $api_key = get_option('wpadd_api_key');
        $api_endpoint = get_option('wpadd_api_endpoint');
        $api_params = get_option('wpadd_api_params');
        
        // Check if API key is set
        if (empty($api_key)) {
            return '<div class="api-data-error">API key is not configured. Please set it in the plugin settings.</div>';
        }
        
        // Override location if provided in shortcode
        if (!empty($atts['location'])) {
            $api_params = 'q=' . urlencode($atts['location']) . '&units=metric';
        }
        
        // Build the API URL
        $api_url = $api_endpoint . '?' . $api_params . '&appid=' . $api_key;
        
        // Generate a transient key based on the API URL
        $transient_key = 'wpadd_' . md5($api_url);
        
        // Check if we have cached data
        $api_data = get_transient($transient_key);
        
        if (false === $api_data) {
            // No cached data, fetch from API
            $response = wp_remote_get($api_url);
            
            // Check for errors
            if (is_wp_error($response)) {
                return '<div class="api-data-error">Error fetching data: ' . esc_html($response->get_error_message()) . '</div>';
            }
            
            // Check response code
            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code !== 200) {
                return '<div class="api-data-error">Error: API returned status code ' . esc_html($response_code) . '</div>';
            }
            
            // Get response body and decode JSON
            $api_data = json_decode(wp_remote_retrieve_body($response), true);
            
            // Cache the data
            set_transient($transient_key, $api_data, $atts['cache_time']);
        }
        
        // Format and return the data (example for weather API)
        $output = $this->format_api_data($api_data);
        
        return $output;
    }
    
    /**
     * Format API data for display.
     *
     * @since    1.0.0
     * @param    array    $data    API data.
     * @return   string   Formatted HTML.
     */
    private function format_api_data($data) {
        // This is an example for OpenWeatherMap API
        // Modify according to your API structure
        if (empty($data) || !isset($data['main'])) {
            return '<div class="api-data-error">Invalid data received from API.</div>';
        }
        
        $output = '<div class="api-data-container">';
        
        if (isset($data['name'])) {
            $output .= '<h3>' . esc_html($data['name']) . '</h3>';
        }
        
        if (isset($data['main']['temp'])) {
            $output .= '<p>Temperature: ' . esc_html($data['main']['temp']) . '°C</p>';
        }
        
        if (isset($data['main']['humidity'])) {
            $output .= '<p>Humidity: ' . esc_html($data['main']['humidity']) . '%</p>';
        }
        
        if (isset($data['weather'][0]['description'])) {
            $output .= '<p>Conditions: ' . esc_html($data['weather'][0]['description']) . '</p>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
}