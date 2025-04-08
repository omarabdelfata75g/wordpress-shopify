# Shopify Cart Discount App

A Shopify app that automatically applies discounts based on the number of products in a customer's cart. Store owners can configure the minimum product quantity required and the discount percentage through the admin panel.

## Features

- Automatic discount application based on cart quantity
- Configurable minimum product threshold
- Adjustable discount percentage
- Real-time cart monitoring
- User-friendly admin interface

## Setup

1. Clone the repository
2. Install dependencies:
   ```bash
   npm install
   ```
3. Configure environment variables in `.env`:
   - SHOPIFY_API_KEY: Your Shopify API key
   - SHOPIFY_API_SECRET: Your Shopify API secret
   - SCOPES: Required app scopes
   - HOST: Your app's host URL
   - SHOP: Your shop's myshopify.com domain
   - PORT: Port number (default: 3000)

4. Start the development server:
   ```bash
   npm run dev
   ```

## Usage

1. Install the app in your Shopify store
2. Navigate to the app's admin panel
3. Configure the following settings:
   - Minimum Products: Set the minimum number of products required in cart
   - Discount Percentage: Set the discount percentage to apply
4. Save the settings

The app will automatically monitor cart updates and apply the configured discount when the minimum product threshold is met.

## Technical Details

- Built with React and Express
- Uses Shopify's App Bridge for seamless admin integration
- Implements Shopify's REST Admin API for cart and discount management
- Stores settings using Shopify's Metafields API

## Security

- Implements OAuth 2.0 for secure authentication
- Uses session-based storage for maintaining authentication state
- Follows Shopify's security best practices

## Support

For issues or questions, please open an issue in the repository.