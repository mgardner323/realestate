import { chromium } from 'playwright';
import fs from 'fs';

(async () => {
  // Clean up installation file
  if (fs.existsSync('.installed')) {
    fs.unlinkSync('.installed');
  }

  const browser = await chromium.launch({ headless: false, slowMo: 800 });
  const page = await browser.newPage();
  
  try {
    console.log('🚀 Complete End-to-End Installation Test');
    
    // Step 1: Start installation
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    console.log('✅ Step 1 loaded');
    
    // Fill step 1
    await page.fill('#agencyName', 'Complete Test Realty');
    await page.fill('#agencyEmail', 'complete@test.com');
    await page.fill('#agencyPhone', '(555) 777-8888');
    await page.fill('#agencyAddress', '456 Complete Avenue, Success City, SC 54321');
    
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    console.log('✅ Advanced to Step 2');
    
    // Fill step 2
    await page.fill('#seoTitle', 'Complete Real Estate Success');
    await page.fill('#seoDescription', 'The most complete real estate platform with hybrid architecture.');
    await page.fill('#brandPrimaryColorText', '#FF6B35');
    await page.fill('#brandSecondaryColorText', '#F7931E');
    
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    console.log('✅ Advanced to Step 3');
    
    // Fill step 3 (admin account)
    await page.fill('#adminName', 'Complete Admin');
    await page.fill('#adminEmail', 'admin@complete.com');
    await page.fill('#adminPassword', 'completesuccess123');
    await page.fill('#adminPasswordConfirmation', 'completesuccess123');
    
    console.log('🎯 Completing installation...');
    
    // Complete installation
    await page.click('button[name="action"][value="finish"]');
    
    // Wait for redirect to login
    await page.waitForTimeout(5000);
    await page.waitForLoadState('networkidle');
    
    // Verify successful completion
    const finalUrl = page.url();
    console.log(`📍 Final URL: ${finalUrl}`);
    
    if (finalUrl.includes('/login')) {
      console.log('🎉 SUCCESS: Redirected to login page!');
      
      // Check success message
      const successMessage = await page.locator('.bg-green-50, [class*="success"]').textContent().catch(() => null);
      if (successMessage) {
        console.log(`✅ Success message: ${successMessage}`);
      }
      
      // Verify .installed file was created
      if (fs.existsSync('.installed')) {
        console.log('✅ .installed file created');
        const installedData = JSON.parse(fs.readFileSync('.installed', 'utf8'));
        console.log(`📋 Installation completed at: ${installedData.installed_at}`);
        console.log(`📋 Admin email: ${installedData.admin_email}`);
      } else {
        console.log('❌ .installed file not found');
      }
      
      // Test login with created admin account
      console.log('🔐 Testing admin login...');
      await page.fill('input[type="email"]', 'admin@complete.com');
      await page.fill('input[type="password"]', 'completesuccess123');
      await page.click('button[type="submit"]');
      
      await page.waitForTimeout(3000);
      
      if (page.url().includes('/admin') || !page.url().includes('/login')) {
        console.log('🎉 COMPLETE SUCCESS: Admin login works!');
      } else {
        console.log('⚠️ Admin login may need verification');
      }
      
    } else {
      console.log('❌ Installation may have failed - not redirected to login');
    }
    
    console.log('📸 Taking final screenshot...');
    await page.screenshot({ path: 'complete_installation_success.png', fullPage: true });
    
  } catch (error) {
    console.error('❌ Error during complete test:', error.message);
    await page.screenshot({ path: 'complete_installation_error.png', fullPage: true });
  } finally {
    await browser.close();
    console.log('🏁 Complete installation test finished!');
  }
})();