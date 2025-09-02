import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 1000 });
  const page = await browser.newPage();
  
  // Enable console logging to see JavaScript debug messages
  page.on('console', msg => console.log('🖥️ BROWSER CONSOLE:', msg.text()));
  page.on('pageerror', err => console.log('❌ PAGE ERROR:', err.message));
  
  try {
    console.log('🚀 Testing Livewire JavaScript integration...');
    
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    
    // Wait a bit for JavaScript to initialize
    await page.waitForTimeout(2000);
    
    // Fill form
    await page.fill('#agencyName', 'Debug Test');
    await page.fill('#agencyEmail', 'debug@test.com');
    
    console.log('✏️  Form filled, clicking Next Step button...');
    
    // Click button and monitor network requests
    await Promise.all([
      page.waitForResponse(response => 
        response.url().includes('livewire') && response.status() < 400, 
        { timeout: 10000 }
      ).catch(() => console.log('🔍 No Livewire response detected')),
      page.click('button:has-text("Next Step")')
    ]);
    
    await page.waitForTimeout(3000);
    
    const currentTitle = await page.locator('h2').textContent();
    console.log(`📝 Final step title: ${currentTitle}`);
    
    // Take screenshot
    await page.screenshot({ path: 'console_debug.png', fullPage: true });
    
  } catch (error) {
    console.error('❌ Test error:', error.message);
  } finally {
    await browser.close();
  }
})();