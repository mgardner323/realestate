<?php

namespace App\Livewire;

use App\Repositories\Contracts\PropertyRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListing extends Component
{
    use WithPagination;

    public $search = '';
    public $searchLocation = '';
    public $searchType = '';
    public $minPrice = '';
    public $maxPrice = '';

    protected PropertyRepositoryInterface $propertyRepository;

    public function boot(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->searchLocation = '';
        $this->searchType = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchLocation()
    {
        $this->resetPage();
    }

    public function updatedSearchType()
    {
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Use search if we have a search term
        if ($this->search) {
            $properties = $this->propertyRepository->search($this->search, 100);
            
            // Apply additional filters to the search results
            $properties = $this->applyFilters($properties);
            
            // Convert to paginator for consistency
            $properties = $this->paginateCollection($properties, 12);
        } else {
            // Use standard pagination for browsing
            $properties = $this->propertyRepository->paginate(12);
        }

        return view('livewire.property-listing', [
            'properties' => $properties,
            'categories' => \App\Models\Category::all(),
            'communities' => \App\Models\Community::where('is_published', true)->get(),
            'logoPath' => \App\Models\Setting::get('logo_path'),
            'heroPath' => \App\Models\Setting::get('hero_media_path')
        ]);
    }

    protected function applyFilters($collection)
    {
        if ($this->searchLocation) {
            $collection = $collection->filter(function ($property) {
                return stripos($property->location, $this->searchLocation) !== false;
            });
        }

        if ($this->searchType) {
            $collection = $collection->filter(function ($property) {
                return $property->type === $this->searchType;
            });
        }

        if ($this->minPrice) {
            $collection = $collection->filter(function ($property) {
                return $property->price >= $this->minPrice;
            });
        }

        if ($this->maxPrice) {
            $collection = $collection->filter(function ($property) {
                return $property->price <= $this->maxPrice;
            });
        }

        return $collection;
    }

    protected function paginateCollection($collection, $perPage)
    {
        $currentPage = request()->get('page', 1);
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }
}