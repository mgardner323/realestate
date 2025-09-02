import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    console.log('Starting AI Image Generation verification...');
    
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

    // Debug: Check what's on the page
    console.log('Current URL:', page.url());
    console.log('Page title:', await page.title());
    
    // Check if Featured Image section exists
    const featuredImageSectionExists = await page.locator('text=Featured Image').count();
    console.log('Featured Image section count:', featuredImageSectionExists);
    
    // Check for the Generate Image with AI button
    const generateImageButtonExists = await page.locator('button:has-text("Generate Image with AI")').count();
    console.log('Generate Image button count:', generateImageButtonExists);
    
    // Check for existing featured image
    const existingImageExists = await page.locator('img[alt="Featured Image"]').count();
    console.log('Existing featured image count:', existingImageExists);

    if (featuredImageSectionExists > 0 && generateImageButtonExists > 0) {
      console.log('✅ Featured Image section and Generate button found!');
      
      // Get the initial image src (if any) to compare later
      let initialImageSrc = '';
      if (existingImageExists > 0) {
        initialImageSrc = await page.locator('img[alt="Featured Image"]').getAttribute('src');
        console.log('Initial image src:', initialImageSrc);
      }
      
      // Check if there's post content first
      const postContentExists = await page.locator('trix-editor').count();
      if (postContentExists > 0) {
        console.log('✅ Post content editor found');
        
        try {
          // Click the Generate Image with AI button
          console.log('Attempting to click Generate Image button...');
          await page.click('button:has-text("Generate Image with AI")');
          console.log('✅ Generate Image button clicked');
          
          // Wait for potential response (AI generation might take time)
          console.log('Waiting for image generation (this may take up to 30 seconds)...');
          
          // Wait for either success or error message
          try {
            await page.waitForSelector('.bg-green-100, .bg-red-100', { timeout: 30000 });
            
            const successMessage = await page.locator('.bg-green-100').count();
            const errorMessage = await page.locator('.bg-red-100').count();
            
            if (successMessage > 0) {
              console.log('✅ Success message detected');
              
              // Check if image has been updated
              const newImageExists = await page.locator('img[alt="Featured Image"]').count();
              if (newImageExists > 0) {
                const newImageSrc = await page.locator('img[alt="Featured Image"]').getAttribute('src');
                console.log('New image src:', newImageSrc);
                
                if (newImageSrc && newImageSrc !== initialImageSrc) {
                  console.log('✅ Featured image successfully generated and updated!');
                } else {
                  console.log('⚠️  Image src did not change - generation may have failed');
                }
              } else {
                console.log('⚠️  No image found after generation');
              }
            } else if (errorMessage > 0) {
              const errorText = await page.locator('.bg-red-100').innerText();
              console.log('❌ Error message detected:', errorText);
            }
          } catch (timeoutError) {
            console.log('⚠️  Timeout waiting for response - generation may still be in progress');
          }
          
        } catch (error) {
          console.log('⚠️  Could not interact with Generate Image button:', error.message);
        }
      } else {
        console.log('⚠️  No post content found for image generation');
      }
    } else {
      console.log('❌ Featured Image section or Generate button not found');
      
      // Check page content for debugging
      const bodyText = await page.locator('body').innerText();
      console.log('Page content preview:', bodyText.substring(0, 500));
    }

    // Take screenshot
    await page.screenshot({ path: 'ai_image_generation.png', fullPage: true });
    console.log('Screenshot saved as ai_image_generation.png');

    console.log('✅ AI Image Generation verification completed');

  } catch (error) {
    console.error('❌ Error during verification:', error);
    await page.screenshot({ path: 'ai_image_generation_error.png', fullPage: true });
  } finally {
    await browser.close();
  }
})();