<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API is working']);
});

// Protected API routes for N8N automation
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/posts', [PostController::class, 'store']);
    
    // Test authentication endpoint
    Route::get('/v1/test', function () {
        return response()->json([
            'success' => true,
            'message' => 'Authentication successful!',
            'user' => auth()->user()->only(['id', 'name', 'email', 'role'])
        ]);
    });
});