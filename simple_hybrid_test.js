import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 1000 });
  const page = await browser.newPage();
  
  try {
    console.log('🚀 Testing hybrid installation wizard...');
    
    // Navigate to install page directly
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    
    console.log('✅ Installation wizard loaded');
    
    // Take screenshot
    await page.screenshot({ path: 'hybrid_step1.png', fullPage: true });
    
    // Check if step 1 is displayed
    const title = await page.locator('h2').textContent();
    console.log(`📋 Current step: ${title}`);
    
    // Fill step 1 form
    await page.fill('#agencyName', 'Test Hybrid Agency');
    await page.fill('#agencyEmail', 'test@hybrid.com');
    
    console.log('✏️ Form filled');
    
    // Click Next Step
    await page.click('button[name="action"][value="next"]');
    
    // Wait for navigation
    await page.waitForTimeout(3000);
    await page.waitForLoadState('networkidle');
    
    // Check if we advanced to step 2
    const newTitle = await page.locator('h2').textContent();
    console.log(`📋 New step: ${newTitle}`);
    
    if (newTitle && newTitle.includes('Branding')) {
      console.log('🎉 SUCCESS: Advanced to step 2!');
    } else {
      console.log('❌ Still on step 1');
    }
    
    // Take final screenshot
    await page.screenshot({ path: 'hybrid_result.png', fullPage: true });
    
  } catch (error) {
    console.error('❌ Error:', error.message);
    await page.screenshot({ path: 'hybrid_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();