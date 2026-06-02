<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope a query to search multiple columns.
     *
     * @param Builder $query
     * @param string|null $term
     * @param array $columns
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $term, array $columns = []): Builder
    {
        if (!$term || empty($columns)) {
            return $query;
        }

        return $query->where(function ($q) use ($term, $columns) {
            foreach ($columns as $column) {
                if (str_contains($column, '.')) {
                    $parts = explode('.', $column);
                    $relation = $parts[0];
                    $relColumn = $parts[1];

                    $q->orWhereHas($relation, function ($relQuery) use ($relColumn, $term) {
                        $relQuery->where($relColumn, 'like', "%{$term}%");
                    });
                } else {
                    $q->orWhere($column, 'like', "%{$term}%");
                }
            }
        });
    }

    /**
     * Scope a query to filter by specific columns.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function scopeFilterBy(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $column => $value) {
            if ($value !== null && $value !== '') {
                if (str_contains($column, '.')) {
                    $parts = explode('.', $column);
                    $relation = $parts[0];
                    $relColumn = $parts[1];

                    $query->whereHas($relation, function ($relQuery) use ($relColumn, $value) {
                        $relQuery->where($relColumn, $value);
                    });
                } else {
                    $query->where($column, $value);
                }
            }
        }

        return $query;
    }
}
