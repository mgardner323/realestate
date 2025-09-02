<?php

namespace App\Livewire;

use App\Models\Community;
use App\Services\GeminiService;
use Livewire\Component;

class EditCommunity extends Component
{
    public Community $community;
    
    public $name;
    public $slug;
    public $statistical_info;
    public $monthly_events;
    public $is_published;
    
    public $generatingStats = false;
    public $generatingEvents = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'statistical_info' => 'nullable|string',
        'monthly_events' => 'nullable|string',
        'is_published' => 'boolean',
    ];

    public function mount(Community $community)
    {
        $this->community = $community;
        $this->name = $community->name;
        $this->slug = $community->slug;
        $this->statistical_info = $community->statistical_info;
        $this->monthly_events = $community->monthly_events;
        $this->is_published = $community->is_published;
    }

    public function generateStats()
    {
        $this->generatingStats = true;
        
        try {
            $geminiService = new GeminiService();
            $generatedContent = $geminiService->generateCommunityStats($this->name);
            
            if (!str_contains($generatedContent, 'Error:')) {
                $this->statistical_info = $generatedContent;
                session()->flash('message', 'Community statistics generated successfully!');
            } else {
                session()->flash('error', 'Failed to generate community statistics: ' . $generatedContent);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error generating statistics: ' . $e->getMessage());
        }
        
        $this->generatingStats = false;
    }

    public function generateEvents()
    {
        $this->generatingEvents = true;
        
        try {
            $geminiService = new GeminiService();
            $generatedContent = $geminiService->generateCommunityEvents($this->name);
            
            if (!str_contains($generatedContent, 'Error:')) {
                $this->monthly_events = $generatedContent;
                session()->flash('message', 'Community events generated successfully!');
            } else {
                session()->flash('error', 'Failed to generate community events: ' . $generatedContent);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error generating events: ' . $e->getMessage());
        }
        
        $this->generatingEvents = false;
    }

    public function save()
    {
        $this->validate();

        $this->community->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'statistical_info' => $this->statistical_info,
            'monthly_events' => $this->monthly_events,
            'is_published' => $this->is_published,
        ]);

        session()->flash('message', 'Community updated successfully!');
        
        return redirect('/admin/communities');
    }

    public function render()
    {
        return view('livewire.edit-community')->layout('components.layouts.app');
    }
}
