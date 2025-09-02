import { test, expect } from '@playwright/test';

test('Installation wizard loads and basic navigation works', async ({ page }) => {
  // Remove .installed file if it exists
  await page.context().addInitScript(() => {
    // This will run in browser context
    localStorage.clear();
    sessionStorage.clear();
  });

  // Go to home page and verify redirect to install
  await page.goto('/');
  await page.waitForURL('**/install', { timeout: 10000 });
  
  // Check basic elements are present
  await expect(page.locator('h1')).toContainText('Real Estate Platform');
  await expect(page.getByText('Installation Wizard')).toBeVisible();
  
  // Check step 1 form fields
  await expect(page.locator('#agencyName')).toBeVisible();
  await expect(page.locator('#agencyEmail')).toBeVisible();
  
  // Fill required fields and proceed to step 2
  await page.fill('#agencyName', 'Test Agency');
  await page.fill('#agencyEmail', 'test@example.com');
  await page.fill('#seoTitle', 'Test SEO Title');
  await page.fill('#seoDescription', 'Test SEO Description');
  
  // Click Next
  await page.click('button:has-text("Next Step")');
  
  // Wait and verify we're on step 2
  await expect(page.locator('h2')).toContainText('Branding & SEO');
  
  console.log('Installation wizard basic test passed!');
});