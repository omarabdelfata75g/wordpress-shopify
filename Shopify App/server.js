import { join } from 'path';
import { readFileSync } from 'fs';
import express from 'express';
import serveStatic from 'serve-static';
import shopify from '@shopify/shopify-api';
import { shopifyApp } from '@shopify/shopify-app-express';
import { SQLiteSessionStorage } from '@shopify/shopify-app-session-storage-sqlite';
import dotenv from 'dotenv';

dotenv.config();

const PORT = parseInt(process.env.PORT || 3000);
const DB_PATH = 'sessions.sqlite';

// Initialize SQLite session storage
const sessionStorage = new SQLiteSessionStorage(DB_PATH);

// Initialize Express app
const app = express();

// Set up Shopify authentication and webhooks
const shopifyAppConfig = {
  api: {
    apiKey: process.env.SHOPIFY_API_KEY,
    apiSecretKey: process.env.SHOPIFY_API_SECRET,
    scopes: process.env.SCOPES.split(','),
    hostName: process.env.HOST.replace(/https?:\/\//, ''),
    isEmbeddedApp: true,
    hostScheme: 'https'
  },
  auth: {
    path: '/api/auth',
    callbackPath: '/api/auth/callback',
  },
  webhooks: {
    path: '/api/webhooks',
  },
  sessionStorage,
};

const shopifyAppMiddleware = shopifyApp(shopifyAppConfig);
app.use(shopifyAppMiddleware);

// API endpoint to get discount settings
app.get('/api/settings', async (req, res) => {
  const session = res.locals.shopify.session;
  const client = new shopify.clients.Rest(session);

  try {
    const response = await client.get({
      path: 'metafields',
      query: { namespace: 'cart_discount' }
    });

    const settings = response.body.metafields.reduce((acc, metafield) => {
      acc[metafield.key] = metafield.value;
      return acc;
    }, {});

    res.json(settings);
  } catch (error) {
    console.error('Error fetching settings:', error);
    res.status(500).json({ error: 'Failed to fetch settings' });
  }
});

// API endpoint to update discount settings
app.post('/api/settings', express.json(), async (req, res) => {
  const session = res.locals.shopify.session;
  const client = new shopify.clients.Rest(session);
  const { minProducts, discountPercentage } = req.body;

  try {
    await client.post({
      path: 'metafields',
      data: {
        metafield: {
          namespace: 'cart_discount',
          key: 'settings',
          value: JSON.stringify({ minProducts, discountPercentage }),
          type: 'json'
        }
      }
    });

    res.json({ success: true });
  } catch (error) {
    console.error('Error updating settings:', error);
    res.status(500).json({ error: 'Failed to update settings' });
  }
});

// Webhook handler for cart updates
app.post('/api/webhooks/cart/update', async (req, res) => {
  const session = res.locals.shopify.session;
  const client = new shopify.clients.Rest(session);

  try {
    const cart = req.body;
    const settingsResponse = await client.get({
      path: 'metafields',
      query: { namespace: 'cart_discount' }
    });

    const settings = settingsResponse.body.metafields.find(
      m => m.key === 'settings'
    )?.value;

    if (!settings) return res.sendStatus(200);

    const { minProducts, discountPercentage } = JSON.parse(settings);
    const totalItems = cart.items.reduce((sum, item) => sum + item.quantity, 0);

    if (totalItems >= minProducts) {
      // Apply discount
      await client.post({
        path: 'price_rules',
        data: {
          price_rule: {
            title: `Cart Quantity Discount (${discountPercentage}% off)`,
            target_type: 'line_item',
            target_selection: 'all',
            allocation_method: 'across',
            value_type: 'percentage',
            value: `-${discountPercentage}`,
            customer_selection: 'all',
            starts_at: new Date().toISOString()
          }
        }
      });
    }

    res.sendStatus(200);
  } catch (error) {
    console.error('Error processing cart update:', error);
    res.sendStatus(500);
  }
});

// Serve static files and handle client routing
app.use(serveStatic(join(process.cwd(), 'build')));
app.use('/*', (req, res) => {
  res.sendFile(join(process.cwd(), 'build', 'index.html'));
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});