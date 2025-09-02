<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateAiPost;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Create a new blog post via API for N8N automation
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'generate_seo' => 'nullable|boolean',
            'generate_image' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $title = $request->input('title');
            $generateSeo = $request->input('generate_seo', false);
            $generateImage = $request->input('generate_image', false);
            
            // Step 1: Create the initial post with placeholder content
            $post = Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'body' => 'Placeholder content - AI generation in progress...',
                'category_id' => $request->input('category_id'),
                'is_published' => $request->input('is_published', true),
            ]);

            // Step 2: Dispatch the AI generation job
            GenerateAiPost::dispatch($post, $generateSeo, $generateImage);
            
            // Prepare the operations that will be queued
            $queuedOperations = ['content_generation'];
            if ($generateSeo) {
                $queuedOperations[] = 'seo_generation';
            }
            if ($generateImage) {
                $queuedOperations[] = 'image_generation';
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Blog post created and AI generation job queued successfully',
                'data' => [
                    'post' => [
                        'id' => $post->id,
                        'title' => $post->title,
                        'slug' => $post->slug,
                        'body' => $post->body,
                        'category_id' => $post->category_id,
                        'is_published' => $post->is_published,
                        'meta_title' => $post->meta_title,
                        'meta_description' => $post->meta_description,
                        'featured_image_url' => $post->featured_image_url,
                        'created_at' => $post->created_at,
                        'updated_at' => $post->updated_at,
                    ],
                    'job_status' => 'queued',
                    'queued_operations' => $queuedOperations,
                    'ai_powered' => true,
                    'note' => 'Content will be generated asynchronously. Check back in a few minutes for the AI-generated content.'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
