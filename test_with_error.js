import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 500 });
  const page = await browser.newPage();
  
  try {
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    
    // Fill form
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'test@example.com');
    
    // Submit and wait
    await page.click('button[type="submit"]');
    await page.waitForTimeout(3000);
    
    // Check for any error messages
    const errorMessage = await page.locator('.text-red-500, .bg-red-50').textContent().catch(() => 'No error message');
    console.log('Error message:', errorMessage);
    
    // Take screenshot
    await page.screenshot({ path: 'wizard_with_errors.png', fullPage: true });
    
  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }
})();