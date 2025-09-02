import { chromium } from 'playwright';
import fs from 'fs';

(async () => {
  // Remove .installed file if it exists
  const installedPath = '.installed';
  if (fs.existsSync(installedPath)) {
    fs.unlinkSync(installedPath);
  }

  const browser = await chromium.launch({ headless: false });
  const page = await browser.newPage();
  
  try {
    console.log('🚀 Starting Installation Wizard Debug Test...');
    
    // Navigate to homepage (should redirect to install)
    console.log('📍 Navigating to homepage...');
    await page.goto('http://localhost:8000/');
    await page.waitForLoadState('networkidle');
    
    // Verify redirect to install page
    const currentUrl = page.url();
    console.log(`📍 Current URL: ${currentUrl}`);
    
    if (!currentUrl.includes('/install')) {
      throw new Error('❌ Did not redirect to install page');
    }
    
    console.log('✅ Successfully redirected to installation wizard');
    
    // Take initial screenshot
    await page.screenshot({ path: 'wizard_step_1.png', fullPage: true });
    console.log('📸 Screenshot taken: wizard_step_1.png');
    
    // Verify step 1 elements
    const heading = await page.locator('h1').textContent();
    console.log(`📝 Main heading: ${heading}`);
    
    const step1Fields = {
      agencyName: await page.locator('#agencyName').isVisible(),
      agencyEmail: await page.locator('#agencyEmail').isVisible(),
      agencyPhone: await page.locator('#agencyPhone').isVisible(),
      agencyAddress: await page.locator('#agencyAddress').isVisible()
    };
    
    console.log('📋 Step 1 fields visibility:', step1Fields);
    
    // Fill step 1 form
    console.log('✏️  Filling step 1 form...');
    await page.fill('#agencyName', 'Debug Test Agency');
    await page.fill('#agencyEmail', 'debug@test.com');
    await page.fill('#agencyPhone', '(555) 999-8888');
    await page.fill('#agencyAddress', '123 Debug Street, Test City, TC 12345');
    
    console.log('✅ Step 1 form filled successfully');
    
    // Submit step 1
    console.log('🚀 Submitting step 1...');
    await page.click('button[type="submit"]:has-text("Next Step")');
    
    // Wait for step 2 to load
    await page.waitForTimeout(3000);
    await page.waitForLoadState('networkidle');
    
    // Take screenshot of current state
    await page.screenshot({ path: 'wizard_debug_step.png', fullPage: true });
    console.log('📸 Debug screenshot taken: wizard_debug_step.png');
    
    // Check what step we're on now
    const step2Title = await page.locator('h2').textContent();
    console.log(`📝 Current step title: ${step2Title}`);
    
    // Check for step 2 fields
    const step2Fields = {
      seoTitle: await page.locator('#seoTitle').isVisible(),
      seoDescription: await page.locator('#seoDescription').isVisible(),
      brandPrimaryColor: await page.locator('#brandPrimaryColor').isVisible(),
      brandSecondaryColor: await page.locator('#brandSecondaryColor').isVisible()
    };
    
    console.log('📋 Step 2 fields visibility:', step2Fields);
    
    if (step2Fields.seoTitle) {
      console.log('🎉 SUCCESS: Advanced to Step 2!');
      
      // Fill step 2 form
      console.log('✏️  Filling step 2 form...');
      await page.fill('#seoTitle', 'Debug Real Estate Platform');
      await page.fill('#seoDescription', 'A debugging test for our real estate platform.');
      await page.fill('input[type="text"][wire\\:model="brandPrimaryColor"]', '#FF6B6B');
      await page.fill('input[type="text"][wire\\:model="brandSecondaryColor"]', '#4ECDC4');
      
      // Submit step 2
      console.log('🚀 Submitting step 2...');
      await page.click('button[type="submit"]:has-text("Next Step")');
      
      await page.waitForTimeout(3000);
      await page.waitForLoadState('networkidle');
      
      // Take screenshot of step 3
      await page.screenshot({ path: 'wizard_step_3.png', fullPage: true });
      console.log('📸 Screenshot taken: wizard_step_3.png');
      
      const step3Title = await page.locator('h2').textContent();
      console.log(`📝 Step 3 title: ${step3Title}`);
      
      if (step3Title && step3Title.includes('Admin Account')) {
        console.log('🎉 SUCCESS: Advanced to Step 3!');
        console.log('✅ Installation wizard navigation is working perfectly!');
      }
    } else {
      console.log('❌ FAILED: Still on Step 1, did not advance');
    }
    
  } catch (error) {
    console.error('❌ Error during test:', error.message);
    await page.screenshot({ path: 'wizard_error.png', fullPage: true });
    console.log('📸 Error screenshot taken: wizard_error.png');
  } finally {
    await browser.close();
    console.log('🔚 Test completed');
  }
})();