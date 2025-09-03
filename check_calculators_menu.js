import { chromium } from 'playwright';

async function checkCalculatorsMenu() {
  console.log('🧮 Testing Calculators Dropdown Menu...');
  console.log('=====================================');
  
  const browser = await chromium.launch({ headless: false });
  const context = await browser.newContext();
  const page = await context.newPage();
  
  try {
    // Navigate to the local homepage
    console.log('📍 Navigating to homepage...');
    await page.goto('http://localhost:8000/');
    
    // Wait for the page to load completely
    await page.waitForLoadState('networkidle');
    
    // Wait for the Calculators button to be visible
    await page.waitForSelector('button:has-text("Calculators")', { timeout: 10000 });
    
    console.log('✅ Homepage loaded successfully');
    
    // Check if Calculators menu item exists
    const calculatorsButton = page.locator('button:has-text("Calculators")');
    const isVisible = await calculatorsButton.isVisible();
    
    if (!isVisible) {
      console.log('❌ Calculators button not found in navigation');
      return;
    }
    
    console.log('✅ Calculators button found in navigation');
    
    // Hover over the Calculators menu to reveal dropdown
    console.log('🖱️  Hovering over Calculators menu...');
    await calculatorsButton.hover();
    
    // Wait a moment for the dropdown to appear
    await page.waitForTimeout(500);
    
    // Check if dropdown is visible
    const dropdownPanel = page.locator('div[role="menu"]').first();
    const dropdownVisible = await dropdownPanel.isVisible();
    
    if (!dropdownVisible) {
      console.log('⚠️  Dropdown not visible, trying click instead...');
      await calculatorsButton.click();
      await page.waitForTimeout(500);
    }
    
    // Verify all three calculator links are present
    const expectedCalculators = [
      { href: '/mortgage-calculator', text: 'Mortgage Calculator' },
      { href: '/affordability-calculator', text: 'Affordability Calculator' },  
      { href: '/refinance-calculator', text: 'Refinance Calculator' }
    ];
    
    console.log('🔍 Checking for calculator links...');
    
    let allLinksFound = true;
    for (const calc of expectedCalculators) {
      const link = page.locator(`a[href="${calc.href}"]`);
      const linkExists = await link.isVisible();
      
      if (linkExists) {
        console.log(`✅ ${calc.text} link found`);
        
        // Verify the link text and description
        const linkText = await link.locator('p.font-medium').textContent();
        if (linkText && linkText.includes(calc.text)) {
          console.log(`✅ ${calc.text} has correct text`);
        } else {
          console.log(`⚠️  ${calc.text} text might be incorrect`);
        }
      } else {
        console.log(`❌ ${calc.text} link NOT found`);
        allLinksFound = false;
      }
    }
    
    if (allLinksFound) {
      console.log('🎉 All calculator links found successfully!');
    }
    
    // Test clicking on one of the calculators
    console.log('🧪 Testing click navigation to Mortgage Calculator...');
    const mortgageLink = page.locator('a[href="/mortgage-calculator"]');
    
    if (await mortgageLink.isVisible()) {
      await mortgageLink.click();
      await page.waitForLoadState('networkidle');
      
      // Check if we successfully navigated
      const currentUrl = page.url();
      if (currentUrl.includes('/mortgage-calculator')) {
        console.log('✅ Successfully navigated to Mortgage Calculator');
      } else {
        console.log('❌ Navigation to Mortgage Calculator failed');
      }
      
      // Navigate back to homepage for screenshot
      await page.goto('http://localhost:8000/');
      await page.waitForLoadState('networkidle');
      
      // Hover over menu again for screenshot
      await page.locator('button:has-text("Calculators")').hover();
      await page.waitForTimeout(500);
    }
    
    // Take a screenshot showing the dropdown menu
    console.log('📸 Taking screenshot...');
    await page.screenshot({ 
      path: 'calculators_menu_success.png',
      fullPage: false 
    });
    
    console.log('✅ Screenshot saved as calculators_menu_success.png');
    console.log('🎯 Calculators menu verification completed successfully!');
    
  } catch (error) {
    console.error('❌ Error during verification:', error.message);
    
    // Take a screenshot of the error state
    try {
      await page.screenshot({ 
        path: 'calculators_menu_error.png',
        fullPage: false 
      });
      console.log('📸 Error screenshot saved as calculators_menu_error.png');
    } catch (screenshotError) {
      console.error('Failed to take error screenshot:', screenshotError.message);
    }
  } finally {
    await browser.close();
    console.log('🏁 Browser closed');
  }
}

// Run the verification
checkCalculatorsMenu().catch(console.error);