<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;

class InstallationWizard extends Component
{
    use WithFileUploads;

    // Step management
    public $currentStep = 1;
    public $totalSteps = 3;

    // Step 1: Agent Profile
    public $agencyName = '';
    public $agencyEmail = '';
    public $agencyPhone = '';
    public $agencyAddress = '';

    // Step 2: Branding
    public $brandPrimaryColor = '#3B82F6';
    public $brandSecondaryColor = '#1E40AF';
    public $seoTitle = '';
    public $seoDescription = '';

    // Step 3: Admin Account
    public $adminName = '';
    public $adminEmail = '';
    public $adminPassword = '';
    public $adminPasswordConfirmation = '';

    public $isProcessing = false;

    protected $rules = [
        // Step 1
        'agencyName' => 'required|string|max:255',
        'agencyEmail' => 'required|email|max:255',
        'agencyPhone' => 'nullable|string|max:50',
        'agencyAddress' => 'nullable|string|max:500',
        
        // Step 2  
        'brandPrimaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
        'brandSecondaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
        'seoTitle' => 'required|string|max:255',
        'seoDescription' => 'required|string|max:500',
        
        // Step 3
        'adminName' => 'required|string|max:255',
        'adminEmail' => 'required|email|max:255',
        'adminPassword' => 'required|string|min:8|confirmed',
        'adminPasswordConfirmation' => 'required',
    ];

    public function mount()
    {
        // Load data from session if available
        $wizardData = session('wizard_data', []);
        
        // Step 1 data
        $this->agencyName = $wizardData['agency_name'] ?? 'Real Estate Agency';
        $this->agencyEmail = $wizardData['agency_email'] ?? 'info@realestate.com';
        $this->agencyPhone = $wizardData['agency_phone'] ?? '';
        $this->agencyAddress = $wizardData['agency_address'] ?? '';
        
        // Step 2 data
        $this->brandPrimaryColor = $wizardData['brand_primary_color'] ?? '#3B82F6';
        $this->brandSecondaryColor = $wizardData['brand_secondary_color'] ?? '#1E40AF';
        $this->seoTitle = $wizardData['seo_title'] ?? 'Premium Real Estate Platform';
        $this->seoDescription = $wizardData['seo_description'] ?? 'Find your dream property with our comprehensive real estate platform featuring advanced search, analytics, and modern design.';
        
        // Step 3 data
        $this->adminName = $wizardData['admin_name'] ?? '';
        $this->adminEmail = $wizardData['admin_email'] ?? '';
        // Note: We do not restore passwords from session for security
        
        // Restore current step if available
        $this->currentStep = $wizardData['current_step'] ?? 1;
    }

    // Save data to session whenever properties change
    public function updated($propertyName, $value)
    {
        $this->saveCurrentStepToSession();
    }

    private function saveCurrentStepToSession()
    {
        $currentData = session('wizard_data', []);
        
        // Always save current step
        $currentData['current_step'] = $this->currentStep;
        
        // Save all current form data
        $currentData['agency_name'] = $this->agencyName;
        $currentData['agency_email'] = $this->agencyEmail;
        $currentData['agency_phone'] = $this->agencyPhone;
        $currentData['agency_address'] = $this->agencyAddress;
        
        $currentData['brand_primary_color'] = $this->brandPrimaryColor;
        $currentData['brand_secondary_color'] = $this->brandSecondaryColor;
        $currentData['seo_title'] = $this->seoTitle;
        $currentData['seo_description'] = $this->seoDescription;
        
        $currentData['admin_name'] = $this->adminName;
        $currentData['admin_email'] = $this->adminEmail;
        
        session(['wizard_data' => $currentData]);
    }

    public function submitCurrentStep()
    {
        logger()->info('submitCurrentStep called, current step: ' . $this->currentStep);
        
        if ($this->currentStep == $this->totalSteps) {
            return $this->finish();
        } else {
            return $this->nextStep();
        }
    }

    public function nextStep()
    {
        // Validate current step first
        if ($this->currentStep == 1) {
            $this->validate([
                'agencyName' => 'required|string|max:255',
                'agencyEmail' => 'required|email|max:255',
                'agencyPhone' => 'nullable|string|max:50',
                'agencyAddress' => 'nullable|string|max:500',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'brandPrimaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'brandSecondaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'seoTitle' => 'required|string|max:255',
                'seoDescription' => 'required|string|max:500',
            ]);
        }
        
        // Save current data to session
        $this->saveCurrentStepToSession();
        
        // Advance step
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->saveCurrentStepToSession();
        }
    }

    public function previousStep()
    {
        // Save current data before going back
        $this->saveCurrentStepToSession();
        
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->saveCurrentStepToSession();
        }
    }

    public function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'agencyName' => 'required|string|max:255',
                'agencyEmail' => 'required|email|max:255',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'brandPrimaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'brandSecondaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'seoTitle' => 'required|string|max:255',
                'seoDescription' => 'required|string|max:500',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'adminName' => 'required|string|max:255',
                'adminEmail' => 'required|email|max:255',
                'adminPassword' => 'required|string|min:8|confirmed',
            ]);
        }
    }

    public function finish()
    {
        $this->isProcessing = true;
        
        try {
            // Validate final step
            $this->validate([
                'adminName' => 'required|string|max:255',
                'adminEmail' => 'required|email|max:255',
                'adminPassword' => 'required|string|min:8|confirmed',
            ]);
            
            // Save current data including admin credentials
            $currentData = session('wizard_data', []);
            $currentData['admin_name'] = $this->adminName;
            $currentData['admin_email'] = $this->adminEmail;
            $currentData['admin_password'] = $this->adminPassword;
            session(['wizard_data' => $currentData]);
            
            // Get all data from session
            $wizardData = session('wizard_data', []);
            
            // Create admin user
            $admin = User::create([
                'name' => $wizardData['admin_name'],
                'email' => $wizardData['admin_email'],
                'password' => Hash::make($wizardData['admin_password']),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);

            // Update environment file with site settings
            $this->updateEnvironmentFile($wizardData);

            // Create .installed file to mark installation as complete
            File::put(base_path('.installed'), json_encode([
                'installed_at' => now()->toISOString(),
                'version' => '1.0.0',
                'admin_email' => $wizardData['admin_email'],
            ], JSON_PRETTY_PRINT));

            // Clear various caches
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            // Clear wizard session data
            session()->forget('wizard_data');
            
            session()->flash('installation_complete', 'Installation completed successfully!');
            
            return redirect()->route('login')->with('success', 'Installation completed! Please log in with your admin credentials.');

        } catch (\Exception $e) {
            $this->isProcessing = false;
            session()->flash('error', 'Installation failed: ' . $e->getMessage());
        }
    }

    protected function updateEnvironmentFile($wizardData)
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $updates = [
            'SITE_INSTALLED' => 'true',
            'SITE_AGENCY_NAME' => $wizardData['agency_name'] ?? '',
            'SITE_AGENCY_EMAIL' => $wizardData['agency_email'] ?? '',
            'SITE_AGENCY_PHONE' => $wizardData['agency_phone'] ?? '',
            'SITE_AGENCY_ADDRESS' => $wizardData['agency_address'] ?? '',
            'SITE_BRAND_PRIMARY_COLOR' => $wizardData['brand_primary_color'] ?? '#3B82F6',
            'SITE_BRAND_SECONDARY_COLOR' => $wizardData['brand_secondary_color'] ?? '#1E40AF',
            'SITE_SEO_TITLE' => $wizardData['seo_title'] ?? '',
            'SITE_SEO_DESCRIPTION' => $wizardData['seo_description'] ?? '',
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

    public function render()
    {
        // Pass summary data to the view
        $summaryData = session('wizard_data', []);
        
        return view('livewire.installation-wizard', compact('summaryData'))
            ->layout('components.layouts.minimal');
    }
}