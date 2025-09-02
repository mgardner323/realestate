import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting AI SEO Generation verification...');
    
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
    
    // Navigate directly to edit the first post (ID 1)
    await page.goto('http://localhost:8000/admin/blog/1/edit');
    console.log('Navigated to edit post page for post ID 1');
    await page.waitForTimeout(2000);
    
    // Wait for the page to load and check if we can find SEO elements
    await page.waitForTimeout(2000);

    // Debug: Check what's on the page
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Check if SEO Settings section exists
    const seoSectionExists = await page.locator('text=SEO Settings').count();
    console.log('SEO Settings section count:', seoSectionExists);
    
    // Check for the Generate SEO with AI button
    const generateSeoButtonExists = await page.locator('button:has-text("Generate SEO with AI")').count();
    console.log('Generate SEO button count:', generateSeoButtonExists);
    
    // Check for meta title and description inputs
    const metaTitleInputExists = await page.locator('input[wire\\:model="meta_title"]').count();
    const metaDescriptionInputExists = await page.locator('textarea[wire\\:model="meta_description"]').count();
    console.log('Meta title input count:', metaTitleInputExists);
    console.log('Meta description input count:', metaDescriptionInputExists);

    if (seoSectionExists > 0 && generateSeoButtonExists > 0) {
      console.log('✅ SEO Settings section and Generate button found!');
      
      // Check if there's post content first
      const postContentExists = await page.locator('trix-editor').count();
      if (postContentExists > 0) {
        console.log('✅ Post content editor found');
        
        try {
          // Click the Generate SEO with AI button
          console.log('Attempting to click Generate SEO button...');
          await page.click('button:has-text("Generate SEO with AI")');
          console.log('✅ Generate SEO button clicked');
          
          // Wait for potential response (AI generation might take time)
          await page.waitForTimeout(5000);
          
          // Check if meta fields are populated
          const metaTitleValue = await page.locator('input[wire\\:model="meta_title"]').inputValue();
          const metaDescriptionValue = await page.locator('textarea[wire\\:model="meta_description"]').inputValue();
          
          console.log('Meta title value:', metaTitleValue ? '(populated)' : '(empty)');
          console.log('Meta description value:', metaDescriptionValue ? '(populated)' : '(empty)');
          
          if (metaTitleValue && metaDescriptionValue) {
            console.log('✅ SEO tags successfully generated and populated!');
          } else {
            console.log('⚠️  SEO generation may have failed or is still processing');
          }
        } catch (error) {
          console.log('⚠️  Could not interact with Generate SEO button:', error.message);
        }
      } else {
        console.log('⚠️  No post content found for SEO generation');
      }
    } else {
      console.log('❌ SEO Settings section or Generate button not found');
      
      // Check page content for debugging
      const bodyText = await page.locator('body').innerText();
      console.log('Page content preview:', bodyText.substring(0, 500));
    }

    // Take screenshot
    await page.screenshot({ path: 'ai_seo_generation.png', fullPage: true });
    console.log('Screenshot saved as ai_seo_generation.png');

    console.log('✅ AI SEO Generation verification completed');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'ai_seo_generation_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();