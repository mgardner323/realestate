<?php

namespace App\Providers;

use App\Repositories\Contracts\PropertyRepositoryInterface;
use App\Repositories\Eloquent\EloquentPropertyRepository;
use App\Repositories\Firestore\FirestorePropertyRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $driver = config('repositories.driver');

        // Bind the PropertyRepositoryInterface to the correct implementation
        $this->app->bind(PropertyRepositoryInterface::class, function ($app) use ($driver) {
            switch ($driver) {
                case 'firestore':
                    return new FirestorePropertyRepository();
                case 'eloquent':
                default:
                    return new EloquentPropertyRepository($app->make(\App\Models\Property::class));
            }
        });

        // You can add bindings for other repositories here
        // For example: UserRepositoryInterface, OrderRepositoryInterface, etc.
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
