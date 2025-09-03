<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class InstallationController extends Controller
{
    protected $totalSteps = 3;

    public function show(Request $request)
    {
        // Initialize session data if not exists
        if (!$request->session()->has('installation')) {
            $request->session()->put('installation', [
                'currentStep' => 1,
                'agencyName' => 'Real Estate Agency',
                'agencyEmail' => 'info@realestate.com',
                'agencyPhone' => '',
                'agencyAddress' => '',
                'brandPrimaryColor' => '#3B82F6',
                'brandSecondaryColor' => '#1E40AF',
                'seoTitle' => 'Premium Real Estate Platform',
                'seoDescription' => 'Find your dream property with our comprehensive real estate platform featuring advanced search, analytics, and modern design.',
                'adminName' => '',
                'adminEmail' => '',
                'adminPassword' => '',
                'adminPasswordConfirmation' => '',
            ]);
        }

        $installation = $request->session()->get('installation');
        return view('installation.wizard', compact('installation'));
    }

    public function process(Request $request)
    {
        $action = $request->input('action');
        $installation = $request->session()->get('installation');

        switch ($action) {
            case 'next':
                return $this->nextStep($request);
            case 'previous':
                return $this->previousStep($request);
            case 'finish':
                return $this->finishInstallation($request);
            default:
                return redirect()->route('install');
        }
    }

    protected function nextStep(Request $request)
    {
        $installation = $request->session()->get('installation');
        $currentStep = $installation['currentStep'];

        // Validate current step
        $validator = $this->validateCurrentStep($request, $currentStep);
        if ($validator->fails()) {
            return redirect()->route('install')
                ->withErrors($validator)
                ->withInput();
        }

        // Save form data to session
        $this->saveStepData($request, $currentStep);

        // Advance to next step
        if ($currentStep < $this->totalSteps) {
            $installation['currentStep'] = $currentStep + 1;
            $request->session()->put('installation', $installation);
        }

        return redirect()->route('install')->with('success', 'Step completed successfully!');
    }

    protected function previousStep(Request $request)
    {
        $installation = $request->session()->get('installation');
        
        if ($installation['currentStep'] > 1) {
            $installation['currentStep']--;
            $request->session()->put('installation', $installation);
        }

        return redirect()->route('install');
    }

    protected function finishInstallation(Request $request)
    {
        // Validate final step
        $validator = $this->validateCurrentStep($request, 3);
        if ($validator->fails()) {
            return redirect()->route('install')
                ->withErrors($validator)
                ->withInput();
        }

        // Save final step data
        $this->saveStepData($request, 3);
        $installation = $request->session()->get('installation');

        try {
            // Create admin user
            $admin = User::create([
                'name' => $installation['adminName'],
                'email' => $installation['adminEmail'],
                'password' => Hash::make($installation['adminPassword']),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);

            // Save installation data to settings table
            \App\Models\Setting::updateOrCreate(['key' => 'agency_name'], ['value' => $installation['agencyName']]);
            \App\Models\Setting::updateOrCreate(['key' => 'agency_email'], ['value' => $installation['agencyEmail']]);
            \App\Models\Setting::updateOrCreate(['key' => 'agency_phone'], ['value' => $installation['agencyPhone']]);
            \App\Models\Setting::updateOrCreate(['key' => 'agency_address'], ['value' => $installation['agencyAddress']]);
            \App\Models\Setting::updateOrCreate(['key' => 'brand_primary_color'], ['value' => $installation['brandPrimaryColor']]);
            \App\Models\Setting::updateOrCreate(['key' => 'brand_secondary_color'], ['value' => $installation['brandSecondaryColor']]);
            \App\Models\Setting::updateOrCreate(['key' => 'seo_title'], ['value' => $installation['seoTitle']]);
            \App\Models\Setting::updateOrCreate(['key' => 'seo_description'], ['value' => $installation['seoDescription']]);

            // Update environment file
            $this->updateEnvironmentFile($installation);

            // Create .installed file
            File::put(base_path('.installed'), json_encode([
                'installed_at' => now()->toISOString(),
                'version' => '1.0.0',
                'admin_email' => $installation['adminEmail'],
            ], JSON_PRETTY_PRINT));

            // Clear caches
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            // Clear installation session
            $request->session()->forget('installation');

            return redirect()->route('login')
                ->with('success', 'Installation completed successfully! Please log in with your admin credentials.');

        } catch (\Exception $e) {
            return redirect()->route('install')
                ->with('error', 'Installation failed: ' . $e->getMessage());
        }
    }

    protected function validateCurrentStep(Request $request, int $step)
    {
        $rules = [];

        switch ($step) {
            case 1:
                $rules = [
                    'agencyName' => 'required|string|max:255',
                    'agencyEmail' => 'required|email|max:255',
                    'agencyPhone' => 'nullable|string|max:50',
                    'agencyAddress' => 'nullable|string|max:500',
                ];
                break;
            case 2:
                $rules = [
                    'brandPrimaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
                    'brandSecondaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
                    'seoTitle' => 'required|string|max:255',
                    'seoDescription' => 'required|string|max:500',
                ];
                break;
            case 3:
                $rules = [
                    'adminName' => 'required|string|max:255',
                    'adminEmail' => 'required|email|max:255|unique:users,email',
                    'adminPassword' => 'required|string|min:8',
                    'adminPasswordConfirmation' => 'required|same:adminPassword',
                ];
                break;
        }

        return Validator::make($request->all(), $rules);
    }

    protected function saveStepData(Request $request, int $step)
    {
        $installation = $request->session()->get('installation');

        switch ($step) {
            case 1:
                $installation['agencyName'] = $request->input('agencyName');
                $installation['agencyEmail'] = $request->input('agencyEmail');
                $installation['agencyPhone'] = $request->input('agencyPhone');
                $installation['agencyAddress'] = $request->input('agencyAddress');
                break;
            case 2:
                $installation['brandPrimaryColor'] = $request->input('brandPrimaryColor');
                $installation['brandSecondaryColor'] = $request->input('brandSecondaryColor');
                $installation['seoTitle'] = $request->input('seoTitle');
                $installation['seoDescription'] = $request->input('seoDescription');
                break;
            case 3:
                $installation['adminName'] = $request->input('adminName');
                $installation['adminEmail'] = $request->input('adminEmail');
                $installation['adminPassword'] = $request->input('adminPassword');
                $installation['adminPasswordConfirmation'] = $request->input('adminPasswordConfirmation');
                break;
        }

        $request->session()->put('installation', $installation);
    }

    protected function updateEnvironmentFile(array $installation)
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $updates = [
            'SITE_INSTALLED' => 'true',
            'SITE_AGENCY_NAME' => $installation['agencyName'],
            'SITE_AGENCY_EMAIL' => $installation['agencyEmail'],
            'SITE_AGENCY_PHONE' => $installation['agencyPhone'],
            'SITE_AGENCY_ADDRESS' => $installation['agencyAddress'],
            'SITE_BRAND_PRIMARY_COLOR' => $installation['brandPrimaryColor'],
            'SITE_BRAND_SECONDARY_COLOR' => $installation['brandSecondaryColor'],
            'SITE_SEO_TITLE' => $installation['seoTitle'],
            'SITE_SEO_DESCRIPTION' => $installation['seoDescription'],
        ];

        foreach ($updates as $key => $value) {
            $pattern = "/^{$key}=.*$/m";
            $replacement = "{$key}=\"{$value}\"";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        File::put($envPath, $envContent);
    }
}