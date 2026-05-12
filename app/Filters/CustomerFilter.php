<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CustomerFilter extends FilterBuilder
{
    public function apply(Builder $query): Builder
    {
        // Apply generic filters first
        parent::apply($query);

        // Model-specific filters
        if (!empty($this->filters['customer_code'])) {
            $query->where('customer_code', $this->filters['customer_code']);
        }

        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        return $query;
    }
}

// Before use check the filter builder first, lots of common filters already added for test purposes

