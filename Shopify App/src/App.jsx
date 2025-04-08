import React from 'react';
import { BrowserRouter } from 'react-router-dom';
import { NavigationMenu } from '@shopify/app-bridge-react';
import { AppProvider } from '@shopify/polaris';
import '@shopify/polaris/build/esm/styles.css';
import enTranslations from '@shopify/polaris/locales/en.json';
import { DiscountSettings } from './components/DiscountSettings';

function App() {
  return (
    <BrowserRouter>
      <AppProvider i18n={enTranslations}>
        <NavigationMenu
          navigationLinks={[
            {
              label: 'Discount Settings',
              destination: '/'
            }
          ]}
        />
        <DiscountSettings />
      </AppProvider>
    </BrowserRouter>
  );
}

export default App;