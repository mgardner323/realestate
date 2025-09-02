import { chromium } from 'playwright';

const checkNewsletterSignup = async () => {
    console.log('📧 Testing Newsletter Signup Functionality...\n');
    
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Navigate to the homepage
        console.log('🏠 Navigating to homepage (/)...');
        await page.goto('http://localhost:8000/');
        await page.waitForLoadState('networkidle');
        
        // Check if the page loaded correctly
        const pageTitle = await page.textContent('h1');
        console.log(`   Homepage title: "${pageTitle}"`);
        
        // Scroll down to the newsletter section
        console.log('📜 Scrolling to newsletter section...');
        await page.locator('text=Subscribe to our Newsletter').scrollIntoViewIfNeeded();
        await page.waitForTimeout(1000); // Wait for scroll animation
        
        // Check if newsletter component is visible
        const newsletterTitle = await page.textContent('h2:has-text("Subscribe to our Newsletter")');
        console.log(`   Newsletter title: "${newsletterTitle}"`);
        
        // Generate a test email address
        const testEmail = `test-${Date.now()}@example.com`;
        console.log(`   Test email: ${testEmail}`);
        
        // Fill in the newsletter form
        console.log('✍️ Filling newsletter form...');
        await page.fill('input[type="email"]', testEmail);
        console.log('   Email entered successfully');
        
        // Click the Subscribe button
        console.log('🚀 Clicking Subscribe button...');
        await page.click('button:has-text("Subscribe")');
        
        // Wait for the success message to appear
        console.log('⏳ Waiting for success message...');
        
        let successMessageFound = false;
        let attempts = 0;
        const maxAttempts = 10; // 10 seconds with 1 second intervals
        
        while (!successMessageFound && attempts < maxAttempts) {
            await page.waitForTimeout(1000); // Wait 1 second
            
            // Check for success message
            const successMessage = await page.locator('text=Thank you for subscribing!');
            if (await successMessage.count() > 0) {
                successMessageFound = true;
                console.log('   ✅ Success message appeared!');
                
                // Get the full success message text
                const fullMessage = await page.textContent('div:has-text("Thank you for subscribing!")');
                console.log(`   📄 Success message: "${fullMessage}"`);
            } else {
                attempts++;
                console.log(`   ⏳ Attempt ${attempts}/${maxAttempts} - waiting for success message...`);
            }
        }
        
        if (!successMessageFound) {
            console.log('   ⚠️ Success message did not appear');
            
            // Check for any error messages
            const errorMessage = await page.locator('.text-red-500');
            if (await errorMessage.count() > 0) {
                const error = await errorMessage.textContent();
                console.log(`   ❌ Error found: "${error}"`);
            }
        }
        
        // Take a screenshot
        console.log('\n📸 Taking screenshot...');
        await page.screenshot({ 
            path: 'newsletter_signup_success.png', 
            fullPage: true 
        });
        console.log('   Screenshot saved as: newsletter_signup_success.png');
        
        // Test duplicate email validation
        if (successMessageFound) {
            console.log('\n🔄 Testing duplicate email validation...');
            await page.reload();
            await page.waitForLoadState('networkidle');
            await page.locator('text=Subscribe to our Newsletter').scrollIntoViewIfNeeded();
            
            // Try to submit the same email again
            await page.fill('input[type="email"]', testEmail);
            await page.click('button:has-text("Subscribe")');
            await page.waitForTimeout(2000);
            
            // Check for validation error
            const validationError = await page.locator('.text-red-500');
            if (await validationError.count() > 0) {
                const errorText = await validationError.textContent();
                console.log(`   ✅ Duplicate validation working: "${errorText}"`);
            }
        }
        
        console.log('\n🎉 Newsletter signup test completed!');
        
    } catch (error) {
        console.error('\n❌ Test failed:', error.message);
        
        // Take error screenshot
        try {
            await page.screenshot({ path: 'newsletter_signup_error.png', fullPage: true });
            console.log('Error screenshot saved as: newsletter_signup_error.png');
        } catch (screenshotError) {
            console.error('Could not save error screenshot:', screenshotError.message);
        }
    } finally {
        await browser.close();
    }
};

checkNewsletterSignup();