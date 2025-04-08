import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from '@shopify/app-bridge-react';
import App from './App';

const root = ReactDOM.createRoot(document.getElementById('root'));

const config = {
  apiKey: process.env.SHOPIFY_API_KEY,
  host: new URLSearchParams(window.location.search).get('host'),
  forceRedirect: true
};

root.render(
  <React.StrictMode>
    <Provider config={config}>
      <App />
    </Provider>
  </React.StrictMode>
);