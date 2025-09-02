import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    // Navigate to the mortgage calculator page
    await page.goto('http://localhost:8000/mortgage-calculator');
    
    // Wait for the page to load
    await page.waitForLoadState('networkidle');
    
    // Fill in the form with sample data
    await page.fill('#loan-amount', '300000');
    await page.fill('#interest-rate', '5');
    await page.fill('#loan-term', '30');
    
    // Click the Calculate button
    await page.click('button[type="submit"]');
    
    // Wait for the calculation to complete (Livewire should update automatically)
    await page.waitForTimeout(2000);
    
    // Take a screenshot of the calculator with results
    await page.screenshot({ path: 'mortgage_calculator_result.png', fullPage: true });
    
    console.log('Screenshot saved as mortgage_calculator_result.png');
    
  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }
})();