<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Container\Container as Application;

abstract class BaseRepository
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
     * Get Query
     */
    public function get(string $column, $value): Builder
    {
        $query = $this->model->newQuery()->where($column, $value);

        return $query->latest();
    }

    /**
     * Find One Model Record
     */
    public function findOne(string|int $id): ?Model
    {
        $column = (strlen($id) > 10) ? 'ulid' : 'id';

        return $this->findById($column, $id)->first();
    }

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
     * Create model record
     *
     * @param  array  $input
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Find By Id
     */
    public function findById(string $column, string|int $id)
    {
        return $this->model::query()->where($column, $id);
    }

    /**
     * Find By JsonColumn
     */
    public function findJsonColumn(string $jsonColumm, string|int $jsonValue): Builder
    {
        return $this->model::query()->whereJsonContains($jsonColumm, $jsonValue);
    }

    /**
     * Update model record for given id
     *
     * @param  array  $input
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param  int  $id
     * @return bool|mixed|null
     *
     * @throws \Exception
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }
}