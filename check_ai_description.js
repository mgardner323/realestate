import { chromium } from 'playwright';

const checkAIDescription = async () => {
    console.log('🏠 Testing AI Property Description Generation...\n');
    
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Navigate to the edit property page for property ID 1
        console.log('📝 Navigating to /admin/property/1/edit...');
        await page.goto('http://localhost:8000/admin/property/1/edit');
        await page.waitForLoadState('networkidle');
        
        // Check if the page loaded correctly
        const pageTitle = await page.textContent('h1');
        console.log(`   Page title: "${pageTitle}"`);
        
        // Get current property details
        const currentTitle = await page.inputValue('#title');
        const currentLocation = await page.inputValue('#location');
        const currentPrice = await page.inputValue('#price');
        const currentDescription = await page.inputValue('#description');
        
        console.log('📋 Current Property Details:');
        console.log(`   Title: "${currentTitle}"`);
        console.log(`   Location: "${currentLocation}"`);
        console.log(`   Price: $${currentPrice}`);
        console.log(`   Description length: ${currentDescription.length} characters`);
        
        // Click the "Generate Description with AI" button
        console.log('\n🚀 Clicking "Generate Description with AI" button...');
        await page.click('button:has-text("Generate Description with AI")');
        
        // Wait for the description to be generated
        console.log('⏳ Waiting for AI description generation...');
        
        let descriptionGenerated = false;
        let attempts = 0;
        const maxAttempts = 30; // 30 seconds with 1 second intervals
        
        while (!descriptionGenerated && attempts < maxAttempts) {
            await page.waitForTimeout(1000); // Wait 1 second
            const newDescription = await page.inputValue('#description');
            
            // Check if description changed and is longer than original
            if (newDescription && newDescription !== currentDescription && newDescription.length > currentDescription.length + 50) {
                descriptionGenerated = true;
                console.log(`   ✅ Description generated! New length: ${newDescription.length} characters`);
                console.log(`   📄 First 200 characters: "${newDescription.substring(0, 200)}..."`);
            } else {
                attempts++;
                console.log(`   ⏳ Attempt ${attempts}/${maxAttempts} - waiting for description...`);
            }
        }
        
        if (!descriptionGenerated) {
            console.log('   ⚠️ Description generation may have failed or is taking longer than expected');
            const finalDescription = await page.inputValue('#description');
            console.log(`   📄 Final description: "${finalDescription}"`);
        }
        
        // Take a screenshot
        console.log('\n📸 Taking screenshot...');
        await page.screenshot({ 
            path: 'ai_generated_description.png', 
            fullPage: true 
        });
        console.log('   Screenshot saved as: ai_generated_description.png');
        
        // Test the save functionality (optional)
        if (descriptionGenerated) {
            console.log('💾 Testing save functionality...');
            await page.click('button:has-text("Save Property")');
            await page.waitForTimeout(2000);
            
            // Check for success message
            const successMessage = await page.locator('div:has-text("Property updated successfully!")');
            if (await successMessage.count() > 0) {
                console.log('   ✅ Property saved successfully!');
            }
        }
        
        console.log('\n🎉 AI Property Description test completed!');
        
    } catch (error) {
        console.error('\n❌ Test failed:', error.message);
        
        // Take error screenshot
        try {
            await page.screenshot({ path: 'ai_description_error.png', fullPage: true });
            console.log('Error screenshot saved as: ai_description_error.png');
        } catch (screenshotError) {
            console.error('Could not save error screenshot:', screenshotError.message);
        }
    } finally {
        await browser.close();
    }
};

checkAIDescription();