<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Storage;

class AboutPageManager extends Component
{
    use WithFileUploads;

    public $aboutPhoto;
    public $aboutText = '';
    public $currentPhotoPath;
    public $isEnhancing = false;

    public function mount()
    {
        $this->aboutText = Setting::get('about_text', '');
        $this->currentPhotoPath = Setting::get('about_photo_path');
    }

    public function savePhoto()
    {
        $this->validate([
            'aboutPhoto' => 'required|image|mimes:jpeg,jpg,png,gif|max:10240', // 10MB max
        ]);

        // Delete old photo if exists
        if ($this->currentPhotoPath) {
            Storage::disk('public')->delete(str_replace('storage/', '', $this->currentPhotoPath));
        }

        // Store new photo
        $path = $this->aboutPhoto->store('about', 'public');
        $publicPath = 'storage/' . $path;

        Setting::set('about_photo_path', $publicPath);
        $this->currentPhotoPath = $publicPath;

        session()->flash('message', 'About photo updated successfully!');
        $this->aboutPhoto = null;
    }

    public function saveText()
    {
        $this->validate([
            'aboutText' => 'required|string|max:10000',
        ]);

        Setting::set('about_text', $this->aboutText);
        session()->flash('message', 'About text saved successfully!');
    }

    public function enhanceText()
    {
        if (empty(trim($this->aboutText))) {
            session()->flash('error', 'Please enter some text to enhance.');
            return;
        }

        $this->isEnhancing = true;
        
        try {
            $geminiService = app(GeminiService::class);
            $enhancedText = $geminiService->enhanceText($this->aboutText);
            
            if (!str_starts_with($enhancedText, 'Error:')) {
                $this->aboutText = $enhancedText;
                session()->flash('message', 'Text enhanced successfully with AI!');
            } else {
                session()->flash('error', 'Failed to enhance text. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'AI enhancement service is currently unavailable.');
        }
        
        $this->isEnhancing = false;
    }

    public function render()
    {
        return view('livewire.about-page-manager')->layout('layouts.app');
    }
}