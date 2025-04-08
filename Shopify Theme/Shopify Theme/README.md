# Custom Shopify Theme

A modern, responsive Shopify theme featuring a product template with image gallery and a featured products carousel.

## Features

- Responsive product page layout with image gallery
- Featured products carousel with customizable settings
- Modern, clean design with optimized performance
- Accessibility-compliant markup

## Local Development Setup

### Prerequisites

1. [Shopify CLI](https://shopify.dev/themes/tools/cli/installation)
2. [Node.js](https://nodejs.org/) (version 14 or higher)
3. A Shopify Partner account and development store

### Installation

1. Clone this repository:
   ```bash
   git clone [repository-url]
   cd [theme-directory]
   ```

2. Install theme dependencies:
   ```bash
   npm install
   ```

3. Connect to your Shopify store using the Shopify CLI:
   ```bash
   shopify theme dev
   ```

## Project Structure

```
├── assets/
│   ├── featured-products-carousel.js
│   ├── product-template.js
│   └── theme.css
├── layout/
│   └── theme.liquid
├── sections/
│   └── featured-products-carousel.liquid
└── templates/
    └── product.liquid
```

## Theme Customization

### Product Template

The product template (`templates/product.liquid`) includes:
- Main product image with thumbnail gallery
- Product details (title, price, variants)
- Related products section

### Featured Products Carousel

The carousel section (`sections/featured-products-carousel.liquid`) can be customized through the theme editor:
- Number of products to display
- Autoplay settings
- Collection selection

## Testing

### Manual Testing Checklist

1. Product Page
   - [ ] Verify image gallery navigation
   - [ ] Check variant selection functionality
   - [ ] Test responsive layout on different devices
   - [ ] Validate price updates when variants change

2. Featured Products Carousel
   - [ ] Test carousel navigation (prev/next)
   - [ ] Verify autoplay functionality
   - [ ] Check responsive behavior
   - [ ] Confirm product links work correctly

### Cross-browser Testing

Test the theme in major browsers:
- Chrome
- Firefox
- Safari
- Edge

## Best Practices Implemented

1. Performance Optimization
   - Deferred JavaScript loading
   - Optimized image loading with proper sizing
   - Minimal CSS/JS dependencies

2. Accessibility
   - ARIA labels and roles
   - Keyboard navigation support
   - Proper heading hierarchy

3. Code Organization
   - Modular section structure
   - Clear file naming conventions
   - Consistent code formatting

## Theme Configuration

### Shopify Admin Setup

1. Navigate to Online Store > Themes
2. Upload the theme package
3. Customize theme settings:
   - Header configuration
   - Color schemes
   - Typography
   - Collection settings

## Support

For issues or questions, please open a GitHub issue or contact the theme developer.

## License

[License Type] - See LICENSE file for details