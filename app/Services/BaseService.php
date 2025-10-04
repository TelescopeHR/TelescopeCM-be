<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Container\Container as Application;

abstract class BaseService
{
    /**
     * Build Paginated Records of voucher using transformed data
     */
    public function paginate(Builder $builder, callable $callback, ?int $page=null, int $perPage=100): array
    {
        // $perPage = (int) config('movam.number_of_paginated_records');

        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $builder->paginate($perPage, ['*'], 'page', $page);
        
        return [
            'data' => $paginator->getCollection()->transform($callback),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'next_page' => $paginator->hasMorePages() ? $paginator->currentPage() + 1 : null,
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total()
            ]
        ];
 
    }
}