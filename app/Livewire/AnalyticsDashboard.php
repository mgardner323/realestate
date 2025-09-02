<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\Subscriber;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Component
{
    public $totalProperties;
    public $totalUsers;
    public $totalSubscribers;
    public $avgTimeOnSite;
    public $propertiesByType;
    public $usersOverTime;
    public $subscriberGrowth;
    public $mostSearchedLocations;

    public function mount()
    {
        $this->loadAnalyticsData();
    }

    protected function loadAnalyticsData()
    {
        // Basic statistics
        $this->totalProperties = Property::count();
        $this->totalUsers = User::count();
        $this->totalSubscribers = Subscriber::count();
        $this->avgTimeOnSite = '4m 32s'; // Placeholder - would need analytics integration

        // Properties by type (for doughnut chart)
        $this->propertiesByType = Property::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => ucfirst($item->type ?? 'Unknown'),
                    'count' => $item->count
                ];
            })
            ->toArray();

        // Users registered over time (last 8 months)
        $this->usersOverTime = collect();
        for ($i = 7; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = User::whereMonth('created_at', $month->month)
                         ->whereYear('created_at', $month->year)
                         ->count();
            
            $this->usersOverTime->push([
                'label' => $month->format('M'),
                'count' => $count
            ]);
        }

        // Newsletter subscriber growth (last 6 weeks)
        $this->subscriberGrowth = collect();
        for ($i = 5; $i >= 0; $i--) {
            $week = Carbon::now()->subWeeks($i);
            $count = Subscriber::where('created_at', '>=', $week->startOfWeek())
                              ->where('created_at', '<=', $week->endOfWeek())
                              ->count();
            
            $this->subscriberGrowth->push([
                'label' => 'Week ' . (6 - $i),
                'count' => $count
            ]);
        }

        // Most searched locations (mock data based on property locations)
        $this->mostSearchedLocations = Property::select('location', DB::raw('count(*) as searches'))
            ->groupBy('location')
            ->orderByDesc('searches')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'location' => $item->location ?? 'Unknown Location',
                    'searches' => $item->searches
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.analytics-dashboard');
    }
}
