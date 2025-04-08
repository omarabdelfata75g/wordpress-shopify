?<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    WP_API_Data_Display
 */

class WP_API_Data_Display_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

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
     * Register all of the hooks related to the admin area functionality.
     *
     * @since    1.0.0
     */
    public function init() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        
        // Add settings link to plugins page
        add_filter('plugin_action_links_' . WPADD_PLUGIN_BASENAME, array($this, 'add_action_links'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Add options page to the admin menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {
        add_options_page(
            'API Data Display Settings', // Page title
            'API Data Display', // Menu title
            'manage_options', // Capability
            $this->plugin_name, // Menu slug
            array($this, 'display_plugin_setup_page') // Callback function
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     * @param    array    $links    Plugin action links.
     * @return   array    Plugin action links.
     */
    public function add_action_links($links) {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', 'wp-api-data-display') . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Register settings for the plugin.
     *
     * @since    1.0.0
     */
    public function register_settings() {
        // Register a setting for API key
        register_setting(
            $this->plugin_name, // Option group
            'wpadd_api_key', // Option name
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '',
            )
        );

        // Register a setting for API endpoint
        register_setting(
            $this->plugin_name,
            'wpadd_api_endpoint',
            array(
                'sanitize_callback' => 'esc_url_raw',
                'default' => 'https://api.openweathermap.org/data/2.5/weather',
            )
        );

        // Register a setting for API parameters
        register_setting(
            $this->plugin_name,
            'wpadd_api_params',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'q=London&units=metric',
            )
        );

        // Add a settings section
        add_settings_section(
            'wpadd_general_section', // ID
            __('API Settings', 'wp-api-data-display'), // Title
            array($this, 'settings_section_callback'), // Callback
            $this->plugin_name // Page
        );

        // Add settings fields
        add_settings_field(
            'wpadd_api_key', // ID
            __('API Key', 'wp-api-data-display'), // Title
            array($this, 'api_key_field_callback'), // Callback
            $this->plugin_name, // Page
            'wpadd_general_section' // Section
        );

        add_settings_field(
            'wpadd_api_endpoint',
            __('API Endpoint URL', 'wp-api-data-display'),
            array($this, 'api_endpoint_field_callback'),
            $this->plugin_name,
            'wpadd_general_section'
        );

        add_settings_field(
            'wpadd_api_params',
            __('Default API Parameters', 'wp-api-data-display'),
            array($this, 'api_params_field_callback'),
            $this->plugin_name,
            'wpadd_general_section'
        );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page() {
        include_once WPADD_PLUGIN_DIR . 'admin/partials/wp-api-data-display-admin-display.php';
    }

    /**
     * Render the settings section description.
     *
     * @since    1.0.0
     */
    public function settings_section_callback() {
        echo '<p>' . __('Configure your API settings below. For the OpenWeatherMap API, you can get a free API key by signing up at <a href="https://openweathermap.org/api" target="_blank">openweathermap.org</a>.', 'wp-api-data-display') . '</p>';
        echo '<p>' . __('Use the shortcode <code>[api_data]</code> to display the API data on any page or post. You can also specify a location with <code>[api_data location="New York"]</code>.', 'wp-api-data-display') . '</p>';
    }

    /**
     * Render the API key input field.
     *
     * @since    1.0.0
     */
    public function api_key_field_callback() {
        $api_key = get_option('wpadd_api_key');
        echo '<input type="text" id="wpadd_api_key" name="wpadd_api_key" value="' . esc_attr($api_key) . '" class="regular-text" />';
        echo '<p class="description">' . __('Enter your API key here.', 'wp-api-data-display') . '</p>';
    }

    /**
     * Render the API endpoint input field.
     *
     * @since    1.0.0
     */
    public function api_endpoint_field_callback() {
        $api_endpoint = get_option('wpadd_api_endpoint');
        echo '<input type="url" id="wpadd_api_endpoint" name="wpadd_api_endpoint" value="' . esc_attr($api_endpoint) . '" class="regular-text" />';
        echo '<p class="description">' . __('The API endpoint URL.', 'wp-api-data-display') . '</p>';
    }

    /**
     * Render the API parameters input field.
     *
     * @since    1.0.0
     */
    public function api_params_field_callback() {
        $api_params = get_option('wpadd_api_params');
        echo '<input type="text" id="wpadd_api_params" name="wpadd_api_params" value="' . esc_attr($api_params) . '" class="regular-text" />';
        echo '<p class="description">' . __('Default API parameters (e.g., q=London&units=metric).', 'wp-api-data-display') . '</p>';
    }
}