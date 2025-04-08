# WordPress API Data Display Plugin

A WordPress plugin that fetches and displays data from external APIs using shortcodes. The plugin supports caching, customizable display templates, and AJAX refresh functionality.

## Features

- Fetch and display data from any REST API
- Customizable shortcode parameters
- Built-in caching system
- AJAX-based data refresh
- Admin interface for API configuration
- Error handling and user feedback

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher
- Active theme with widget/shortcode support

## Installation

1. Download the plugin files and upload them to your `/wp-content/plugins/wp-api-data-display` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Settings > WP API Data Display to configure your API settings

## Configuration

1. Obtain an API key from your chosen API provider
2. In the WordPress admin panel, go to Settings > WP API Data Display
3. Enter your API key in the designated field
4. Configure the API endpoint URL (e.g., `https://api.example.com/v1/data`)
5. Set any additional API parameters if required
6. Save your settings

## Usage

Use the shortcode `[api_data]` to display API data in your posts, pages, or widgets.

Example usage:
```
[api_data location="London" cache_time="1800"]
```

Shortcode parameters:
- `location`: The location to fetch data for (optional)
- `cache_time`: Cache duration in seconds (default: 1800)

## Development Approach

### Architecture

The plugin follows the WordPress plugin development best practices and is structured into three main components:

1. **Admin Class**: Handles all administrative functionality, including:
   - Settings page management
   - API configuration options
   - Plugin initialization

2. **Public Class**: Manages front-end functionality:
   - Shortcode rendering
   - API data fetching and caching
   - AJAX refresh handling

3. **Main Plugin Class**: Coordinates the admin and public components

### Challenges and Solutions

1. **API Rate Limiting**:
   - Implemented caching system using WordPress transients
   - Configurable cache duration via shortcode parameters

2. **Error Handling**:
   - Comprehensive error checking for API responses
   - User-friendly error messages
   - Fallback to cached data when API is unavailable

3. **Performance**:
   - Optimized API calls with caching
   - Minimal impact on page load times
   - Efficient data processing

## Testing

### Manual Testing

1. **Plugin Installation**:
   - Install the plugin on a fresh WordPress installation
   - Verify activation works without errors

2. **API Configuration**:
   - Navigate to Settings > WP API Data Display
   - Enter test API credentials
   - Verify settings are saved correctly

3. **Shortcode Testing**:
   - Add the shortcode to a test page
   - Verify data displays correctly
   - Test with different parameters

4. **Cache Testing**:
   - Monitor API calls using browser developer tools
   - Verify cached data is used when available
   - Test cache expiration

5. **Error Handling**:
   - Test with invalid API credentials
   - Check error message display
   - Verify graceful handling of API failures

### Automated Testing

To run automated tests (if implemented):

1. Set up a local WordPress test environment
2. Install PHPUnit and WordPress test suite
3. Run: `phpunit`

## API Configuration

### Required API Settings

- **API Key**: Your authentication key
- **API Endpoint**: The base URL for API requests
- **Additional Parameters**: Any required query parameters

### Security Considerations

- API keys are stored securely in WordPress options
- All API requests use WordPress nonces for security
- Data sanitization and validation implemented

## Support

For support questions or bug reports, please use the GitHub issues page or contact the plugin author.

## License

This plugin is licensed under the GPL v2 or later.

---

Developed with ❤️ for the WordPress community