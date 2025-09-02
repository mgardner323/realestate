<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

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