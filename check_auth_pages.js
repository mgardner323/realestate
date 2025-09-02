import { chromium } from 'playwright';

const checkAuthPages = async () => {
    console.log('🔐 Testing Laravel Breeze Authentication Pages...\n');
    
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Test Register Page
        console.log('📝 Testing Register page (/register)...');
        await page.goto('http://localhost:8000/register');
        await page.waitForLoadState('networkidle');
        
        // Check if register page loaded correctly
        const registerTitle = await page.locator('h2, h1').first().textContent();
        console.log(`   Register page title: "${registerTitle}"`);
        
        // Check for expected form elements
        const nameInput = await page.locator('input[name="name"]').count();
        const emailInput = await page.locator('input[name="email"]').count();
        const passwordInput = await page.locator('input[name="password"]').count();
        const confirmPasswordInput = await page.locator('input[name="password_confirmation"]').count();
        const registerButton = await page.locator('button[type="submit"], input[type="submit"]').count();
        
        console.log(`   Form elements found:`);
        console.log(`     - Name input: ${nameInput > 0 ? '✅' : '❌'}`);
        console.log(`     - Email input: ${emailInput > 0 ? '✅' : '❌'}`);
        console.log(`     - Password input: ${passwordInput > 0 ? '✅' : '❌'}`);
        console.log(`     - Confirm password input: ${confirmPasswordInput > 0 ? '✅' : '❌'}`);
        console.log(`     - Register button: ${registerButton > 0 ? '✅' : '❌'}`);
        
        // Take register page screenshot
        console.log('📸 Taking register page screenshot...');
        await page.screenshot({ 
            path: 'register_page.png', 
            fullPage: true 
        });
        console.log('   Register screenshot saved as: register_page.png');
        
        // Test Login Page
        console.log('\n🔑 Testing Login page (/login)...');
        await page.goto('http://localhost:8000/login');
        await page.waitForLoadState('networkidle');
        
        // Check if login page loaded correctly
        const loginTitle = await page.locator('h2, h1').first().textContent();
        console.log(`   Login page title: "${loginTitle}"`);
        
        // Check for expected form elements
        const loginEmailInput = await page.locator('input[name="email"]').count();
        const loginPasswordInput = await page.locator('input[name="password"]').count();
        const rememberCheckbox = await page.locator('input[name="remember"]').count();
        const loginButton = await page.locator('button[type="submit"], input[type="submit"]').count();
        const forgotPasswordLink = await page.locator('a:has-text("Forgot"), a:has-text("forgot")').count();
        
        console.log(`   Form elements found:`);
        console.log(`     - Email input: ${loginEmailInput > 0 ? '✅' : '❌'}`);
        console.log(`     - Password input: ${loginPasswordInput > 0 ? '✅' : '❌'}`);
        console.log(`     - Remember checkbox: ${rememberCheckbox > 0 ? '✅' : '❌'}`);
        console.log(`     - Login button: ${loginButton > 0 ? '✅' : '❌'}`);
        console.log(`     - Forgot password link: ${forgotPasswordLink > 0 ? '✅' : '❌'}`);
        
        // Take login page screenshot
        console.log('📸 Taking login page screenshot...');
        await page.screenshot({ 
            path: 'login_page.png', 
            fullPage: true 
        });
        console.log('   Login screenshot saved as: login_page.png');
        
        // Test navigation links between pages
        console.log('\n🔗 Testing navigation between auth pages...');
        
        // Look for link to register from login page
        const linkToRegister = await page.locator('a:has-text("register"), a:has-text("Register"), a:has-text("Sign up")').count();
        if (linkToRegister > 0) {
            console.log('   ✅ Link to register page found from login');
            await page.locator('a:has-text("register"), a:has-text("Register"), a:has-text("Sign up")').first().click();
            await page.waitForLoadState('networkidle');
            
            // Check if we're back on register page
            const backToRegister = page.url().includes('/register');
            console.log(`   Navigation to register: ${backToRegister ? '✅' : '❌'}`);
            
            // Look for link back to login
            const linkToLogin = await page.locator('a:has-text("login"), a:has-text("Login"), a:has-text("Sign in")').count();
            console.log(`   Link to login from register: ${linkToLogin > 0 ? '✅' : '❌'}`);
        }
        
        // Test that our main site is still accessible
        console.log('\n🏠 Testing main site accessibility...');
        await page.goto('http://localhost:8000/');
        await page.waitForLoadState('networkidle');
        
        const mainSiteTitle = await page.locator('h1').first().textContent();
        console.log(`   Main site title: "${mainSiteTitle}"`);
        console.log(`   Main site accessible: ${mainSiteTitle?.includes('Dream Home') ? '✅' : '❌'}`);
        
        console.log('\n🎉 Authentication pages test completed!');
        
    } catch (error) {
        console.error('\n❌ Test failed:', error.message);
        
        // Take error screenshot
        try {
            await page.screenshot({ path: 'auth_pages_error.png', fullPage: true });
            console.log('Error screenshot saved as: auth_pages_error.png');
        } catch (screenshotError) {
            console.error('Could not save error screenshot:', screenshotError.message);
        }
    } finally {
        await browser.close();
    }
};

checkAuthPages();