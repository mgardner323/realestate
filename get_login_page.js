import { chromium } from 'playwright';

(async () => {
    const browser = await chromium.launch({ headless: true });
    const page = await browser.newPage();
    
    console.log('Getting login page...');
    await page.goto('http://localhost:8000/login');
    await page.waitForTimeout(2000);
    
    await page.screenshot({ path: 'login_page.png', fullPage: true });
    console.log('Login page screenshot saved!');
    
    await browser.close();
})();