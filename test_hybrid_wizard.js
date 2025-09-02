import { chromium } from 'playwright';
import fs from 'fs';

(async () => {
  // Clean up any existing installation file
  if (fs.existsSync('.installed')) {
    fs.unlinkSync('.installed');
  }

  const browser = await chromium.launch({ headless: false, slowMo: 500 });
  const page = await browser.newPage();
  
  try {
    console.log('🚀 Testing Hybrid Installation Wizard...');
    
    // Test 1: Navigate to homepage (should redirect to install)
    await page.goto('http://localhost:8000/');
    await page.waitForLoadState('networkidle');
    
    console.log(`📍 Current URL: ${page.url()}`);
    
    if (!page.url().includes('/install')) {
      throw new Error('Did not redirect to install page');
    }
    
    console.log('✅ Successfully redirected to installation wizard');
    
    // Test 2: Check step 1 UI
    await expect(page.locator('h1')).toContainText('Real Estate Platform');
    await expect(page.locator('h2')).toContainText('Agency Information');
    
    console.log('✅ Step 1 UI loaded correctly');
    
    // Test 3: Fill and submit step 1
    await page.fill('#agencyName', 'Hybrid Test Agency');
    await page.fill('#agencyEmail', 'hybrid@test.com');
    await page.fill('#agencyPhone', '(555) 888-9999');
    await page.fill('#agencyAddress', '123 Hybrid Street, Test City, TC 12345');
    
    console.log('✏️ Step 1 form filled');
    
    // Submit step 1
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    
    // Test 4: Verify step 2
    await expect(page.locator('h2')).toContainText('Branding & SEO');
    console.log('🎉 SUCCESS: Advanced to Step 2!');
    
    // Test 5: Fill and submit step 2
    await page.fill('#seoTitle', 'Hybrid Real Estate Platform');
    await page.fill('#seoDescription', 'A revolutionary hybrid approach to real estate.');
    
    console.log('✏️ Step 2 form filled');
    
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    
    // Test 6: Verify step 3
    await expect(page.locator('h2')).toContainText('Admin Account');
    console.log('🎉 SUCCESS: Advanced to Step 3!');
    
    // Test 7: Check installation summary
    await expect(page.locator('.bg-blue-50')).toContainText('Hybrid Test Agency');
    await expect(page.locator('.bg-blue-50')).toContainText('hybrid@test.com');
    console.log('✅ Installation summary displays correctly');
    
    // Test 8: Fill admin form
    await page.fill('#adminName', 'Hybrid Admin');
    await page.fill('#adminEmail', 'admin@hybrid.com');
    await page.fill('#adminPassword', 'hybridpassword123');
    await page.fill('#adminPasswordConfirmation', 'hybridpassword123');
    
    console.log('✏️ Step 3 (admin) form filled');
    
    // Test 9: Complete installation
    await page.click('button[name="action"][value="finish"]');
    await page.waitForLoadState('networkidle');
    
    // Test 10: Verify redirect to login
    if (page.url().includes('/login')) {
      console.log('🎉 SUCCESS: Installation completed and redirected to login!');
      
      // Check if .installed file was created
      if (fs.existsSync('.installed')) {
        console.log('✅ .installed file created successfully');
        const installedData = JSON.parse(fs.readFileSync('.installed', 'utf8'));
        console.log('📋 Installation data:', installedData);
      } else {
        console.log('❌ .installed file not found');
      }
    } else {
      console.log('❌ Did not redirect to login page');
      console.log('📍 Current URL:', page.url());
    }
    
    // Take final screenshot
    await page.screenshot({ path: 'hybrid_wizard_success.png', fullPage: true });
    console.log('📸 Final screenshot taken');
    
  } catch (error) {
    console.error('❌ Test failed:', error.message);
    await page.screenshot({ path: 'hybrid_wizard_error.png', fullPage: true });
  } finally {
    await browser.close();
    console.log('🔚 Test completed');
  }
})();

// Helper function for expect
async function expect(locator) {
  return {
    toContainText: async (text) => {
      const content = await locator.textContent();
      if (!content || !content.includes(text)) {
        throw new Error(`Expected "${text}" but got "${content}"`);
      }
    }
  };
}