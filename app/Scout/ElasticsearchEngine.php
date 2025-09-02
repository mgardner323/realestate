<?php

namespace App\Scout;

use Laravel\Scout\Engines\Engine;
use Laravel\Scout\Builder;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client as ElasticsearchClient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\LazyCollection;

class ElasticsearchEngine extends Engine
{
    protected ElasticsearchClient $elasticsearch;
    protected string $indexPrefix;
    protected array $settings;

    public function __construct(ElasticsearchClient $elasticsearch, array $config)
    {
        $this->elasticsearch = $elasticsearch;
        $this->indexPrefix = $config['index_prefix'] ?? 'laravel';
        $this->settings = $config['settings'] ?? [];
    }

    public function update($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $params = ['body' => []];

        $models->each(function ($model) use (&$params) {
            $params['body'][] = [
                'index' => [
                    '_index' => $this->getIndexName($model),
                    '_id' => $model->getScoutKey(),
                ]
            ];
            $params['body'][] = array_merge(
                $model->toSearchableArray(),
                $model->scoutMetadata()
            );
        });

        $this->elasticsearch->bulk($params);
    }

    public function delete($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $params = ['body' => []];

        $models->each(function ($model) use (&$params) {
            $params['body'][] = [
                'delete' => [
                    '_index' => $this->getIndexName($model),
                    '_id' => $model->getScoutKey(),
                ]
            ];
        });

        $this->elasticsearch->bulk($params);
    }

    public function search(Builder $builder)
    {
        return $this->performSearch($builder, array_filter([
            'numericFilters' => $this->filters($builder),
            'size' => $builder->limit,
        ]));
    }

    public function paginate(Builder $builder, $perPage, $page)
    {
        $from = (($page * $perPage) - $perPage);

        return $this->performSearch($builder, [
            'numericFilters' => $this->filters($builder),
            'from' => $from,
            'size' => $perPage,
        ]);
    }

    protected function performSearch(Builder $builder, array $options = [])
    {
        $params = [
            'index' => $this->getIndexName($builder->model),
            'body' => [
                'query' => $this->buildQuery($builder),
            ],
        ];

        if (isset($options['from'])) {
            $params['body']['from'] = $options['from'];
        }

        if (isset($options['size'])) {
            $params['body']['size'] = $options['size'];
        }

        if (isset($options['numericFilters']) && count($options['numericFilters'])) {
            $params['body']['post_filter'] = $this->buildFilters($options['numericFilters']);
        }

        $response = $this->elasticsearch->search($params);

        return [
            'results' => $this->mapIds($response),
            'total' => $response['hits']['total']['value'] ?? 0,
        ];
    }

    protected function buildQuery(Builder $builder)
    {
        if (empty($builder->query)) {
            return ['match_all' => new \stdClass()];
        }

        return [
            'multi_match' => [
                'query' => $builder->query,
                'fields' => ['*'],
                'type' => 'best_fields',
                'fuzziness' => 'AUTO',
            ],
        ];
    }

    protected function buildFilters(array $filters)
    {
        $must = [];

        foreach ($filters as $filter) {
            $must[] = [
                'range' => [
                    $filter['field'] => [
                        $filter['operator'] => $filter['value'],
                    ],
                ],
            ];
        }

        return ['bool' => ['must' => $must]];
    }

    protected function filters(Builder $builder)
    {
        return collect($builder->wheres)->map(function ($value, $key) {
            if (is_array($value)) {
                return ['field' => $key, 'operator' => 'gte', 'value' => $value[0]];
            }

            return ['field' => $key, 'operator' => 'eq', 'value' => $value];
        })->values()->all();
    }

    public function mapIds($results)
    {
        return collect($results['hits']['hits'])->pluck('_id')->values()->all();
    }

    public function map(Builder $builder, $results, $model)
    {
        if ($results['total'] === 0) {
            return $model->newCollection();
        }

        $objectIds = collect($results['results'])->values()->all();
        
        $objectIdPositions = array_flip($objectIds);

        return $model->getScoutModelsByIds(
            $builder, $objectIds
        )->filter(function ($model) use ($objectIds) {
            return in_array($model->getScoutKey(), $objectIds);
        })->sortBy(function ($model) use ($objectIdPositions) {
            return $objectIdPositions[$model->getScoutKey()];
        })->values();
    }

    public function getTotalCount($results)
    {
        return $results['total'];
    }

    public function flush($model)
    {
        $indexName = $this->getIndexName($model);

        if ($this->elasticsearch->indices()->exists(['index' => $indexName])) {
            $this->elasticsearch->indices()->delete(['index' => $indexName]);
        }
    }

    public function createIndex($name, array $options = [])
    {
        $params = [
            'index' => $name,
            'body' => [
                'settings' => array_merge($this->settings, $options['settings'] ?? []),
            ],
        ];

        if (isset($options['mappings'])) {
            $params['body']['mappings'] = $options['mappings'];
        }

        $this->elasticsearch->indices()->create($params);
    }

    public function deleteIndex($name)
    {
        if ($this->elasticsearch->indices()->exists(['index' => $name])) {
            $this->elasticsearch->indices()->delete(['index' => $name]);
        }
    }

    protected function getIndexName($model)
    {
        return $this->indexPrefix . '_' . $model->searchableAs();
    }

    public function lazyMap(Builder $builder, $results, $model)
    {
        if ($results['total'] === 0) {
            return LazyCollection::make($model->newCollection());
        }

        $objectIds = collect($results['results'])->values()->all();
        $objectIdPositions = array_flip($objectIds);

        return $model->queryScoutModelsByIds(
            $builder, $objectIds
        )->cursor()->filter(function ($model) use ($objectIds) {
            return in_array($model->getScoutKey(), $objectIds);
        })->sortBy(function ($model) use ($objectIdPositions) {
            return $objectIdPositions[$model->getScoutKey()];
        })->values();
    }
}