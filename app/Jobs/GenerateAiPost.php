<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\GeminiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateAiPost implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected Post $post;
    protected bool $generateSeo;
    protected bool $generateImage;

    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, bool $generateSeo = false, bool $generateImage = false)
    {
        $this->post = $post;
        $this->generateSeo = $generateSeo;
        $this->generateImage = $generateImage;
    }

    /**
     * Execute the job.
     */
    public function handle(GeminiService $geminiService): void
    {
        try {
            // Step 1: Generate blog post content if not already generated
            if (empty($this->post->body) || str_contains($this->post->body, 'Placeholder content')) {
                $body = $geminiService->generateBlogPost($this->post->title);
                
                if (!empty($body) && !str_contains($body, 'Error:')) {
                    $this->post->update(['body' => $body]);
                }
            }

            // Step 2: Generate SEO tags if requested
            if ($this->generateSeo && !empty($this->post->body)) {
                $seoTags = $geminiService->generateSeoTags($this->post->body);
                if (!empty($seoTags['meta_title']) && !empty($seoTags['meta_description'])) {
                    $this->post->update([
                        'meta_title' => $seoTags['meta_title'],
                        'meta_description' => $seoTags['meta_description'],
                    ]);
                }
            }

            // Step 3: Generate featured image if requested
            if ($this->generateImage && !empty($this->post->body)) {
                $imagePath = $geminiService->generateFeaturedImage($this->post->body);
                if ($imagePath) {
                    $this->post->update(['featured_image_url' => $imagePath]);
                }
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('AI Post Generation Job failed: ' . $e->getMessage(), [
                'post_id' => $this->post->id,
                'generate_seo' => $this->generateSeo,
                'generate_image' => $this->generateImage,
                'error' => $e->getTraceAsString()
            ]);
            
            // Re-throw the exception to mark the job as failed
            throw $e;
        }
    }

    /**
     * Calculate the number of seconds the job can run before timing out.
     */
    public function timeout(): int
    {
        return 300; // 5 minutes timeout
    }

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [30, 60, 120]; // Wait 30s, 1min, 2min between retries
    }
}
