<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GeminiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        // We can add more robust config handling later
        $this->baseUrl = 'http://localhost:8080';
    }

    public function generateBlogPost(string $title): string
    {
        $prompt = "Write a full, engaging, and SEO-friendly blog post about the topic: '{$title}'. Include headings and paragraphs.";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful()) {
            return $response->json('response', 'Error: Could not generate content.');
        }

        return 'Error: Failed to connect to the AI service.';
    }

    public function generatePropertyDescription(array $propertyData): string
    {
        $prompt = "Write a compelling and professional real estate property description based on the following details: " .
                  "Title: {$propertyData['title']}, " .
                  "Location: {$propertyData['location']}, " .
                  "Price: {$propertyData['price']}. " .
                  "Highlight its key features and create an appealing narrative for potential buyers.";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful()) {
            return $response->json('response', 'Error: Could not generate description.');
        }

        return 'Error: Failed to connect to the AI service.';
    }

    public function generateSeoTags(string $postBody): array
    {
        $prompt = "Analyze the following blog post content and generate SEO-optimized meta tags. Provide a concise but compelling meta title (around 60 characters) and a meta description (around 155 characters). Return the output as a JSON object with two keys: 'meta_title' and 'meta_description'.\n\nContent: {$postBody}";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful() && $response->json('response')) {
            // Attempt to decode the JSON string within the response
            $jsonResponse = json_decode($response->json('response'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return [
                    'meta_title' => $jsonResponse['meta_title'] ?? '',
                    'meta_description' => $jsonResponse['meta_description'] ?? '',
                ];
            }
        }
        
        return ['meta_title' => '', 'meta_description' => ''];
    }

    public function generateFeaturedImage(string $postBody): ?string
    {
        // Step 1: Generate an image prompt from the blog post content using Gemini MCP
        $imagePrompt = $this->generateImagePrompt($postBody);
        
        if (empty($imagePrompt)) {
            return null;
        }

        // Step 2: Use the prompt to generate an image with Google Cloud Vertex AI Imagen
        return $this->generateImageWithVertexAI($imagePrompt);
    }

    protected function generateImagePrompt(string $postBody): ?string
    {
        $prompt = "Based on the following blog post content, generate a detailed, descriptive prompt that would be suitable for creating a compelling featured image using an AI image generation model. The prompt should be visual, specific, and professional. Focus on creating an image that would make someone want to read the blog post.\n\nBlog content: {$postBody}\n\nReturn only the image generation prompt, nothing else.";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful()) {
            return trim($response->json('response', ''));
        }

        return null;
    }

    protected function generateImageWithVertexAI(string $imagePrompt): ?string
    {
        try {
            // Create the Google Cloud AI Platform client
            $projectId = config('services.google.project_id');
            $location = config('services.google.location');
            
            if (empty($projectId) || empty($location)) {
                throw new \Exception('Google Cloud configuration missing');
            }

            // Prepare the request data for Vertex AI Imagen API
            $endpoint = "https://{$location}-aiplatform.googleapis.com/v1/projects/{$projectId}/locations/{$location}/publishers/google/models/imagegeneration@006:predict";
            
            // Get the service account credentials
            $credentialsPath = storage_path('app/gcp-credentials.json');
            
            if (!file_exists($credentialsPath)) {
                throw new \Exception('Google Cloud credentials file not found');
            }

            // Get access token using the service account
            $accessToken = $this->getAccessToken($credentialsPath);
            
            if (empty($accessToken)) {
                throw new \Exception('Failed to get access token');
            }

            // Prepare the request payload
            $payload = [
                'instances' => [
                    [
                        'prompt' => $imagePrompt
                    ]
                ],
                'parameters' => [
                    'sampleCount' => 1
                ]
            ];

            // Make the API call to Vertex AI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($endpoint, $payload);

            if (!$response->successful()) {
                throw new \Exception('Vertex AI API call failed: ' . $response->body());
            }

            $responseData = $response->json();
            
            if (!isset($responseData['predictions'][0]['bytesBase64Encoded'])) {
                throw new \Exception('Invalid response from Vertex AI');
            }

            // Decode the base64 image data
            $base64Image = $responseData['predictions'][0]['bytesBase64Encoded'];
            $imageData = base64_decode($base64Image);

            // Generate a unique filename
            $filename = 'featured_images/' . Str::random(20) . '.png';

            // Save the image to storage
            Storage::disk('public')->put($filename, $imageData);

            // Return the public path
            return 'storage/' . $filename;

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Featured image generation failed: ' . $e->getMessage());
            return null;
        }
    }

    protected function getAccessToken(string $credentialsPath): ?string
    {
        try {
            $credentials = json_decode(file_get_contents($credentialsPath), true);
            
            if (!$credentials) {
                throw new \Exception('Invalid credentials file');
            }

            // Create JWT token for service account authentication
            $now = time();
            $header = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
            $payload = json_encode([
                'iss' => $credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/cloud-platform',
                'aud' => 'https://oauth2.googleapis.com/token',
                'exp' => $now + 3600,
                'iat' => $now
            ]);

            $headerEncoded = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');
            $payloadEncoded = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
            $signature = '';

            // Sign the JWT using the private key
            $privateKey = openssl_pkey_get_private($credentials['private_key']);
            openssl_sign($headerEncoded . '.' . $payloadEncoded, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $signatureEncoded = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

            $jwt = $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;

            // Exchange JWT for access token
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]);

            if ($tokenResponse->successful()) {
                $tokenData = $tokenResponse->json();
                return $tokenData['access_token'] ?? null;
            }

            throw new \Exception('Token exchange failed: ' . $tokenResponse->body());

        } catch (\Exception $e) {
            \Log::error('Access token generation failed: ' . $e->getMessage());
            return null;
        }
    }

    public function generateCommunityStats(string $communityName): string
    {
        $prompt = "Generate detailed statistical and demographic information for the community of {$communityName}, formatted in clean HTML. Include population data, median income, age demographics, education levels, housing statistics, and other relevant community metrics. Format this as professional, readable HTML with proper headings and structure.";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful()) {
            return $response->json('response', 'Error: Could not generate community statistics.');
        }

        return 'Error: Failed to connect to the AI service.';
    }

    public function generateCommunityEvents(string $communityName): string
    {
        $prompt = "Generate a list of community events happening in {$communityName} for the current month, formatted as an HTML unordered list. Include a variety of events such as local festivals, farmers markets, community meetings, recreational activities, cultural events, and family-friendly activities. Make the events realistic and engaging for community members.";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful()) {
            return $response->json('response', 'Error: Could not generate community events.');
        }

        return 'Error: Failed to connect to the AI service.';
    }

    public function enhanceText(string $text): string
    {
        $prompt = "Please rewrite the following text to be more professional, engaging, and suitable for a real estate agency's About Us page. Make it sound trustworthy, experienced, and customer-focused while maintaining the original meaning and key information. The text should inspire confidence in potential clients and highlight expertise in real estate services.\n\nOriginal text: {$text}";

        $response = Http::post("{$this->baseUrl}/query", ['prompt' => $prompt]);

        if ($response->successful()) {
            return $response->json('response', 'Error: Could not enhance text.');
        }

        return 'Error: Failed to connect to the AI service.';
    }
}