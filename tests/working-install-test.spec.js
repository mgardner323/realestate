import { test, expect } from '@playwright/test';
import fs from 'fs';

test('Installation wizard basic functionality', async ({ page }) => {
  // Clean up any existing installation file
  const installedPath = 'C:\\real\\real-estate-platform\\.installed';
  if (fs.existsSync(installedPath)) {
    fs.unlinkSync(installedPath);
  }

  // Navigate to homepage, should redirect to install
  await page.goto('/');
  
  // Wait for redirect to install page
  await page.waitForLoadState('networkidle');
  
  // Verify we're on the install page
  await expect(page).toHaveURL(/.*\/install/);
  
  // Check main heading
  await expect(page.locator('h1')).toContainText('Real Estate Platform');
  
  // Verify step 1 fields are present
  await expect(page.locator('#agencyName')).toBeVisible();
  await expect(page.locator('#agencyEmail')).toBeVisible();
  
  // Fill step 1 - only the required fields for this step
  await page.fill('#agencyName', 'Test Real Estate Agency');
  await page.fill('#agencyEmail', 'test@agency.com');
  
  console.log('Step 1 completed successfully');
  
  // Submit step 1
  await page.click('button[type="submit"]:has-text("Next Step")');
  
  // Wait for step 2 to load
  await page.waitForTimeout(2000);
  
  // Verify we're on step 2 by checking for branding fields
  await expect(page.locator('#seoTitle')).toBeVisible({ timeout: 10000 });
  await expect(page.locator('#seoDescription')).toBeVisible();
  
  console.log('Successfully navigated to step 2');
});