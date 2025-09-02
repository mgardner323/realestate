import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    // Navigate to the affordability calculator page
    await page.goto('http://localhost:8000/affordability-calculator');
    
    // Wait for the page to load
    await page.waitForLoadState('networkidle');
    
    // Fill in the form with sample data
    await page.fill('#annual-income', '90000');
    await page.fill('#monthly-debts', '500');
    
    // Click the Calculate button
    await page.click('button[type="submit"]');
    
    // Wait for the calculation to complete (Livewire should update automatically)
    await page.waitForTimeout(2000);
    
    // Take a screenshot of the calculator with results
    await page.screenshot({ path: 'affordability_calculator_result.png', fullPage: true });
    
    console.log('Screenshot saved as affordability_calculator_result.png');
    
  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }
})();