import { chromium } from 'playwright';
import fs from 'fs';

(async () => {
  // Remove .installed file if it exists
  if (fs.existsSync('.installed')) {
    fs.unlinkSync('.installed');
  }

  const browser = await chromium.launch({ headless: false });
  const page = await browser.newPage();
  
  try {
    console.log('🚀 Testing fixed installation wizard...');
    
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    
    // Fill step 1 form
    await page.fill('#agencyName', 'Fixed Test Agency');
    await page.fill('#agencyEmail', 'fixed@test.com');
    
    console.log('✏️  Form filled, clicking Next Step button...');
    
    // Click the Next Step button (now with wire:click)
    await page.click('button:has-text("Next Step")');
    
    // Wait for step 2 to load
    await page.waitForTimeout(3000);
    await page.waitForLoadState('networkidle');
    
    // Take screenshot of result
    await page.screenshot({ path: 'wizard_debug_step.png', fullPage: true });
    
    // Check what step we're on now
    const step2Title = await page.locator('h2').textContent();
    console.log(`📝 Current step title: ${step2Title}`);
    
    // Check for step 2 fields
    const seoTitleVisible = await page.locator('#seoTitle').isVisible();
    
    if (seoTitleVisible) {
      console.log('🎉 SUCCESS: Advanced to Step 2!');
      console.log('✅ Installation wizard is now working correctly!');
    } else {
      console.log('❌ Still on Step 1');
    }
    
  } catch (error) {
    console.error('❌ Error:', error.message);
    await page.screenshot({ path: 'wizard_error_final.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();