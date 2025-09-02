<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface PropertyRepositoryInterface
{
    /**
     * Get all properties.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find a property by its ID.
     *
     * @param string $id
     * @return object|null
     */
    public function find(string $id): ?object;

    /**
     * Get paginated properties.
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate(int $perPage = 15);

    /**
     * Get featured properties.
     *
     * @param int $limit
     * @return Collection
     */
    public function getFeatured(int $limit = 5): Collection;

    /**
     * Search properties by query.
     *
     * @param string $query
     * @param int $limit
     * @return Collection
     */
    public function search(string $query, int $limit = 20): Collection;

    /**
     * Create a new property.
     *
     * @param array $data
     * @return object
     */
    public function create(array $data): object;

    /**
     * Update a property by its ID.
     *
     * @param string $id
     * @param array $data
     * @return object|null
     */
    public function update(string $id, array $data): ?object;

    /**
     * Delete a property by its ID.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;

    /**
     * Get properties by status.
     *
     * @param string $status
     * @param int $limit
     * @return Collection
     */
    public function getByStatus(string $status, int $limit = null): Collection;
}