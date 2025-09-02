import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    // Navigate to the homepage
    await page.goto('http://localhost:8000/');
    
    // Wait for the page to load
    await page.waitForLoadState('networkidle');
    
    // Take a screenshot of the homepage
    await page.screenshot({ path: 'homepage.png', fullPage: true });
    
    console.log('Screenshot saved as homepage.png');
    
  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }
})();