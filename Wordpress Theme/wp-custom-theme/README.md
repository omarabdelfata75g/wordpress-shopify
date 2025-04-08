# Custom WordPress Theme

A modern, responsive WordPress theme with support for posts, pages, archives, and custom post types. The theme features a clean design with thumbnail support, post meta information, and pagination.

## Features

- Responsive layout
- Featured image support
- Post meta information (date and author)
- Archive page support
- Sidebar integration
- Custom navigation menu
- Pagination for post listings

## Prerequisites

Before you begin, ensure you have the following installed:

- WordPress (latest version recommended)
- PHP 7.4 or higher
- MySQL 5.6 or higher
- Local development environment (e.g., MAMP, XAMPP, Local by Flywheel)

## Installation

1. Download or clone this repository
2. Extract the zip file (if downloaded)
3. Copy the theme folder to your WordPress installation's themes directory:
   ```
   wp-content/themes/
   ```
4. Log in to your WordPress admin panel
5. Go to Appearance > Themes
6. Activate the "Custom Theme"

## Local Development Setup

1. Set up a local WordPress development environment using your preferred tool (MAMP, XAMPP, etc.)
2. Create a new WordPress installation or use an existing one
3. Navigate to the themes directory:
   ```
   cd /path/to/wordpress/wp-content/themes/
   ```
4. Clone the repository or copy the theme files
5. Activate the theme through WordPress admin panel

## Development Approach

This theme was developed with the following considerations:

- **Modularity**: Template parts are separated into reusable components (header.php, footer.php, sidebar.php)
- **WordPress Standards**: Following WordPress coding standards and best practices
- **Responsive Design**: Mobile-first approach ensuring compatibility across devices
- **Performance**: Optimized code and assets for fast loading times

## Testing

### Manual Testing

1. Content Display
   - Create test posts with different content types (text, images, videos)
   - Verify proper display of post meta information
   - Check featured image functionality
   - Test pagination on archive pages

2. Responsive Testing
   - Test on different devices and screen sizes
   - Verify menu functionality on mobile devices
   - Check image scaling and layout adjustments

3. WordPress Features
   - Test comment functionality if enabled
   - Verify sidebar widget areas
   - Check custom menu locations
   - Test archive page displays

### Automated Testing (Optional)

For automated testing, you can use tools like:
- WordPress Unit Tests
- Browser testing tools (e.g., Selenium)
- Performance testing tools (e.g., Google Lighthouse)

## Customization

The theme can be customized through:

1. WordPress Customizer
2. Modifying theme files directly
3. Adding custom CSS in style.css
4. Creating child themes for extensive modifications

## Troubleshooting

Common issues and solutions:

1. Images not displaying
   - Verify proper thumbnail generation
   - Check media library permissions

2. Layout issues
   - Clear browser cache
   - Check for CSS conflicts
   - Verify responsive breakpoints

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This theme is licensed under the GPL v2 or later.

## Support

For support and questions, please open an issue in the repository.