<?php

namespace App\Livewire;

use App\Models\Community;
use Livewire\Component;
use Livewire\WithPagination;

class CommunityManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $communityId;
    public $name;
    public $slug;
    public $statistical_info;
    public $monthly_events;
    public $is_published = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:communities,slug',
        'statistical_info' => 'nullable|string',
        'monthly_events' => 'nullable|string',
        'is_published' => 'boolean',
    ];

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $community = Community::findOrFail($id);
        $this->communityId = $community->id;
        $this->name = $community->name;
        $this->slug = $community->slug;
        $this->statistical_info = $community->statistical_info;
        $this->monthly_events = $community->monthly_events;
        $this->is_published = $community->is_published;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['slug'] = 'nullable|string|max:255|unique:communities,slug,' . $this->communityId;
        }

        $this->validate();

        if ($this->editMode) {
            $community = Community::findOrFail($this->communityId);
            $community->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'statistical_info' => $this->statistical_info,
                'monthly_events' => $this->monthly_events,
                'is_published' => $this->is_published,
            ]);
            session()->flash('message', 'Community updated successfully!');
        } else {
            Community::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'statistical_info' => $this->statistical_info,
                'monthly_events' => $this->monthly_events,
                'is_published' => $this->is_published,
            ]);
            session()->flash('message', 'Community created successfully!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Community::findOrFail($id)->delete();
        session()->flash('message', 'Community deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $community = Community::findOrFail($id);
        $community->update(['is_published' => !$community->is_published]);
        session()->flash('message', 'Community status updated successfully!');
    }

    private function resetForm()
    {
        $this->communityId = null;
        $this->name = '';
        $this->slug = '';
        $this->statistical_info = '';
        $this->monthly_events = '';
        $this->is_published = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.community-manager', [
            'communities' => Community::paginate(10)
        ])->layout('components.layouts.app');
    }
}
