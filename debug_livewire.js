import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 1000 });
  const page = await browser.newPage();
  
  // Enable console logging to see any JavaScript errors
  page.on('console', msg => console.log('BROWSER:', msg.text()));
  page.on('pageerror', err => console.log('PAGE ERROR:', err.message));
  
  try {
    await page.goto('http://localhost:8000/install');
    await page.waitForLoadState('networkidle');
    
    console.log('📍 Page loaded, checking Livewire state...');
    
    // Check if Livewire is loaded
    const livewireLoaded = await page.evaluate(() => {
      return typeof window.Livewire !== 'undefined';
    });
    
    console.log('🔌 Livewire loaded:', livewireLoaded);
    
    // Get current step from page
    const currentStep = await page.evaluate(() => {
      const component = window.Livewire?.find('[wire\\:id]');
      return component?.get('currentStep') || 'unknown';
    });
    
    console.log('📊 Current step:', currentStep);
    
    // Fill form and try clicking with more detailed debugging
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'test@example.com');
    
    console.log('✏️  Form filled, clicking submit...');
    
    // Click and wait for network activity
    await Promise.all([
      page.waitForResponse(response => response.url().includes('livewire')),
      page.click('button[type="submit"]')
    ]);
    
    console.log('📡 Livewire request completed');
    
    await page.waitForTimeout(2000);
    
    // Check current step again
    const newStep = await page.evaluate(() => {
      const component = window.Livewire?.find('[wire\\:id]');
      return component?.get('currentStep') || 'unknown';
    });
    
    console.log('📊 New step:', newStep);
    
    // Take final screenshot
    await page.screenshot({ path: 'livewire_debug.png', fullPage: true });
    
  } catch (error) {
    console.error('❌ Error:', error.message);
  } finally {
    await browser.close();
  }
})();