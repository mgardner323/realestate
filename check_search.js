import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    // Navigate to the properties page
    await page.goto('http://localhost:8000/properties');
    
    // Wait for the page to load
    await page.waitForLoadState('networkidle');
    
    // Fill in the Min Price input with a high value to narrow results
    await page.fill('#minPrice', '1500000');
    
    // Wait for the results to update (Livewire should update automatically)
    await page.waitForTimeout(2000);
    
    // Wait for network to be idle after the filter update
    await page.waitForLoadState('networkidle');
    
    // Take a screenshot of the search results
    await page.screenshot({ path: 'property_search_results.png', fullPage: true });
    
    console.log('Screenshot saved as property_search_results.png');
    
  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }
})();