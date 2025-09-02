import { chromium } from 'playwright';

const checkSubscriberList = async () => {
    console.log('📋 Testing Admin Subscriber List Interface...\n');
    
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Navigate to the admin subscribers page
        console.log('🔐 Navigating to /admin/subscribers...');
        await page.goto('http://localhost:8000/admin/subscribers');
        await page.waitForLoadState('networkidle');
        
        // Check if the page loaded correctly
        const pageTitle = await page.textContent('h2:has-text("Newsletter Subscribers")');
        console.log(`   Admin page title: "${pageTitle}"`);
        
        // Check the description
        const pageDescription = await page.textContent('p');
        console.log(`   Description: "${pageDescription}"`);
        
        // Check if the table is visible
        const tableExists = await page.locator('table').count() > 0;
        console.log(`   Table visible: ${tableExists}`);
        
        if (tableExists) {
            // Check table headers
            const headers = await page.locator('th').allTextContents();
            console.log(`   Table headers: [${headers.join(', ')}]`);
            
            // Count the number of subscriber rows (excluding empty state)
            const subscriberRows = await page.locator('tbody tr').count();
            console.log(`   Number of subscriber rows: ${subscriberRows}`);
            
            if (subscriberRows > 0) {
                // Check if we have the test subscriber from our previous test
                const firstRowData = await page.locator('tbody tr').first().locator('td').allTextContents();
                console.log(`   First row data: [${firstRowData.join(', ')}]`);
                
                // Look for our test email pattern
                const testEmailExists = await page.locator('td:has-text("test-")').count() > 0;
                console.log(`   Test email found: ${testEmailExists}`);
                
                // Check if dates are properly formatted
                const dateCell = await page.locator('tbody tr').first().locator('td').nth(2).textContent();
                console.log(`   Date format example: "${dateCell}"`);
            } else {
                // Check for empty state message
                const emptyMessage = await page.locator('td:has-text("No subscribers found.")').count();
                console.log(`   Empty state displayed: ${emptyMessage > 0}`);
            }
            
            // Check for pagination (if exists)
            const paginationExists = await page.locator('nav[role="navigation"]').count() > 0;
            console.log(`   Pagination visible: ${paginationExists}`);
        }
        
        // Take a screenshot
        console.log('\n📸 Taking screenshot...');
        await page.screenshot({ 
            path: 'subscriber_list_admin.png', 
            fullPage: true 
        });
        console.log('   Screenshot saved as: subscriber_list_admin.png');
        
        // Test responsiveness by changing viewport
        console.log('\n📱 Testing responsive design...');
        await page.setViewportSize({ width: 768, height: 1024 }); // Tablet view
        await page.waitForTimeout(1000);
        
        const tableStillVisible = await page.locator('table').count() > 0;
        console.log(`   Table visible on tablet: ${tableStillVisible}`);
        
        // Check if horizontal scroll is available for narrow screens
        await page.setViewportSize({ width: 375, height: 667 }); // Mobile view
        await page.waitForTimeout(1000);
        
        const overflowContainer = await page.locator('.overflow-x-auto').count() > 0;
        console.log(`   Responsive scroll container: ${overflowContainer}`);
        
        console.log('\n🎉 Admin subscriber list test completed!');
        
    } catch (error) {
        console.error('\n❌ Test failed:', error.message);
        
        // Take error screenshot
        try {
            await page.screenshot({ path: 'subscriber_admin_error.png', fullPage: true });
            console.log('Error screenshot saved as: subscriber_admin_error.png');
        } catch (screenshotError) {
            console.error('Could not save error screenshot:', screenshotError.message);
        }
    } finally {
        await browser.close();
    }
};

checkSubscriberList();