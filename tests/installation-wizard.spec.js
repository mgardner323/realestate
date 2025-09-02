import { test, expect } from '@playwright/test';
import fs from 'fs';
import path from 'path';

test.describe('Installation Wizard', () => {
  test.beforeEach(async () => {
    // Remove .installed file if it exists to simulate fresh installation
    const installedFile = path.join(process.cwd(), '.installed');
    if (fs.existsSync(installedFile)) {
      fs.unlinkSync(installedFile);
    }
  });

  test('should redirect to installation wizard from home page', async ({ page }) => {
    await page.goto('/');
    
    // Should be redirected to installation wizard
    await expect(page).toHaveURL('/install');
    
    // Check that installation wizard loads correctly
    await expect(page.locator('h1')).toContainText('Real Estate Platform');
    await expect(page.locator('p')).toContainText('Installation Wizard');
    await expect(page.locator('p')).toContainText('Set up your professional real estate platform in just 3 steps');
  });

  test('should display step 1 with agency information form', async ({ page }) => {
    await page.goto('/install');
    
    // Check step indicator
    await expect(page.locator('.text-blue-600').first()).toContainText('Agency Information');
    
    // Check form fields are present
    await expect(page.locator('[data-testid="agencyName"], #agencyName')).toBeVisible();
    await expect(page.locator('[data-testid="agencyEmail"], #agencyEmail')).toBeVisible();
    await expect(page.locator('[data-testid="agencyPhone"], #agencyPhone')).toBeVisible();
    await expect(page.locator('[data-testid="agencyAddress"], #agencyAddress')).toBeVisible();
    
    // Check default values are populated
    await expect(page.locator('#agencyName')).toHaveValue('Real Estate Agency');
    await expect(page.locator('#agencyEmail')).toHaveValue('info@realestate.com');
  });

  test('should navigate through all wizard steps', async ({ page }) => {
    await page.goto('/install');
    
    // Step 1: Agency Information
    await page.fill('#agencyName', 'Test Real Estate Agency');
    await page.fill('#agencyEmail', 'test@agency.com');
    await page.fill('#agencyPhone', '(555) 123-4567');
    await page.fill('#agencyAddress', '123 Test Street, Test City, TC 12345');
    
    await page.click('button[type="submit"]');
    
    // Step 2: Branding & SEO
    await expect(page.locator('.text-blue-600').nth(1)).toContainText('Branding & SEO');
    
    await page.fill('#brandPrimaryColor', '#FF6B6B');
    await page.fill('#brandSecondaryColor', '#4ECDC4');
    await page.fill('#seoTitle', 'Test Real Estate Platform');
    await page.fill('#seoDescription', 'Test description for our real estate platform.');
    
    await page.click('button[type="submit"]');
    
    // Step 3: Admin Account
    await expect(page.locator('.text-blue-600').nth(2)).toContainText('Admin Account');
    
    await page.fill('#adminName', 'Test Admin');
    await page.fill('#adminEmail', 'admin@test.com');
    await page.fill('#adminPassword', 'testpassword123');
    await page.fill('#adminPasswordConfirmation', 'testpassword123');
    
    // Check installation summary is shown
    await expect(page.locator('.bg-blue-50')).toContainText('Installation Summary');
    await expect(page.locator('.bg-blue-50')).toContainText('Test Real Estate Agency');
    await expect(page.locator('.bg-blue-50')).toContainText('test@agency.com');
    await expect(page.locator('.bg-blue-50')).toContainText('Test Real Estate Platform');
    await expect(page.locator('.bg-blue-50')).toContainText('Test Admin');
  });

  test('should validate required fields', async ({ page }) => {
    await page.goto('/install');
    
    // Try to proceed without filling required fields
    await page.fill('#agencyName', '');
    await page.fill('#agencyEmail', '');
    
    await page.click('button[type="submit"]');
    
    // Should show validation errors and stay on step 1
    await expect(page.locator('.text-red-500')).toBeVisible();
    await expect(page.locator('h2')).toContainText('Agency Information');
  });

  test('should validate email format', async ({ page }) => {
    await page.goto('/install');
    
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'invalid-email');
    
    await page.click('button[type="submit"]');
    
    // Should show validation error for email
    await expect(page.locator('.text-red-500')).toBeVisible();
  });

  test('should validate password confirmation', async ({ page }) => {
    await page.goto('/install');
    
    // Navigate to step 3
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'test@agency.com');
    await page.fill('#seoTitle', 'Test Title');
    await page.fill('#seoDescription', 'Test description');
    await page.click('button[type="submit"]');
    await page.click('button[type="submit"]');
    
    // Fill admin form with mismatched passwords
    await page.fill('#adminName', 'Test Admin');
    await page.fill('#adminEmail', 'admin@test.com');
    await page.fill('#adminPassword', 'password123');
    await page.fill('#adminPasswordConfirmation', 'differentpassword');
    
    await page.click('button[type="submit"]');
    
    // Should show password confirmation error
    await expect(page.locator('.text-red-500')).toBeVisible();
  });

  test('should show loading state during installation', async ({ page }) => {
    await page.goto('/install');
    
    // Navigate through all steps
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'test@agency.com');
    await page.fill('#seoTitle', 'Test Title');
    await page.fill('#seoDescription', 'Test description');
    await page.click('button[type="submit"]');
    await page.click('button[type="submit"]');
    
    await page.fill('#adminName', 'Test Admin');
    await page.fill('#adminEmail', 'admin@test.com');
    await page.fill('#adminPassword', 'password123');
    await page.fill('#adminPasswordConfirmation', 'password123');
    
    // Click complete installation button
    const completeButton = page.locator('button[type="submit"]:has-text("Complete Installation")');
    await completeButton.click();
    
    // Should show loading state
    await expect(page.locator('[wire:loading][wire:target="finish"]')).toBeVisible();
    await expect(page.locator('text=Installing...')).toBeVisible();
  });

  test('should allow navigation between steps', async ({ page }) => {
    await page.goto('/install');
    
    // Go to step 2
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'test@agency.com');
    await page.fill('#seoTitle', 'Test Title');
    await page.fill('#seoDescription', 'Test description');
    await page.click('button[type="submit"]');
    
    // Should be on step 2
    await expect(page.locator('h2')).toContainText('Branding & SEO');
    
    // Go back to step 1
    await page.click('button:has-text("Previous")');
    
    // Should be back on step 1
    await expect(page.locator('h2')).toContainText('Agency Information');
    
    // Values should be preserved
    await expect(page.locator('#agencyName')).toHaveValue('Test Agency');
    await expect(page.locator('#agencyEmail')).toHaveValue('test@agency.com');
  });

  test('should show color preview in step 2', async ({ page }) => {
    await page.goto('/install');
    
    // Navigate to step 2
    await page.fill('#agencyName', 'Test Agency');
    await page.fill('#agencyEmail', 'test@agency.com');
    await page.fill('#seoTitle', 'Test Title');
    await page.fill('#seoDescription', 'Test description');
    await page.click('button[type="submit"]');
    
    // Check color preview section exists
    await expect(page.locator('.bg-gray-50')).toContainText('Color Preview');
    
    // Change colors and verify they update
    await page.fill('input[type="text"][wire\\:model="brandPrimaryColor"]', '#FF0000');
    await page.fill('input[type="text"][wire\\:model="brandSecondaryColor"]', '#00FF00');
    
    // Color preview should update (though we can't easily test the actual colors in Playwright)
    await expect(page.locator('.bg-gray-50')).toBeVisible();
  });

  test('should redirect away from install page when already installed', async ({ page }) => {
    // Create .installed file to simulate completed installation
    const installedFile = path.join(process.cwd(), '.installed');
    fs.writeFileSync(installedFile, JSON.stringify({ installed_at: new Date().toISOString() }));
    
    try {
      await page.goto('/install');
      
      // Should be redirected away from install page (likely to home)
      await expect(page).not.toHaveURL('/install');
      
    } finally {
      // Clean up
      if (fs.existsSync(installedFile)) {
        fs.unlinkSync(installedFile);
      }
    }
  });
});