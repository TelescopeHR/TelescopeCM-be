<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Container\Container as Application;

abstract class Service
{
        /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @return Model
     *
     * @throws \Exception
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

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