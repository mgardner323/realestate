import { chromium } from 'playwright';

const checkAIBlogPost = async () => {
    console.log('🤖 Testing AI Blog Post Generation...\n');
    
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Navigate to the create post page
        console.log('📝 Navigating to /admin/blog/create...');
        await page.goto('http://localhost:8000/admin/blog/create');
        await page.waitForLoadState('networkidle');
        
        // Check if the page loaded correctly
        const pageTitle = await page.textContent('h1');
        console.log(`   Page title: "${pageTitle}"`);
        
        // Type the test title
        console.log('✍️ Typing blog post title...');
        const testTitle = "Top 5 Benefits of a Professional Home Inspection";
        await page.fill('#title', testTitle);
        console.log(`   Title entered: "${testTitle}"`);
        
        // Click the "Generate with AI" button
        console.log('🚀 Clicking "Generate with AI" button...');
        await page.click('button:has-text("Generate with AI")');
        
        // Wait for the content to be generated (check if textarea has content)
        console.log('⏳ Waiting for AI content generation...');
        
        // Wait up to 30 seconds for content to appear in the body textarea
        let contentGenerated = false;
        let attempts = 0;
        const maxAttempts = 30; // 30 seconds with 1 second intervals
        
        while (!contentGenerated && attempts < maxAttempts) {
            await page.waitForTimeout(1000); // Wait 1 second
            const bodyContent = await page.inputValue('#body');
            
            if (bodyContent && bodyContent.length > 10) {
                contentGenerated = true;
                console.log(`   ✅ Content generated! Length: ${bodyContent.length} characters`);
                console.log(`   📄 First 200 characters: "${bodyContent.substring(0, 200)}..."`);
            } else {
                attempts++;
                console.log(`   ⏳ Attempt ${attempts}/${maxAttempts} - waiting for content...`);
            }
        }
        
        if (!contentGenerated) {
            console.log('   ⚠️ Content generation may have failed or is taking longer than expected');
            const bodyContent = await page.inputValue('#body');
            console.log(`   📄 Current body content: "${bodyContent}"`);
        }
        
        // Take a screenshot
        console.log('📸 Taking screenshot...');
        await page.screenshot({ 
            path: 'ai_generated_blog_post.png', 
            fullPage: true 
        });
        console.log('   Screenshot saved as: ai_generated_blog_post.png');
        
        // Test the save functionality (optional)
        if (contentGenerated) {
            console.log('💾 Testing save functionality...');
            await page.click('button:has-text("Save Post")');
            await page.waitForTimeout(2000);
            
            // Check for success message
            const successMessage = await page.locator('div:has-text("Post created successfully!")');
            if (await successMessage.count() > 0) {
                console.log('   ✅ Post saved successfully!');
            }
        }
        
        console.log('\n🎉 AI Blog Post test completed!');
        
    } catch (error) {
        console.error('\n❌ Test failed:', error.message);
        
        // Take error screenshot
        try {
            await page.screenshot({ path: 'ai_blog_error.png', fullPage: true });
            console.log('Error screenshot saved as: ai_blog_error.png');
        } catch (screenshotError) {
            console.error('Could not save error screenshot:', screenshotError.message);
        }
    } finally {
        await browser.close();
    }
};

checkAIBlogPost();