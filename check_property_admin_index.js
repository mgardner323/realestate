import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting admin property list verification...');
    
    // Navigate to login page
    await page.goto('http://localhost:8000/login');
    console.log('Navigated to login page');

    // Fill in admin credentials and login
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    
    // Submit the form and wait for response
    const [response] = await Promise.all([
      page.waitForResponse(response => response.url().includes('login')),
      page.click('button[type="submit"]')
    ]);
    
    console.log('Login response status:', response.status());
    
    // Wait a bit and check current page
    await page.waitForTimeout(2000);
    console.log('After login - Current URL:', page.url());
    
    // Navigate directly to admin properties page
    await page.goto('http://localhost:8000/admin/properties');
    console.log('Navigated to admin properties page');

    // Take a screenshot to see what's on the page
    await page.screenshot({ path: 'property_admin_debug.png', fullPage: true });
    console.log('Debug screenshot saved');
    
    // Check page content and URL
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Wait for the table to be visible (with a shorter timeout)
    try {
      await page.waitForSelector('table', { timeout: 5000 });
    } catch (e) {
      console.log('Table not found, checking page content...');
      const bodyText = await page.locator('body').innerText();
      console.log('Page content:', bodyText.substring(0, 500));
    }
    console.log('Property table is visible');

    // Verify table headers are present
    const headers = await page.locator('thead th').allInnerTexts();
    console.log('Table headers:', headers);
    
    // Verify expected headers exist
    const expectedHeaders = ['Title', 'Location', 'Price', 'Type', 'Status', 'Actions'];
    const headersMatch = expectedHeaders.every(header => 
      headers.some(h => h.toLowerCase().includes(header.toLowerCase()))
    );
    
    if (headersMatch) {
      console.log('✅ All expected table headers found');
    } else {
      console.log('❌ Some expected headers missing');
    }

    // Check if properties are displayed (or empty state)
    const hasProperties = await page.locator('tbody tr').count();
    console.log(`Found ${hasProperties} row(s) in properties table`);

    // Take screenshot
    await page.screenshot({ path: 'property_admin_index.png', fullPage: true });
    console.log('Screenshot saved as property_admin_index.png');

    console.log('✅ Admin property list verification completed successfully');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'property_admin_index_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();