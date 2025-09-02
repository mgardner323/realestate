import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 1000 });
  const page = await browser.newPage();
  
  try {
    console.log('🔍 Debugging final installation step...');
    
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    
    // Quick navigation to final step
    // Step 1
    await page.fill('#agencyName', 'Debug Agency');
    await page.fill('#agencyEmail', 'debug@test.com');
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    
    // Step 2
    await page.fill('#seoTitle', 'Debug Title');
    await page.fill('#seoDescription', 'Debug description for testing.');
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    
    console.log('✅ Reached step 3');
    
    // Step 3 - Check what we have
    const currentTitle = await page.locator('h2').textContent();
    console.log(`📋 Current step: ${currentTitle}`);
    
    // Fill admin form carefully
    await page.fill('#adminName', 'Debug Admin');
    await page.fill('#adminEmail', 'debug-admin@test.com');
    await page.fill('#adminPassword', 'debugpassword123');
    await page.fill('#adminPasswordConfirmation', 'debugpassword123');
    
    console.log('✏️ Admin form filled');
    
    // Before clicking finish, take screenshot
    await page.screenshot({ path: 'before_finish.png', fullPage: true });
    
    // Click finish and wait for response
    console.log('🎯 Clicking finish...');
    await page.click('button[name="action"][value="finish"]');
    
    // Wait and check for any changes
    await page.waitForTimeout(5000);
    
    // Check current URL and any error messages
    const currentUrl = page.url();
    console.log(`📍 URL after finish: ${currentUrl}`);
    
    // Look for error messages
    const errorMessages = await page.locator('.text-red-500, .bg-red-50, .text-red-700').allTextContents();
    if (errorMessages.length > 0) {
      console.log('❌ Error messages found:');
      errorMessages.forEach(msg => console.log(`   - ${msg}`));
    } else {
      console.log('✅ No error messages visible');
    }
    
    // Check for success messages
    const successMessages = await page.locator('.text-green-500, .bg-green-50, .text-green-700').allTextContents();
    if (successMessages.length > 0) {
      console.log('✅ Success messages found:');
      successMessages.forEach(msg => console.log(`   - ${msg}`));
    }
    
    // Take final screenshot
    await page.screenshot({ path: 'after_finish.png', fullPage: true });
    
  } catch (error) {
    console.error('❌ Debug error:', error.message);
    await page.screenshot({ path: 'debug_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();