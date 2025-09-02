<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // MLS Integration Fields
            $table->foreignId('mls_provider_id')->nullable()->constrained('mls_providers')->onDelete('set null')->after('id');
            $table->string('mls_listing_id')->nullable()->after('mls_provider_id');
            
            // Data Integrity and Syncing
            $table->json('raw_data')->nullable()->comment('Original JSON payload from the provider.')->after('location');
            $table->timestamp('last_synced_at')->nullable()->after('raw_data');
            
            // CRITICAL: This prevents duplicate listings from the same provider.
            $table->unique(['mls_provider_id', 'mls_listing_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropUnique(['mls_provider_id', 'mls_listing_id']);
            $table->dropColumn(['mls_provider_id', 'mls_listing_id', 'raw_data', 'last_synced_at']);
        });
    }
};
