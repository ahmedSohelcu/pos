<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterBuilder
{
    /**
     * Array of filters (usually from request)
     */
    protected array $filters = [];

    /**
     * Initialize with filter array
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Apply filters to query
     */
    public function apply(Builder $query): Builder
    {
        // Generic search filter (across multiple fields)
        if (!empty($this->filters['search'])) {
            $query->where(function ($q) {
                foreach (['name', 'email'] as $field) { // default fields, can override in child
                    $q->orWhere($field, 'like', '%' . $this->filters['search'] . '%');
                }
            });
        }

        // Active status filter
        if (isset($this->filters['is_active'])) {
            $query->where('is_active', $this->filters['is_active']);
        }

        // Date range filters
        if (!empty($this->filters['created_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['created_from']);
        }

        if (!empty($this->filters['created_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['created_to']);
        }

        // Optional: other generic filters
        foreach ($this->filters as $key => $value) {
            if (!in_array($key, ['search', 'is_active', 'created_from', 'created_to']) && $value !== null) {
                $query->where($key, $value);
            }
        }

        return $query;
    }
}