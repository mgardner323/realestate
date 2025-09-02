<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Community;

class ShowAboutPage extends Component
{
    public $aboutPhoto;
    public $aboutText;

    public function mount()
    {
        $this->aboutPhoto = Setting::get('about_photo_path');
        $this->aboutText = Setting::get('about_text', 'Welcome to our real estate agency. We are dedicated to helping you find your dream home.');
    }

    public function render()
    {
        return view('livewire.show-about-page', [
            'categories' => Category::all(),
            'communities' => Community::where('is_published', true)->get(),
            'logoPath' => Setting::get('logo_path'),
            'heroPath' => Setting::get('hero_media_path')
        ]);
    }
}