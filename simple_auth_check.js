import { chromium } from 'playwright';

const simpleAuthCheck = async () => {
    console.log('🔐 Simple Authentication Pages Check...\n');
    
    const browser = await chromium.launch({ headless: true });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Test Register Page
        console.log('📝 Checking register page...');
        await page.goto('http://localhost:8000/register');
        await page.waitForTimeout(3000);
        
        console.log('📸 Taking register screenshot...');
        await page.screenshot({ path: 'register_page.png', fullPage: true });
        console.log('   Register screenshot saved');
        
        // Test Login Page  
        console.log('🔑 Checking login page...');
        await page.goto('http://localhost:8000/login');
        await page.waitForTimeout(3000);
        
        console.log('📸 Taking login screenshot...');
        await page.screenshot({ path: 'login_page.png', fullPage: true });
        console.log('   Login screenshot saved');
        
        console.log('\n✅ Authentication pages check completed!');
        
    } catch (error) {
        console.error('❌ Error:', error.message);
    } finally {
        await browser.close();
    }
};

simpleAuthCheck();