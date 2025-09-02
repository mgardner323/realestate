<?php

namespace App\Repositories\Firestore;

use App\Repositories\Contracts\PropertyRepositoryInterface;
use Illuminate\Support\Collection;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class FirestorePropertyRepository implements PropertyRepositoryInterface
{
    protected $collection;
    protected const COLLECTION_NAME = 'properties';

    public function __construct()
    {
        // Get the Firestore database instance
        $this->collection = Firebase::firestore()->database()->collection(self::COLLECTION_NAME);
    }

    public function all(): Collection
    {
        $documents = $this->collection->documents();
        $properties = [];
        
        foreach ($documents as $document) {
            if ($document->exists()) {
                $properties[] = $this->documentToObject($document);
            }
        }
        
        return new Collection($properties);
    }

    public function find(string $id): ?object
    {
        $document = $this->collection->document($id)->snapshot();

        if ($document->exists()) {
            return $this->documentToObject($document);
        }

        return null;
    }

    public function paginate(int $perPage = 15)
    {
        // For simplicity, we'll get all documents and paginate in memory
        // In production, you'd want to implement proper Firestore pagination with cursors
        $allProperties = $this->all()->sortByDesc('created_at');
        
        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $currentItems = $allProperties->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        return new LengthAwarePaginator(
            $currentItems,
            $allProperties->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }

    public function getFeatured(int $limit = 5): Collection
    {
        $query = $this->collection->where('is_featured', '=', true)
            ->orderBy('created_at', 'DESC')
            ->limit($limit);
            
        $documents = $query->documents();
        $properties = [];
        
        foreach ($documents as $document) {
            if ($document->exists()) {
                $properties[] = $this->documentToObject($document);
            }
        }
        
        return new Collection($properties);
    }

    public function search(string $query, int $limit = 20): Collection
    {
        // Firestore doesn't have full-text search like Elasticsearch
        // This is a basic implementation that searches in title and description
        // In production, you'd integrate with Algolia or similar service
        $documents = $this->collection
            ->orderBy('created_at', 'DESC')
            ->limit($limit * 2) // Get more documents to filter through
            ->documents();
            
        $properties = [];
        $searchTerm = strtolower($query);
        $count = 0;
        
        foreach ($documents as $document) {
            if ($document->exists() && $count < $limit) {
                $data = $document->data();
                $title = strtolower($data['title'] ?? '');
                $description = strtolower($data['description'] ?? '');
                $location = strtolower($data['location'] ?? '');
                
                if (str_contains($title, $searchTerm) || 
                    str_contains($description, $searchTerm) || 
                    str_contains($location, $searchTerm)) {
                    $properties[] = $this->documentToObject($document);
                    $count++;
                }
            }
        }
        
        return new Collection($properties);
    }

    public function create(array $data): object
    {
        // Add timestamps
        $data['created_at'] = now()->timestamp;
        $data['updated_at'] = now()->timestamp;
        
        // Firestore automatically generates an ID
        $documentReference = $this->collection->add($data);
        $documentSnapshot = $documentReference->snapshot();

        return $this->documentToObject($documentSnapshot);
    }

    public function update(string $id, array $data): ?object
    {
        $document = $this->collection->document($id);
        
        // Add updated timestamp
        $data['updated_at'] = now()->timestamp;

        // Use 'merge' => true to perform an update, not an overwrite
        $document->set($data, ['merge' => true]);

        // Re-fetch the updated data to return it
        return $this->find($id);
    }

    public function delete(string $id): bool
    {
        try {
            $this->collection->document($id)->delete();
            // Firestore delete does not return success/fail, so we assume success if no exception
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getByStatus(string $status, int $limit = null): Collection
    {
        $query = $this->collection->where('type', '=', $status)
            ->orderBy('created_at', 'DESC');
            
        if ($limit) {
            $query->limit($limit);
        }
        
        $documents = $query->documents();
        $properties = [];
        
        foreach ($documents as $document) {
            if ($document->exists()) {
                $properties[] = $this->documentToObject($document);
            }
        }
        
        return new Collection($properties);
    }

    /**
     * Convert Firestore document to a standardized object.
     *
     * @param mixed $document
     * @return object
     */
    protected function documentToObject($document): object
    {
        $data = $document->data();
        
        // Convert timestamps back to Carbon instances for consistency with Eloquent
        if (isset($data['created_at']) && is_numeric($data['created_at'])) {
            $data['created_at'] = Carbon::createFromTimestamp($data['created_at']);
        }
        
        if (isset($data['updated_at']) && is_numeric($data['updated_at'])) {
            $data['updated_at'] = Carbon::createFromTimestamp($data['updated_at']);
        }
        
        if (isset($data['last_synced_at']) && is_numeric($data['last_synced_at'])) {
            $data['last_synced_at'] = Carbon::createFromTimestamp($data['last_synced_at']);
        }
        
        return (object) array_merge(['id' => $document->id()], $data);
    }
}