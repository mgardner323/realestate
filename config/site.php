<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Site Configuration
    |--------------------------------------------------------------------------
    |
    | This file stores the site-specific configuration after installation.
    | These values are set during the installation wizard process.
    |
    */

    'installed' => env('SITE_INSTALLED', false),

    'agency_name' => env('SITE_AGENCY_NAME', 'Real Estate Agency'),
    'agency_email' => env('SITE_AGENCY_EMAIL', 'info@realestate.com'),
    'agency_phone' => env('SITE_AGENCY_PHONE', ''),
    'agency_address' => env('SITE_AGENCY_ADDRESS', ''),

    'brand_primary_color' => env('SITE_BRAND_PRIMARY_COLOR', '#3B82F6'),
    'brand_secondary_color' => env('SITE_BRAND_SECONDARY_COLOR', '#1E40AF'),
    'brand_logo' => env('SITE_BRAND_LOGO', ''),

    'seo_title' => env('SITE_SEO_TITLE', 'Real Estate Platform'),
    'seo_description' => env('SITE_SEO_DESCRIPTION', 'Find your dream property with our comprehensive real estate platform.'),
    'seo_keywords' => env('SITE_SEO_KEYWORDS', 'real estate, properties, homes, apartments, buy, sell, rent'),

    'features_enabled' => [
        'elasticsearch' => env('FEATURE_ELASTICSEARCH', true),
        'firebase' => env('FEATURE_FIREBASE', true),
        'newsletter' => env('FEATURE_NEWSLETTER', true),
        'blog' => env('FEATURE_BLOG', true),
        'analytics' => env('FEATURE_ANALYTICS', true),
    ],
];