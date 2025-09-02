import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting Queued Post verification...');
    
    // Navigate to login page
    await page.goto('http://localhost:8000/login');
    console.log('Navigated to login page');

    // Fill in admin credentials and login
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    
    // Submit the form and wait for response
    await page.click('button[type="submit"]');
    await page.waitForLoadState('networkidle');
    console.log('Login attempted');
    
    // Navigate to blog admin page
    await page.goto('http://localhost:8000/admin/blog');
    console.log('Navigated to blog admin page');
    await page.waitForTimeout(2000);

    // Debug: Check what's on the page
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Check for posts in the blog admin
    const postElements = await page.locator('article, .post, [data-post], h2, h3').count();
    console.log('Post elements found:', postElements);
    
    // Look for our specific test posts
    const queuedTestPost = await page.locator('text=Queued AI Post Test').count();
    const quickTestPost = await page.locator('text=Quick Test Post').count();
    
    console.log('Queued AI Post Test found:', queuedTestPost);
    console.log('Quick Test Post found:', quickTestPost);
    
    // Check for placeholder content vs generated content
    const placeholderContent = await page.locator('text=Placeholder content').count();
    console.log('Posts with placeholder content:', placeholderContent);
    
    if (queuedTestPost > 0 || quickTestPost > 0) {
      console.log('✅ API-created posts found in the admin interface!');
      
      // Try to find more details about the posts
      const allText = await page.locator('body').innerText();
      const hasPlaceholder = allText.includes('Placeholder content');
      
      if (hasPlaceholder) {
        console.log('⚠️  Posts still have placeholder content - queue job may not have completed');
      } else {
        console.log('✅ Posts appear to have been processed by queue jobs');
      }
      
    } else {
      console.log('❌ API-created posts not found in admin interface');
      
      // Debug: show page content
      const bodyText = await page.locator('body').innerText();
      console.log('Page content preview:', bodyText.substring(0, 500));
    }
    
    // Check if we can see any posts at all
    const anyPosts = await page.locator('text=edit, text=delete, text=published, text=draft').count();
    if (anyPosts > 0) {
      console.log('✅ Blog admin interface appears to be working (other posts visible)');
    } else {
      console.log('⚠️  Blog admin interface may not be loading properly');
    }

    // Take screenshot
    await page.screenshot({ path: 'queued_job_success.png', fullPage: true });
    console.log('Screenshot saved as queued_job_success.png');

    console.log('✅ Queued Post verification completed');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'queued_job_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();