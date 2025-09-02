import { chromium } from 'playwright';

const testBlog = async () => {
    console.log('🚀 Starting blog functionality test...\n');
    
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    try {
        // Test blog listing page
        console.log('📝 Testing blog listing page...');
        await page.goto('http://localhost:8000/blog');
        await page.waitForLoadState('networkidle');
        
        // Check if blog title exists
        const blogTitle = await page.textContent('h1');
        console.log(`   Blog title: "${blogTitle}"`);
        
        // Check for blog posts
        const postCards = await page.locator('article').count();
        console.log(`   Found ${postCards} blog post(s)`);
        
        if (postCards > 0) {
            // Get first post title and link
            const firstPostTitle = await page.locator('article').first().locator('h2 a').textContent();
            const firstPostLink = await page.locator('article').first().locator('h2 a').getAttribute('href');
            console.log(`   First post: "${firstPostTitle}"`);
            console.log(`   First post link: ${firstPostLink}`);
            
            // Click on first post to test single post page
            console.log('\n📖 Testing single post page...');
            await page.locator('article').first().locator('h2 a').click();
            await page.waitForLoadState('networkidle');
            
            // Check single post elements
            const postTitle = await page.locator('h1').textContent();
            const publishDate = await page.locator('time').textContent();
            const postContent = await page.locator('.prose').textContent();
            
            console.log(`   Post title: "${postTitle}"`);
            console.log(`   Publish date: "${publishDate}"`);
            console.log(`   Content length: ${postContent?.length || 0} characters`);
            
            // Check for featured image if exists
            const featuredImage = await page.locator('img').first();
            if (await featuredImage.count() > 0) {
                const imageSrc = await featuredImage.getAttribute('src');
                console.log(`   Featured image: ${imageSrc}`);
            }
            
            // Test back navigation
            console.log('\n🔙 Testing navigation...');
            await page.locator('a:has-text("Back to Blog")').first().click();
            await page.waitForLoadState('networkidle');
            
            const backToBlogTitle = await page.locator('h1').textContent();
            console.log(`   Back to blog - title: "${backToBlogTitle}"`);
        }
        
        console.log('\n✅ Blog functionality test completed successfully!');
        
    } catch (error) {
        console.error('\n❌ Test failed:', error.message);
    } finally {
        await browser.close();
    }
};

testBlog();