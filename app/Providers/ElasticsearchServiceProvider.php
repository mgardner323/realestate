<?php

namespace App\Providers;

use App\Scout\ElasticsearchEngine;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;

class ElasticsearchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        resolve(EngineManager::class)->extend('elasticsearch', function () {
            $config = config('scout.elasticsearch');
            
            $clientBuilder = ClientBuilder::create()
                ->setHosts($config['hosts']);

            if (!empty($config['username']) && !empty($config['password'])) {
                $clientBuilder->setBasicAuthentication($config['username'], $config['password']);
            }

            $client = $clientBuilder->build();

            return new ElasticsearchEngine($client, $config);
        });
    }
}