<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 * @package    WP_API_Data_Display
 */

class WP_API_Data_Display_Public {
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function init() {
        add_shortcode('api_data', array($this, 'render_api_data'));
        add_action('wp_ajax_refresh_api_data', array($this, 'refresh_api_data'));
        add_action('wp_ajax_nopriv_refresh_api_data', array($this, 'refresh_api_data'));
    }

    /**
     * Render the API data shortcode.
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            The shortcode output.
     */
    public function render_api_data($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'location' => '',
            'cache_time' => 1800 // 30 minutes default
        ), $atts, 'api_data');

        // Get API settings
        $api_key = get_option('wpadd_api_key');
        $api_endpoint = get_option('wpadd_api_endpoint');
        $default_params = get_option('wpadd_api_params');

        if (empty($api_key) || empty($api_endpoint)) {
            return '<p class="error">' . __('API configuration is incomplete. Please configure the plugin settings.', 'wp-api-data-display') . '</p>';
        }

        // Generate cache key
        $cache_key = 'wpadd_api_data_' . md5($api_endpoint . $atts['location']);

        // Try to get cached data
        $cached_data = get_transient($cache_key);
        if ($cached_data !== false) {
            return $this->format_api_data($cached_data);
        }

        // Fetch fresh data if cache is empty
        $api_data = $this->fetch_api_data($api_endpoint, $api_key, $atts['location'], $default_params);
        if (is_wp_error($api_data)) {
            return '<p class="error">' . $api_data->get_error_message() . '</p>';
        }

        // Cache the data
        set_transient($cache_key, $api_data, $atts['cache_time']);

        return $this->format_api_data($api_data);
    }

    /**
     * Fetch data from the API.
     *
     * @since    1.0.0
     * @param    string    $endpoint    The API endpoint URL.
     * @param    string    $api_key     The API key.
     * @param    string    $location    Optional location parameter.
     * @param    string    $params      Additional API parameters.
     * @return   array|WP_Error        The API response or error.
     */
    private function fetch_api_data($endpoint, $api_key, $location = '', $params = '') {
        // Parse and prepare API parameters
        $query_params = array(
            'appid' => $api_key
        );

        if (!empty($location)) {
            $query_params['q'] = $location;
        }

        if (!empty($params)) {
            parse_str($params, $additional_params);
            $query_params = array_merge($query_params, $additional_params);
        }

        // Build the API URL
        $api_url = add_query_arg($query_params, $endpoint);

        // Make the API request
        $response = wp_remote_get($api_url, array(
            'timeout' => 15
        ));

        if (is_wp_error($response)) {
            return new WP_Error('api_error', __('Failed to connect to the API.', 'wp-api-data-display'));
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (empty($data)) {
            return new WP_Error('api_error', __('Invalid API response.', 'wp-api-data-display'));
        }

        return $data;
    }

    /**
     * Format the API data for display.
     *
     * @since    1.0.0
     * @param    array    $data    The API data to format.
     * @return   string           The formatted HTML output.
     */
    private function format_api_data($data) {
        ob_start();
        ?>
        <div class="wpadd-api-data">
            <?php if (isset($data['name'])) : ?>
                <h3><?php echo esc_html($data['name']); ?></h3>
            <?php endif; ?>

            <?php if (isset($data['weather'][0]['description'])) : ?>
                <p class="weather-description">
                    <?php echo esc_html($data['weather'][0]['description']); ?>
                </p>
            <?php endif; ?>

            <?php if (isset($data['main'])) : ?>
                <div class="weather-details">
                    <?php if (isset($data['main']['temp'])) : ?>
                        <p class="temperature">
                            <?php echo esc_html(round($data['main']['temp'])); ?>°C
                        </p>
                    <?php endif; ?>

                    <?php if (isset($data['main']['humidity'])) : ?>
                        <p class="humidity">
                            <?php _e('Humidity', 'wp-api-data-display'); ?>: 
                            <?php echo esc_html($data['main']['humidity']); ?>%
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <p class="last-updated">
                <?php _e('Last updated', 'wp-api-data-display'); ?>: 
                <?php echo esc_html(current_time('F j, Y H:i:s')); ?>
            </p>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * AJAX handler for refreshing API data.
     *
     * @since    1.0.0
     */
    public function refresh_api_data() {
        check_ajax_referer('wpadd_refresh_nonce', 'nonce');

        $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        $shortcode = '[api_data';
        if (!empty($location)) {
            $shortcode .= ' location="' . esc_attr($location) . '"';
        }
        $shortcode .= ']';

        $output = do_shortcode($shortcode);

        wp_send_json_success(array(
            'html' => $output
        ));
    }
}