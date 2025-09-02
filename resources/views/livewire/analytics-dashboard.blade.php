<div class="min-h-screen bg-slate-100">
    {{-- Header --}}
    <header class="bg-white shadow-sm border-b border-slate-200 px-6 py-4">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-slate-800">Analytics Dashboard</h1>
            <div class="text-sm text-slate-600">
                Last updated: {{ now()->format('M j, Y - g:i A') }}
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="p-6">
        {{-- Stats Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            {{-- Total Properties Card --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-500 uppercase">Total Properties</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalProperties) }}</p>
                    </div>
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-500 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    Active Listings
                </p>
            </div>

            {{-- Total Users Card --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-500 uppercase">Total Users</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalUsers) }}</p>
                    </div>
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-500 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    Registered Members
                </p>
            </div>

            {{-- Newsletter Subscribers Card --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-500 uppercase">Newsletter Subs</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalSubscribers) }}</p>
                    </div>
                    <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-500 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    Active Subscribers
                </p>
            </div>

            {{-- Avg Time on Site Card --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-500 uppercase">Avg. Time on Site</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $avgTimeOnSite }}</p>
                    </div>
                    <div class="bg-amber-100 text-amber-600 p-3 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-slate-500 mt-2">
                    User Engagement
                </p>
            </div>
        </div>

        {{-- Charts and Analytics Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Users Registered Over Time Chart --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-4">Users Registered Over Time</h3>
                <div class="relative h-64">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            {{-- Properties by Type Chart --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-4">Properties by Type</h3>
                <div class="relative h-64">
                    <canvas id="propertiesChart"></canvas>
                </div>
            </div>

            {{-- Most Searched Locations --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-4">Most Searched Locations</h3>
                <div class="space-y-4">
                    @foreach($mostSearchedLocations as $location)
                        @php
                            $maxSearches = collect($mostSearchedLocations)->max('searches');
                            $percentage = $maxSearches > 0 ? ($location['searches'] / $maxSearches) * 100 : 0;
                        @endphp
                        <div class="flex items-center">
                            <span class="w-2/5 text-slate-600 text-sm">{{ $location['location'] }}</span>
                            <div class="w-3/5 bg-slate-200 rounded-full h-2.5 mx-2">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="w-16 text-right text-slate-600 font-medium text-sm">{{ $location['searches'] }}</span>
                        </div>
                    @endforeach
                    @if(empty($mostSearchedLocations))
                        <p class="text-slate-500 text-center py-4">No location data available</p>
                    @endif
                </div>
            </div>

            {{-- Newsletter Growth Chart --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-slate-800 mb-4">Newsletter Growth</h3>
                <div class="relative h-64">
                    <canvas id="newsletterChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    {{-- Chart.js Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Color palette
            const brandColor = '#3B82F6';
            const secondaryColor = '#6366F1';
            const textColor = '#334155';
            const gridColor = '#E2E8F0';

            // Users Over Time Chart
            const usersCtx = document.getElementById('usersChart').getContext('2d');
            const usersChart = new Chart(usersCtx, {
                type: 'line',
                data: {
                    labels: @json($usersOverTime->pluck('label')),
                    datasets: [{
                        label: 'New Users',
                        data: @json($usersOverTime->pluck('count')),
                        borderColor: brandColor,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: brandColor,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: { color: textColor }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: textColor }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: textColor,
                            bodyColor: textColor,
                            borderColor: gridColor,
                            borderWidth: 1
                        }
                    }
                }
            });

            // Properties by Type Chart
            const propertiesCtx = document.getElementById('propertiesChart').getContext('2d');
            const propertiesChart = new Chart(propertiesCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(collect($propertiesByType)->pluck('label')),
                    datasets: [{
                        data: @json(collect($propertiesByType)->pluck('count')),
                        backgroundColor: [brandColor, secondaryColor, '#F59E0B', '#10B981', '#EF4444'],
                        borderColor: '#fff',
                        borderWidth: 4,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });

            // Newsletter Growth Chart
            const newsletterCtx = document.getElementById('newsletterChart').getContext('2d');
            const newsletterChart = new Chart(newsletterCtx, {
                type: 'line',
                data: {
                    labels: @json($subscriberGrowth->pluck('label')),
                    datasets: [{
                        label: 'New Subscribers',
                        data: @json($subscriberGrowth->pluck('count')),
                        borderColor: secondaryColor,
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: { color: textColor }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: textColor }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</div>