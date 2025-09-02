import { chromium } from 'playwright';

const finalBlogCheck = async () => {
    console.log('🔍 Final comprehensive blog verification...\n');
    
    const browser = await chromium.launch({ headless: true });
    const context = await browser.newContext();
    const page = await context.newPage();
    
    const results = {
        blogIndex: false,
        postsVisible: false,
        singlePost: false,
        navigation: false,
        featuredImages: false
    };
    
    try {
        // 1. Test blog index page
        console.log('1️⃣ Testing blog index page...');
        await page.goto('http://localhost:8000/blog', { waitUntil: 'networkidle' });
        
        const title = await page.textContent('h1');
        if (title?.includes('Blog')) {
            results.blogIndex = true;
            console.log('   ✅ Blog index loads correctly');
        }
        
        // 2. Check for posts
        console.log('2️⃣ Checking for blog posts...');
        const postCount = await page.locator('article').count();
        if (postCount > 0) {
            results.postsVisible = true;
            console.log(`   ✅ Found ${postCount} blog posts`);
            
            // Check first post has required elements
            const firstPost = page.locator('article').first();
            const hasTitle = await firstPost.locator('h2').count() > 0;
            const hasExcerpt = await firstPost.locator('p').count() > 0;
            const hasDate = await firstPost.locator('span').count() > 0;
            const hasReadMore = await firstPost.locator('a:has-text("Read More")').count() > 0;
            
            console.log(`   ✅ Post elements: title(${hasTitle}), excerpt(${hasExcerpt}), date(${hasDate}), readMore(${hasReadMore})`);
        }
        
        // 3. Test single post page
        console.log('3️⃣ Testing single post page...');
        if (postCount > 0) {
            await page.locator('article').first().locator('h2 a').click();
            await page.waitForLoadState('networkidle');
            
            const postTitle = await page.locator('h1').textContent();
            const hasContent = await page.locator('.prose').count() > 0;
            const hasPublishDate = await page.locator('time').count() > 0;
            
            if (postTitle && hasContent && hasPublishDate) {
                results.singlePost = true;
                console.log('   ✅ Single post page works correctly');
                console.log(`   📄 Post: "${postTitle.trim()}"`);
            }
            
            // Check for featured image
            const imageCount = await page.locator('img').count();
            if (imageCount > 0) {
                results.featuredImages = true;
                console.log('   ✅ Featured images working');
            }
        }
        
        // 4. Test navigation
        console.log('4️⃣ Testing navigation...');
        const backLinks = await page.locator('a:has-text("Back to Blog")').count();
        if (backLinks > 0) {
            await page.locator('a:has-text("Back to Blog")').first().click();
            await page.waitForLoadState('networkidle');
            
            const backToIndex = await page.textContent('h1');
            if (backToIndex?.includes('Blog')) {
                results.navigation = true;
                console.log('   ✅ Navigation working correctly');
            }
        }
        
        // 5. Test home page navigation
        console.log('5️⃣ Testing home navigation...');
        await page.goto('http://localhost:8000/', { waitUntil: 'networkidle' });
        const homeLoads = await page.locator('h1').count() > 0;
        console.log(`   ✅ Home page loads: ${homeLoads}`);
        
        // Summary
        console.log('\n📊 FINAL VERIFICATION RESULTS:');
        console.log('================================');
        Object.entries(results).forEach(([test, passed]) => {
            console.log(`   ${passed ? '✅' : '❌'} ${test}: ${passed ? 'PASSED' : 'FAILED'}`);
        });
        
        const allPassed = Object.values(results).every(r => r);
        console.log(`\n🎯 Overall Status: ${allPassed ? '✅ ALL TESTS PASSED - BLOG COMPLETE!' : '❌ Some tests failed'}`);
        
    } catch (error) {
        console.error('\n❌ Verification failed:', error.message);
    } finally {
        await browser.close();
    }
};

finalBlogCheck();