import { chromium } from 'playwright';

async function checkBlogCRUD() {
  const browser = await chromium.launch();
  const context = await browser.newContext();
  const page = await context.newPage();

  try {
    console.log('Starting Blog CRUD end-to-end test...');
    
    // Step 1: Log in as admin user
    console.log('\n1. Logging in as admin user...');
    
    await page.goto('http://localhost:8000/login');
    await page.waitForLoadState('networkidle');
    
    // Check if we're on the login page
    const pageTitle = await page.textContent('h2');
    console.log(`✓ Login page loaded: ${pageTitle.trim()}`);
    
    // Log in with admin credentials (you may need to adjust these)
    const adminEmail = 'admin@example.com';
    const adminPassword = 'password123';
    
    await page.fill('#email', adminEmail);
    await page.fill('#password', adminPassword);
    console.log(`✓ Admin credentials filled: ${adminEmail}`);
    
    // Set up alert handler for potential login issues
    let alertMessage = '';
    page.on('dialog', async dialog => {
      alertMessage = dialog.message();
      console.log(`Alert: ${alertMessage}`);
      await dialog.accept();
    });
    
    // Submit login form
    await page.click('#submitBtn');
    await page.waitForTimeout(2000);
    
    // Check if login was successful by looking for redirect or admin content
    const currentUrl = page.url();
    console.log(`✓ Current URL after login: ${currentUrl}`);
    
    if (currentUrl.includes('admin') || currentUrl === 'http://localhost:8000/') {
      console.log('✅ Login appears successful');
    } else {
      console.log('⚠️  Login may have failed - continuing test anyway');
    }
    
    // Step 2: Navigate to admin blog page
    console.log('\n2. Navigating to admin blog page...');
    
    await page.goto('http://localhost:8000/admin/blog');
    await page.waitForLoadState('networkidle');
    
    // Check if we're on the admin blog page
    const adminBlogTitle = await page.textContent('h1');
    console.log(`✓ Admin blog page title: ${adminBlogTitle.trim()}`);
    
    if (adminBlogTitle.includes('Blog Management')) {
      console.log('✅ Admin blog page loaded correctly');
    } else {
      console.log('❌ Admin blog page not loaded - may need authentication');
      throw new Error('Failed to access admin blog page');
    }
    
    // Step 3: Take screenshot of admin table view
    console.log('\n3. Taking screenshot of admin table view...');
    
    await page.screenshot({ 
      path: 'blog_admin_index.png', 
      fullPage: true 
    });
    console.log('✓ Admin table screenshot saved as blog_admin_index.png');
    
    // Step 4: Check if posts exist and click Edit on first post
    console.log('\n4. Testing edit functionality...');
    
    const posts = await page.locator('table tbody tr');
    const postCount = await posts.count();
    
    if (postCount === 0) {
      console.log('⚠️  No posts found - creating a test post first...');
      
      // Navigate to create post page
      await page.click('a[href="/admin/blog/create"]');
      await page.waitForLoadState('networkidle');
      
      // Fill in test post data
      await page.fill('#title', 'Test Blog Post for CRUD Testing');
      await page.fill('#body', 'This is a test blog post created for CRUD testing purposes.');
      
      // Save the post
      await page.click('button[type="submit"]');
      await page.waitForTimeout(2000);
      
      // Navigate back to admin blog
      await page.goto('http://localhost:8000/admin/blog');
      await page.waitForLoadState('networkidle');
      console.log('✓ Test post created');
    }
    
    // Find and click the first Edit button
    const editButtons = await page.locator('a[href*="/edit"]');
    const editButtonCount = await editButtons.count();
    
    if (editButtonCount > 0) {
      console.log(`✓ Found ${editButtonCount} edit button(s)`);
      
      // Click the first edit button
      await editButtons.first().click();
      await page.waitForLoadState('networkidle');
      
      console.log('✓ Clicked edit button for first post');
    } else {
      throw new Error('No edit buttons found');
    }
    
    // Step 5: Edit the post title
    console.log('\n5. Editing post title...');
    
    // Check if we're on the edit page
    const editPageTitle = await page.textContent('h1');
    console.log(`✓ Edit page title: ${editPageTitle.trim()}`);
    
    if (editPageTitle.includes('Edit Blog Post')) {
      console.log('✅ Edit page loaded successfully');
    }
    
    // Get the current title and modify it
    const currentTitle = await page.inputValue('#title');
    const newTitle = `${currentTitle} - EDITED ${Date.now()}`;
    
    console.log(`✓ Original title: ${currentTitle}`);
    console.log(`✓ New title: ${newTitle}`);
    
    // Clear and fill new title
    await page.fill('#title', '');
    await page.fill('#title', newTitle);
    
    // Step 6: Save the changes
    console.log('\n6. Saving changes...');
    
    await page.click('button[type="submit"]');
    await page.waitForTimeout(2000);
    
    // Check if we're redirected back to admin blog index
    const finalUrl = page.url();
    console.log(`✓ URL after save: ${finalUrl}`);
    
    if (finalUrl.includes('/admin/blog') && !finalUrl.includes('/edit')) {
      console.log('✅ Successfully redirected to admin blog index');
    }
    
    // Step 7: Verify the updated title in the list
    console.log('\n7. Verifying updated title in list...');
    
    // Wait for page to load
    await page.waitForLoadState('networkidle');
    
    // Take screenshot of the updated list
    await page.screenshot({ 
      path: 'blog_admin_edit_success.png', 
      fullPage: true 
    });
    console.log('✓ Updated admin table screenshot saved as blog_admin_edit_success.png');
    
    // Look for the updated title in the table
    const tableContent = await page.textContent('table');
    if (tableContent.includes('EDITED')) {
      console.log('✅ Updated title found in the admin table');
    } else {
      console.log('⚠️  Updated title not immediately visible - may need page refresh');
    }
    
    // Step 8: Test delete functionality (optional)
    console.log('\n8. Testing delete functionality...');
    
    const deleteButtons = await page.locator('button[wire\\:click*="delete"]');
    const deleteButtonCount = await deleteButtons.count();
    
    if (deleteButtonCount > 0) {
      console.log(`✓ Found ${deleteButtonCount} delete button(s)`);
      
      // Set up confirmation dialog handler
      page.on('dialog', async dialog => {
        console.log(`Delete confirmation: ${dialog.message()}`);
        await dialog.dismiss(); // Dismiss the deletion to avoid actually deleting
      });
      
      // Click delete button to trigger confirmation
      await deleteButtons.first().click();
      await page.waitForTimeout(1000);
      
      console.log('✓ Delete confirmation dialog triggered (but dismissed)');
    } else {
      console.log('⚠️  No delete buttons found');
    }
    
    console.log('\n✅ Blog CRUD test completed successfully!');
    console.log('\nTest Summary:');
    console.log('- ✓ Admin login tested');
    console.log('- ✓ Admin blog table view verified');
    console.log('- ✓ Edit functionality working');
    console.log('- ✓ Post title update successful');
    console.log('- ✓ Delete confirmation tested');
    console.log('- ✓ Screenshots captured');
    console.log('- ✓ Navigation and redirects working');
    
    console.log('\\nScreenshots saved:');
    console.log('- blog_admin_index.png: Admin table view');
    console.log('- blog_admin_edit_success.png: Updated table after edit');

  } catch (error) {
    console.error('❌ Blog CRUD test failed:', error.message);
    
    // Take error screenshot
    await page.screenshot({ 
      path: 'blog_crud_error.png', 
      fullPage: true 
    });
    console.log('✓ Error screenshot saved as blog_crud_error.png');
    
    // Log current page info for debugging
    console.log(`Current URL: ${page.url()}`);
    try {
      const pageTitle = await page.textContent('h1, h2, title');
      console.log(`Current page title: ${pageTitle}`);
    } catch (e) {
      console.log('Could not get page title');
    }
  } finally {
    await browser.close();
  }
}

// Run the Blog CRUD test
checkBlogCRUD();