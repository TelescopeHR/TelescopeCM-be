<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
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
}