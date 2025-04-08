import React, { useState, useEffect } from 'react';
import {
  Page,
  Layout,
  Card,
  FormLayout,
  TextField,
  Button,
  Banner,
} from '@shopify/polaris';

export function DiscountSettings() {
  const [settings, setSettings] = useState({
    minProducts: '',
    discountPercentage: ''
  });
  const [status, setStatus] = useState({ loading: false, error: null, success: false });

  useEffect(() => {
    fetchSettings();
  }, []);

  const fetchSettings = async () => {
    try {
      const response = await fetch('/api/settings');
      if (!response.ok) throw new Error('Failed to fetch settings');
      const data = await response.json();
      if (data.settings) {
        const parsedSettings = JSON.parse(data.settings);
        setSettings(parsedSettings);
      }
    } catch (error) {
      setStatus({ loading: false, error: 'Failed to load settings', success: false });
    }
  };

  const handleSubmit = async () => {
    setStatus({ loading: true, error: null, success: false });

    try {
      const response = await fetch('/api/settings', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(settings)
      });

      if (!response.ok) throw new Error('Failed to save settings');
      setStatus({ loading: false, error: null, success: true });
    } catch (error) {
      setStatus({ loading: false, error: 'Failed to save settings', success: false });
    }
  };

  const handleChange = (field) => (value) => {
    setSettings(prev => ({ ...prev, [field]: value }));
  };

  return (
    <Page title="Discount Settings">
      <Layout>
        <Layout.Section>
          {status.error && (
            <Banner status="critical">
              {status.error}
            </Banner>
          )}
          {status.success && (
            <Banner status="success">
              Settings saved successfully!
            </Banner>
          )}
          <Card sectioned>
            <FormLayout>
              <TextField
                label="Minimum Products"
                type="number"
                value={settings.minProducts}
                onChange={handleChange('minProducts')}
                helpText="Minimum number of products required in cart to apply discount"
              />
              <TextField
                label="Discount Percentage"
                type="number"
                value={settings.discountPercentage}
                onChange={handleChange('discountPercentage')}
                helpText="Percentage discount to apply when minimum products requirement is met"
                suffix="%"
              />
              <Button
                primary
                loading={status.loading}
                onClick={handleSubmit}
              >
                Save Settings
              </Button>
            </FormLayout>
          </Card>
        </Layout.Section>
      </Layout>
    </Page>
  );
}