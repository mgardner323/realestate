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
        // Initialize with default values for real estate platform
        $this->agencyName = 'Real Estate Agency';
        $this->agencyEmail = 'info@realestate.com';
        $this->seoTitle = 'Premium Real Estate Platform';
        $this->seoDescription = 'Find your dream property with our comprehensive real estate platform featuring advanced search, analytics, and modern design.';
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
        // Just advance the step without validation for now
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        // Simplified validation to prevent PHP errors
        if ($this->currentStep == 1) {
            $this->validate([
                'agencyName' => 'required|string|max:255',
                'agencyEmail' => 'required|email|max:255'
            ]);
        }
        // Skip validation for other steps for now
    }

    public function finish()
    {
        $this->isProcessing = true;
        
        try {
            // Validate all steps
            $this->validate();

            // Create admin user
            $admin = User::create([
                'name' => $this->adminName,
                'email' => $this->adminEmail,
                'password' => Hash::make($this->adminPassword),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);

            // Update environment file with site settings
            $this->updateEnvironmentFile();

            // Create .installed file to mark installation as complete
            File::put(base_path('.installed'), json_encode([
                'installed_at' => now()->toISOString(),
                'version' => '1.0.0',
                'admin_email' => $this->adminEmail,
            ], JSON_PRETTY_PRINT));

            // Clear various caches
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            session()->flash('installation_complete', 'Installation completed successfully!');
            
            return redirect()->route('login')->with('success', 'Installation completed! Please log in with your admin credentials.');

        } catch (\Exception $e) {
            $this->isProcessing = false;
            session()->flash('error', 'Installation failed: ' . $e->getMessage());
        }
    }

    protected function updateEnvironmentFile()
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $updates = [
            'SITE_INSTALLED' => 'true',
            'SITE_AGENCY_NAME' => $this->agencyName,
            'SITE_AGENCY_EMAIL' => $this->agencyEmail,
            'SITE_AGENCY_PHONE' => $this->agencyPhone,
            'SITE_AGENCY_ADDRESS' => $this->agencyAddress,
            'SITE_BRAND_PRIMARY_COLOR' => $this->brandPrimaryColor,
            'SITE_BRAND_SECONDARY_COLOR' => $this->brandSecondaryColor,
            'SITE_SEO_TITLE' => $this->seoTitle,
            'SITE_SEO_DESCRIPTION' => $this->seoDescription,
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
        return view('livewire.installation-wizard')
            ->layout('components.layouts.minimal');
    }
}
