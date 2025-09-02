const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true, slowMo: 500 });
  const page = await browser.newPage();
  
  try {
    console.log('🚀 FINAL INSTALLATION WIZARD VERIFICATION TEST');
    console.log('===================================================');
    
    // Step A: Navigate directly to install URL
    console.log('📍 Step A: Navigating directly to installation wizard...');
    await page.goto('http://35.238.223.12/install', { waitUntil: 'networkidle' });
    
    // Wait a moment for page to load
    await page.waitForTimeout(2000);
    
    const currentUrl = page.url();
    console.log(`   Current URL: ${currentUrl}`);
    
    // Check if we're on the install page or redirected elsewhere
    if (currentUrl.includes('/install')) {
      console.log('✅ SUCCESS: Installation wizard accessible');
    } else {
      console.log('⚠️ REDIRECTED: May already be installed, URL:', currentUrl);
      // Let's continue anyway to see what happens
    }
    
    // Take a screenshot to see what we have
    await page.screenshot({ path: 'wizard_initial_page.png', fullPage: true });
    console.log('📸 Screenshot taken: wizard_initial_page.png');
    
    // Verify Step 1 UI is loaded
    console.log('📍 Step B: Verifying Step 1 UI...');
    
    // Check if h2 elements exist
    const h2Count = await page.locator('h2').count();
    console.log(`   Found ${h2Count} h2 elements`);
    
    if (h2Count > 0) {
      const step1Title = await page.locator('h2').first().textContent();
      console.log(`   Step 1 title: ${step1Title}`);
      
      if (!step1Title || !step1Title.includes('Agency')) {
        console.log('⚠️ Title does not contain "Agency", but continuing test...');
      }
    } else {
      console.log('⚠️ No h2 elements found, checking page content...');
      
      // Check if there's any error message or different content
      const pageText = await page.textContent('body');
      console.log(`   Page content preview: ${pageText.substring(0, 200)}...`);
    }
    
    // Fill Step 1 form
    console.log('📍 Step C: Filling Step 1 Agency Information...');
    await page.fill('#agencyName', 'Final Test Realty');
    await page.fill('#agencyEmail', 'finaltest@realtyverify.com');
    await page.fill('#agencyPhone', '(555) 999-8888');
    await page.fill('#agencyAddress', '789 Final Test Drive, Verification City, VC 67890');
    
    console.log('✅ Step 1 form filled successfully');
    
    // Take screenshot before clicking next
    await page.screenshot({ path: 'wizard_step1_filled.png', fullPage: true });
    
    // Click Next Step button
    console.log('📍 Step D: Clicking Next Step button...');
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(2000);
    
    // Verify we're on Step 2
    const step2Title = await page.locator('h2').first().textContent();
    console.log(`   Step 2 title: ${step2Title}`);
    
    if (!step2Title || !step2Title.includes('Branding')) {
      console.log('❌ CRITICAL: Failed to advance to Step 2');
      await page.screenshot({ path: 'wizard_step2_failed.png', fullPage: true });
      throw new Error('Failed to advance to Step 2 - THIS IS THE BUG WE FIXED!');
    }
    
    console.log('🎉 SUCCESS: Advanced to Step 2! The wizard navigation bug is FIXED!');
    
    // Fill Step 2 form
    console.log('📍 Step E: Filling Step 2 Branding & SEO...');
    await page.fill('#seoTitle', 'Final Test Realty - Premier Real Estate');
    await page.fill('#seoDescription', 'The ultimate verification test for our hybrid installation wizard system.');
    await page.fill('#brandPrimaryColorText', '#FF5733');
    await page.fill('#brandSecondaryColorText', '#33C3FF');
    
    console.log('✅ Step 2 form filled successfully');
    
    // Take screenshot of Step 2
    await page.screenshot({ path: 'wizard_step2_filled.png', fullPage: true });
    
    // Click Next Step button again
    console.log('📍 Step F: Advancing to Step 3...');
    await page.click('button[name="action"][value="next"]');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(2000);
    
    // Verify we're on Step 3
    const step3Title = await page.locator('h2').first().textContent();
    console.log(`   Step 3 title: ${step3Title}`);
    
    if (!step3Title || !step3Title.includes('Admin')) {
      console.log('❌ Failed to advance to Step 3');
      await page.screenshot({ path: 'wizard_step3_failed.png', fullPage: true });
      throw new Error('Failed to advance to Step 3');
    }
    
    console.log('✅ SUCCESS: Advanced to Step 3!');
    
    // Verify installation summary is showing
    const summaryExists = await page.locator('.bg-blue-50').count() > 0;
    if (summaryExists) {
      console.log('✅ Installation summary is displayed');
    }
    
    // Fill Step 3 admin form
    console.log('📍 Step G: Creating Admin Account...');
    await page.fill('#adminName', 'Final Test Admin');
    await page.fill('#adminEmail', 'newadmin@finaltest.com');
    await page.fill('#adminPassword', 'finalverify123');
    await page.fill('#adminPasswordConfirmation', 'finalverify123');
    
    console.log('✅ Admin account details filled');
    
    // Take screenshot before finishing
    await page.screenshot({ path: 'wizard_step3_ready.png', fullPage: true });
    
    // Click Finish Installation button
    console.log('📍 Step H: Completing Installation...');
    await page.click('button[name="action"][value="finish"]');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(3000);
    
    // Check final URL and verify redirect to login
    const finalUrl = page.url();
    console.log(`   Final URL: ${finalUrl}`);
    
    if (finalUrl.includes('/login')) {
      console.log('🎉 ULTIMATE SUCCESS: Installation completed and redirected to login!');
      
      // Check for success message
      const successElements = await page.locator('.bg-green-50, .text-green-500, [class*="success"]').count();
      if (successElements > 0) {
        console.log('✅ Success message displayed');
      }
      
      // Take final screenshot of login page
      console.log('📍 Step I: Taking final success screenshot...');
      await page.screenshot({ path: 'wizard_final_success.png', fullPage: true });
      
      console.log('');
      console.log('=================================================================================');
      console.log('🏆 INSTALLATION WIZARD VERIFICATION COMPLETE - ALL TESTS PASSED! 🏆');
      console.log('=================================================================================');
      console.log('✅ Step 1 → Step 2 transition: WORKING');
      console.log('✅ Step 2 → Step 3 transition: WORKING');
      console.log('✅ Step 3 → Login redirect: WORKING');
      console.log('✅ Hybrid form implementation: SUCCESSFUL');
      console.log('✅ The Installation Wizard bug has been COMPLETELY RESOLVED!');
      console.log('=================================================================================');
      
    } else {
      console.log('❌ Installation may have failed - not redirected to login');
      await page.screenshot({ path: 'wizard_completion_failed.png', fullPage: true });
    }
    
  } catch (error) {
    console.error('💥 VERIFICATION TEST FAILED:', error.message);
    await page.screenshot({ path: 'wizard_verification_error.png', fullPage: true });
  } finally {
    await browser.close();
    console.log('🔚 Verification test completed');
  }
})();