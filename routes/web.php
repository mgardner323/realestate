<?php

use App\Livewire\AboutPageManager;
use App\Livewire\AdminDashboard;
use App\Livewire\AffordabilityCalculator;
use App\Livewire\AnalyticsDashboard;
use App\Livewire\AuthPage;
use App\Livewire\CategoryManager;
use App\Livewire\CategoryPostList;
use App\Livewire\CommunityManager;
use App\Livewire\CreatePost;
use App\Livewire\EditCommunity;
use App\Livewire\CreateProperty;
use App\Livewire\EditPost;
use App\Livewire\EditProperty;
use App\Livewire\Home;
use App\Http\Controllers\InstallationController;
use App\Livewire\MlsManager;
use App\Livewire\MortgageCalculator;
use App\Livewire\PostList;
use App\Livewire\PropertyListing;
use App\Livewire\PropertyListAdmin;
use App\Livewire\PropertyDetail;
use App\Livewire\ShowAboutPage;
use App\Livewire\ShowCommunity;
use App\Livewire\ShowPost;
use App\Livewire\SiteSettings;
use App\Livewire\SubscriberList;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

Route::get('/', Home::class);
Route::get('/dashboard', function() {
    return redirect('/admin/dashboard');
})->name('dashboard');

// Installation wizard routes (only accessible when not installed)  
Route::get('/install', [App\Http\Controllers\InstallationController::class, 'show'])->name('install');
Route::post('/install', [App\Http\Controllers\InstallationController::class, 'process'])->name('install.process');

// Authentication routes
Route::get('/login', AuthPage::class)->name('login');
Route::post('/login', AuthPage::class)->name('login.post');
Route::get('/register', AuthPage::class)->name('register');
Route::post('/register', AuthPage::class)->name('register.post');
Route::post('/logout', function() {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::get('/properties', PropertyListing::class);
Route::get('/property/{property}', PropertyDetail::class);
Route::get('/mortgage-calculator', MortgageCalculator::class);
Route::get('/affordability-calculator', AffordabilityCalculator::class);
Route::get('/blog', PostList::class);
Route::get('/blog/{post:slug}', ShowPost::class);
Route::get('/news/{category:slug}', CategoryPostList::class);
Route::get('/communities/{community:slug}', ShowCommunity::class);
Route::get('/about', ShowAboutPage::class);

// Redis test route
Route::get('/redis-test', function () {
    try {
        // Test Redis connection
        $testValue = 'redis_test_' . time();
        Cache::put('test_key', $testValue, 60);
        $retrieved = Cache::get('test_key');
        
        $result = [
            'redis_connection' => $retrieved === $testValue ? 'SUCCESS' : 'FAILED',
            'test_value' => $testValue,
            'retrieved_value' => $retrieved,
        ];
        
        // Test featured properties cache
        $featuredCache = Cache::get('featured_properties');
        $result['featured_cache'] = $featuredCache ? count($featuredCache) . ' items found' : 'not found';
        
        // Clean up
        Cache::forget('test_key');
        
        return response()->json($result);
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
});

// Admin routes with middleware protection
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class);
    Route::get('/admin/analytics', AnalyticsDashboard::class);
    Route::get('/admin/properties', PropertyListAdmin::class);
    Route::get('/admin/properties/create', CreateProperty::class);
    Route::get('/admin/blog', PostList::class);
    Route::get('/admin/blog/create', CreatePost::class);
    Route::get('/admin/blog/categories', CategoryManager::class);
    Route::get('/admin/blog/{post}/edit', EditPost::class);
    Route::get('/admin/property/{property}/edit', EditProperty::class);
    Route::get('/admin/mls-providers', MlsManager::class);
    Route::get('/admin/subscribers', SubscriberList::class);
    Route::get('/admin/communities', CommunityManager::class);
    Route::get('/admin/communities/{community:slug}/edit', EditCommunity::class);
    Route::get('/admin/settings', SiteSettings::class);
    Route::get('/admin/about', AboutPageManager::class);
});

