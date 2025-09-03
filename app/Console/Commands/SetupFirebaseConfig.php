<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SetupFirebaseConfig extends Command
{
    protected $signature = 'firebase:setup';
    protected $description = 'Setup Firebase configuration in database';

    public function handle()
    {
        $this->info('🔥 Setting up Firebase configuration in database...');

        $firebaseConfig = [
            'firebase_api_key' => 'AIzaSyA_ZV4y_2dX19iV-gLfurbDGNudKYJn-sI',
            'firebase_auth_domain' => 'laravel-real-estate-agen-19b83.firebaseapp.com',
            'firebase_project_id' => 'laravel-real-estate-agen-19b83',
            'firebase_storage_bucket' => 'laravel-real-estate-agen-19b83.firebasestorage.app',
            'firebase_messaging_sender_id' => '408566989784',
            'firebase_app_id' => '1:408566989784:web:2d1172965603d6278228ad',
            'firebase_measurement_id' => 'G-4S1G3D01YJ'
        ];

        foreach ($firebaseConfig as $key => $value) {
            Setting::set($key, $value);
            $this->info("✅ Set {$key}");
        }

        $this->info('🎉 Firebase configuration successfully stored in database!');
        
        // Display current configuration
        $this->info('');
        $this->info('📋 Current Firebase Configuration:');
        $this->line('=========================================');
        
        foreach ($firebaseConfig as $key => $value) {
            $displayValue = strlen($value) > 50 ? substr($value, 0, 30) . '...' : $value;
            $this->line("{$key}: {$displayValue}");
        }
        
        return 0;
    }
}