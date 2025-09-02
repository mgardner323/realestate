import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting Trix Rich Text Editor verification...');
    
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
    
    // Navigate directly to create blog post page
    await page.goto('http://localhost:8000/admin/blog/create');
    console.log('Navigated to create post page');
    await page.waitForTimeout(3000); // Wait for assets to load

    // Debug: Check what's on the page
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Check if we can find the Trix editor
    const trixEditorExists = await page.locator('trix-editor').count();
    console.log('Trix editor count:', trixEditorExists);
    
    // Check for Trix toolbar
    const trixToolbarExists = await page.locator('trix-toolbar').count();
    console.log('Trix toolbar count:', trixToolbarExists);
    
    // Alternative check for Trix elements
    const trixElements = await page.locator('[data-trix-editor], .trix-content, trix-editor').count();
    console.log('Total Trix-related elements:', trixElements);
    
    if (trixEditorExists > 0 || trixToolbarExists > 0) {
      console.log('✅ Trix Rich Text Editor found on the page!');
      
      // Try to interact with the editor
      try {
        await page.locator('trix-editor').click();
        await page.locator('trix-editor').type('Testing Rich Text Editor functionality!');
        console.log('✅ Successfully typed in the Trix editor');
      } catch (error) {
        console.log('⚠️  Could not interact with Trix editor:', error.message);
      }
    } else {
      console.log('❌ Trix Rich Text Editor not found');
      
      // Check page content for debugging
      const bodyText = await page.locator('body').innerText();
      console.log('Page content preview:', bodyText.substring(0, 500));
      
      // Check if the component is loaded but not recognized
      const xTrixEditor = await page.locator('x-trix-editor').count();
      console.log('x-trix-editor component count:', xTrixEditor);
      
      // Check for any input fields as fallback
      const textareas = await page.locator('textarea').count();
      console.log('Textarea count:', textareas);
    }

    // Take screenshot regardless of success/failure
    await page.screenshot({ path: 'rich_text_editor_visible.png', fullPage: true });
    console.log('Screenshot saved as rich_text_editor_visible.png');

    console.log('✅ Rich Text Editor verification completed');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'rich_text_editor_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();