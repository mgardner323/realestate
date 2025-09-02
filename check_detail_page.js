import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    // Navigate to the property listings page
    await page.goto('http://localhost:8000/properties');
    
    // Wait for the page to load
    await page.waitForLoadState('networkidle');
    
    // Click the first property link
    await page.click('a[href^="/property/"]');
    
    // Wait for the detail page to load
    await page.waitForLoadState('networkidle');
    
    // Take a screenshot of the property detail page
    await page.screenshot({ path: 'property_detail_page_styled.png', fullPage: true });
    
    console.log('Screenshot saved as property_detail_page_styled.png');
    
  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }
})();