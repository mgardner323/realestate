import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting Category Manager verification...');
    
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
    
    // Navigate directly to category manager page
    await page.goto('http://localhost:8000/admin/blog/categories');
    console.log('Navigated to category manager page');
    await page.waitForTimeout(2000); // Wait for page to load

    // Debug: Check what's on the page
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Check if we can find category management elements
    const categoryFormExists = await page.locator('input[wire\\:model="name"]').count();
    console.log('Category form input count:', categoryFormExists);
    
    // Check for the category table
    const categoryTableExists = await page.locator('table').count();
    console.log('Category table count:', categoryTableExists);
    
    // Check for the page header
    const headerExists = await page.locator('text=Manage Blog Categories').count();
    console.log('Header "Manage Blog Categories" count:', headerExists);
    
    // Check for form sections
    const createFormExists = await page.locator('text=Create New Category').count();
    console.log('Create form section count:', createFormExists);
    
    const existingCategoriesExists = await page.locator('text=Existing Categories').count();
    console.log('Existing Categories section count:', existingCategoriesExists);
    
    if (categoryFormExists > 0 && categoryTableExists > 0) {
      console.log('✅ Category Manager interface found on the page!');
      
      // Try to interact with the form
      try {
        await page.fill('input[wire\\:model="name"]', 'Test Category');
        console.log('✅ Successfully filled category name input');
        
        // Look for the Add Category button
        const addButton = await page.locator('button[type="submit"]');
        const addButtonText = await addButton.innerText();
        console.log('Add button text:', addButtonText);
        
        if (addButtonText.includes('Add Category')) {
          console.log('✅ Add Category button found and ready for interaction');
        }
      } catch (error) {
        console.log('⚠️  Could not interact with category form:', error.message);
      }
    } else {
      console.log('❌ Category Manager interface not found');
      
      // Check page content for debugging
      const bodyText = await page.locator('body').innerText();
      console.log('Page content preview:', bodyText.substring(0, 500));
    }

    // Take screenshot
    await page.screenshot({ path: 'category_manager.png', fullPage: true });
    console.log('Screenshot saved as category_manager.png');

    console.log('✅ Category Manager verification completed');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'category_manager_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();