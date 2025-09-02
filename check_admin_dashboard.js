import { chromium } from 'playwright';

async function checkAdminDashboard() {
  const browser = await chromium.launch();
  const context = await browser.newContext();
  const page = await context.newPage();

  try {
    console.log('Starting admin dashboard access verification...');
    
    // Part A: Test access without login
    console.log('\n1. Testing access without authentication...');
    await page.goto('http://localhost:8000/admin/dashboard');
    
    // Wait for redirect and check URL
    await page.waitForURL(/login/, { timeout: 10000 });
    const currentUrl = page.url();
    console.log(`✓ Redirected to: ${currentUrl}`);
    
    if (currentUrl.includes('login')) {
      console.log('✓ PASS: Unauthenticated users are redirected to login');
    } else {
      console.log('✗ FAIL: Expected redirect to login page');
      return;
    }

    // Part B: Test access with admin login
    console.log('\n2. Testing access with admin authentication...');
    
    // Fill login form
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    
    // Wait for login to complete
    await page.waitForURL(/dashboard/, { timeout: 10000 });
    console.log('✓ Admin login successful');
    
    // Navigate to admin dashboard
    await page.goto('http://localhost:8000/admin/dashboard');
    await page.waitForLoadState('networkidle');
    
    // Verify we're on admin dashboard
    const dashboardUrl = page.url();
    console.log(`✓ Navigated to: ${dashboardUrl}`);
    
    if (dashboardUrl.includes('/admin/dashboard')) {
      console.log('✓ PASS: Admin user can access dashboard');
      
      // Take screenshot
      await page.screenshot({ 
        path: 'admin_dashboard.png', 
        fullPage: true 
      });
      console.log('✓ Screenshot saved as admin_dashboard.png');
      
      // Verify dashboard content
      const title = await page.textContent('h1');
      const welcomeText = await page.textContent('h2');
      
      console.log(`✓ Dashboard title: ${title}`);
      console.log(`✓ Welcome message: ${welcomeText}`);
      
      // Check stat cards
      const statCards = await page.locator('.bg-white.p-6.rounded-lg.shadow-lg').count();
      console.log(`✓ Found ${statCards} statistic cards`);
      
      // Check navigation links
      const navLinks = await page.locator('nav a').count();
      console.log(`✓ Found ${navLinks} navigation links`);
      
      console.log('\n✅ All tests passed! Admin dashboard is properly protected and functional.');
      
    } else {
      console.log('✗ FAIL: Could not access admin dashboard');
    }

  } catch (error) {
    console.error('❌ Test failed with error:', error.message);
  } finally {
    await browser.close();
  }
}

// Run the test
checkAdminDashboard();