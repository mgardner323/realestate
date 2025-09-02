<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SiteSettings extends Component
{
    use WithFileUploads;

    public $logo;
    public $heroMedia;
    public $currentLogoPath;
    public $currentHeroPath;

    protected $rules = [
        'logo' => 'nullable|image|max:1024', // 1MB max
        'heroMedia' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240', // 10MB max
    ];

    public function mount()
    {
        $this->currentLogoPath = Setting::get('logo_path');
        $this->currentHeroPath = Setting::get('hero_media_path');
    }

    public function saveLogo()
    {
        $this->validate(['logo' => $this->rules['logo']]);

        if ($this->logo) {
            // Delete old logo if exists
            if ($this->currentLogoPath) {
                $oldPath = str_replace('storage/', '', $this->currentLogoPath);
                Storage::disk('public')->delete($oldPath);
            }

            // Store new logo
            $path = $this->logo->store('branding', 'public');
            $publicPath = 'storage/' . $path;
            
            Setting::set('logo_path', $publicPath);
            $this->currentLogoPath = $publicPath;
            
            $this->logo = null;
            session()->flash('message', 'Logo updated successfully!');
        } else {
            session()->flash('error', 'Please select a logo file to upload.');
        }
    }

    public function saveHero()
    {
        $this->validate(['heroMedia' => $this->rules['heroMedia']]);

        if ($this->heroMedia) {
            // Delete old hero media if exists
            if ($this->currentHeroPath) {
                $oldPath = str_replace('storage/', '', $this->currentHeroPath);
                Storage::disk('public')->delete($oldPath);
            }

            // Store new hero media
            $path = $this->heroMedia->store('branding', 'public');
            $publicPath = 'storage/' . $path;
            
            Setting::set('hero_media_path', $publicPath);
            $this->currentHeroPath = $publicPath;
            
            $this->heroMedia = null;
            session()->flash('message', 'Hero media updated successfully!');
        } else {
            session()->flash('error', 'Please select a hero media file to upload.');
        }
    }

    public function removeLogo()
    {
        if ($this->currentLogoPath) {
            $oldPath = str_replace('storage/', '', $this->currentLogoPath);
            Storage::disk('public')->delete($oldPath);
            
            Setting::set('logo_path', null);
            $this->currentLogoPath = null;
            
            session()->flash('message', 'Logo removed successfully!');
        }
    }

    public function removeHero()
    {
        if ($this->currentHeroPath) {
            $oldPath = str_replace('storage/', '', $this->currentHeroPath);
            Storage::disk('public')->delete($oldPath);
            
            Setting::set('hero_media_path', null);
            $this->currentHeroPath = null;
            
            session()->flash('message', 'Hero media removed successfully!');
        }
    }

    public function render()
    {
        return view('livewire.site-settings')->layout('components.layouts.app', [
            'title' => 'Site Settings - Admin'
        ]);
    }
}
