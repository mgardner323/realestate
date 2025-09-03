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
        $sessionData = session('wizard_data', []);
        
        // Initialize with session data or default values
        $this->agencyName = $sessionData['agencyName'] ?? 'Real Estate Agency';
        $this->agencyEmail = $sessionData['agencyEmail'] ?? 'info@realestate.com';
        $this->agencyPhone = $sessionData['agencyPhone'] ?? '';
        $this->agencyAddress = $sessionData['agencyAddress'] ?? '';
        $this->brandPrimaryColor = $sessionData['brandPrimaryColor'] ?? '#3B82F6';
        $this->brandSecondaryColor = $sessionData['brandSecondaryColor'] ?? '#1E40AF';
        $this->seoTitle = $sessionData['seoTitle'] ?? 'Premium Real Estate Platform';
        $this->seoDescription = $sessionData['seoDescription'] ?? 'Find your dream property with our comprehensive real estate platform featuring advanced search, analytics, and modern design.';
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
        // Debug: Log current component state
        logger()->info('nextStep called', [
            'currentStep' => $this->currentStep,
            'agencyName' => $this->agencyName,
            'agencyEmail' => $this->agencyEmail,
            'seoTitle' => $this->seoTitle,
        ]);
        
        // Validate and save current step data to session
        $this->validateCurrentStep();
        
        // Get current wizard data from session
        $currentData = session('wizard_data', []);
        
        // Prepare data based on current step
        $validatedData = [];
        
        if ($this->currentStep == 1) {
            $validatedData = [
                'agencyName' => $this->agencyName,
                'agencyEmail' => $this->agencyEmail,
                'agencyPhone' => $this->agencyPhone,
                'agencyAddress' => $this->agencyAddress,
            ];
        } elseif ($this->currentStep == 2) {
            $validatedData = [
                'brandPrimaryColor' => $this->brandPrimaryColor,
                'brandSecondaryColor' => $this->brandSecondaryColor,
                'seoTitle' => $this->seoTitle,
                'seoDescription' => $this->seoDescription,
            ];
        }
        
        // Debug: Log what we're saving
        logger()->info('Saving wizard data to session', [
            'currentData' => $currentData,
            'validatedData' => $validatedData,
        ]);
        
        // Merge with existing session data
        $mergedData = array_merge($currentData, $validatedData);
        session(['wizard_data' => $mergedData]);
        
        // Debug: Verify session save
        logger()->info('Session data after save', [
            'sessionData' => session('wizard_data'),
        ]);
        
        // Advance to next step
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
        $summaryData = session('wizard_data', []);
        return view('livewire.installation-wizard', [
            'summaryData' => $summaryData
        ])->layout('components.layouts.minimal');
    }
}
