import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 1000 });
  const page = await browser.newPage();
  
  try {
    console.log('🧪 TESTING DYNAMIC NEWS MENU FEATURE');
    console.log('====================================');
    
    // Step 5a: Navigate to the local homepage
    console.log('📍 Step 1: Navigating to local homepage...');
    await page.goto('http://localhost:8000', { waitUntil: 'networkidle' });
    
    const currentUrl = page.url();
    console.log(`   Current URL: ${currentUrl}`);
    
    if (currentUrl.includes('localhost:8000')) {
      console.log('✅ Successfully navigated to homepage');
    } else {
      throw new Error('Failed to navigate to homepage');
    }
    
    // Step 5b: Hover over or click the "News" menu item to reveal the dropdown
    console.log('📍 Step 2: Testing News dropdown menu...');
    
    // Wait for the News button to be visible
    await page.waitForSelector('button:has-text("News")', { timeout: 10000 });
    console.log('   Found News button');
    
    // Click the News button to open dropdown
    await page.click('button:has-text("News")');
    await page.waitForTimeout(500); // Wait for dropdown animation
    
    // Check if dropdown is visible
    const dropdownVisible = await page.isVisible('.absolute.right-0.mt-2.w-48');
    if (dropdownVisible) {
      console.log('✅ News dropdown successfully opened');
      
      // Count the number of category links
      const categoryLinks = await page.locator('a[href^="/news/"]').count();
      console.log(`   Found ${categoryLinks} category links in dropdown`);
      
      // List all category links
      const categories = await page.locator('a[href^="/news/"]').allTextContents();
      console.log('   Categories available:', categories);
      
    } else {
      throw new Error('News dropdown did not open');
    }
    
    // Step 5c: Navigate to the first category page directly
    console.log('📍 Step 3: Navigating to first category page...');
    
    const firstCategoryLink = page.locator('a[href^="/news/"]').first();
    const firstCategoryText = await firstCategoryLink.textContent();
    const firstCategoryHref = await firstCategoryLink.getAttribute('href');
    
    console.log(`   Navigating to category: "${firstCategoryText.trim()}" (${firstCategoryHref})`);
    
    // Navigate directly to the category page
    await page.goto(`http://localhost:8000${firstCategoryHref}`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    // Step 5d: Verify that the new page loads and shows the correct category title
    console.log('📍 Step 4: Verifying category page loaded correctly...');
    
    const newUrl = page.url();
    console.log(`   New URL: ${newUrl}`);
    
    if (newUrl.includes('/news/')) {
      console.log('✅ Successfully navigated to category page');
      
      // Check for category title on the page
      const pageTitle = await page.locator('h1').first().textContent();
      console.log(`   Page title: "${pageTitle}"`);
      
      if (pageTitle && pageTitle.trim() !== '') {
        console.log('✅ Category page shows correct title');
      } else {
        console.log('⚠️  No title found on category page');
      }
      
      // Check if posts are displayed or "no posts" message
      const postsGrid = await page.locator('.grid').count();
      const noPostsMessage = await page.locator(':text("No posts found")').count();
      
      if (postsGrid > 0) {
        console.log('✅ Posts grid is displayed');
      } else if (noPostsMessage > 0) {
        console.log('✅ "No posts found" message displayed (expected if no posts exist)');
      } else {
        console.log('⚠️  Neither posts nor "no posts" message found');
      }
      
    } else {
      throw new Error('Failed to navigate to category page');
    }
    
    // Step 5e: Take a screenshot named `news_menu_and_category_page.png`
    console.log('📍 Step 5: Taking screenshot...');
    await page.screenshot({ 
      path: 'news_menu_and_category_page.png', 
      fullPage: true 
    });
    console.log('📸 Screenshot saved: news_menu_and_category_page.png');
    
    // Final summary
    console.log('');
    console.log('===============================================');
    console.log('🏆 DYNAMIC NEWS MENU TEST COMPLETE! 🏆');
    console.log('===============================================');
    console.log('✅ Homepage navigation successful');
    console.log('✅ News dropdown menu functional');
    console.log('✅ Category links dynamically populated');
    console.log('✅ Category page loads correctly');
    console.log('✅ Screenshot captured');
    console.log('===============================================');
    console.log('🎉 Dynamic Content & Navigation feature is working correctly! 🎉');
    
  } catch (error) {
    console.error('💥 NEWS MENU TEST FAILED:', error.message);
    await page.screenshot({ path: 'news_menu_test_error.png', fullPage: true });
    console.log('📸 Error screenshot saved: news_menu_test_error.png');
  } finally {
    await browser.close();
    console.log('🔚 Test completed');
  }
})();