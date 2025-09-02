import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting property create flow verification...');
    
    // Navigate to login page
    await page.goto('http://localhost:8000/login');
    console.log('Navigated to login page');

    // Fill in admin credentials and login
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    
    // Submit the form and wait for response
    await page.click('button[type="submit"]');
    await page.waitForLoadState('networkidle');
    console.log('Login attempted');
    
    // Navigate directly to admin properties page
    await page.goto('http://localhost:8000/admin/properties');
    console.log('Navigated to admin properties page');
    await page.waitForTimeout(2000);

    // Look for and click the "Create New Property" button
    try {
      await page.waitForSelector('a[href="/admin/properties/create"]', { timeout: 5000 });
      await page.click('a[href="/admin/properties/create"]');
      console.log('Clicked Create New Property button');
    } catch (error) {
      console.log('Create button not found, navigating directly...');
      await page.goto('http://localhost:8000/admin/properties/create');
    }
    
    console.log('Navigated to create property form');

    // Take screenshot of the blank form
    await page.screenshot({ path: 'property_create_form.png', fullPage: true });
    console.log('Screenshot saved as property_create_form.png');

    // Debug: Check what's on the page
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Check if we can find the form
    const titleExists = await page.locator('#title').count();
    console.log('Title field count:', titleExists);
    
    if (titleExists === 0) {
      console.log('Form not found, checking page content...');
      const bodyText = await page.locator('body').innerText();
      console.log('Page content preview:', bodyText.substring(0, 500));
      return; // Exit early if form not found
    }

    // Fill out all the fields of the form
    const propertyData = {
      title: 'Test Property from Automation',
      description: 'This is a test property created by the Playwright automation script. It has all the amenities you could want.',
      price: '450000',
      location: '123 Test Street, Automation City, AC 12345',
      type: 'sale',
      featured: true
    };

    // Fill form fields using ID selectors
    await page.fill('#title', propertyData.title);
    console.log('Filled title');
    
    await page.fill('#description', propertyData.description);
    console.log('Filled description');
    
    await page.fill('#price', propertyData.price);
    console.log('Filled price');
    
    await page.fill('#location', propertyData.location);
    console.log('Filled location');
    
    await page.selectOption('#type', propertyData.type);
    console.log('Selected type');
    
    if (propertyData.featured) {
      await page.check('#featured');
      console.log('Checked featured checkbox');
    }

    // Wait a moment for Livewire to process
    await page.waitForTimeout(1000);

    // Click Save button
    await page.click('button[type="submit"]');
    console.log('Clicked Save Property button');

    // Wait for redirect or success message
    try {
      await page.waitForURL('**/admin/properties', { timeout: 10000 });
      console.log('Successfully redirected to admin properties list');
    } catch (error) {
      console.log('Redirect timeout, checking current page...');
      console.log('Current URL:', page.url());
    }

    // Wait for the page to load
    await page.waitForTimeout(2000);

    // Take final screenshot showing the property list with new property
    await page.screenshot({ path: 'property_create_success.png', fullPage: true });
    console.log('Screenshot saved as property_create_success.png');

    // Check if our test property appears in the list
    const propertyExists = await page.locator('text=' + propertyData.title).isVisible();
    if (propertyExists) {
      console.log('✅ Test property found in the list!');
    } else {
      console.log('⚠️  Test property not visible in the list');
    }

    // Check for success message
    const successMessage = await page.locator('text=Property created successfully').isVisible();
    if (successMessage) {
      console.log('✅ Success message displayed');
    } else {
      console.log('⚠️  No success message found');
    }

    console.log('✅ Property create flow verification completed');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'property_create_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();