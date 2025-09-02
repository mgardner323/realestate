<?php

namespace App\Repositories\Eloquent;

use App\Models\Property;
use App\Repositories\Contracts\PropertyRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentPropertyRepository implements PropertyRepositoryInterface
{
    public function __construct(protected Property $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(string $id): ?object
    {
        return $this->model->find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function getFeatured(int $limit = 5): Collection
    {
        return $this->model->where('is_featured', true)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function search(string $query, int $limit = 20): Collection
    {
        return $this->model->search($query)
            ->take($limit)
            ->get();
    }

    public function create(array $data): object
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data): ?object
    {
        $property = $this->find($id);
        if ($property) {
            $property->update($data);
            return $property->fresh();
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $property = $this->find($id);
        if ($property) {
            return $property->delete();
        }
        return false;
    }

    public function getByStatus(string $status, int $limit = null): Collection
    {
        $query = $this->model->where('type', $status)->latest();
        
        if ($limit) {
            $query->take($limit);
        }
        
        return $query->get();
    }
}