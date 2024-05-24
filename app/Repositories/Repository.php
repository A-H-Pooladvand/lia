<?php

namespace App\Repositories;

use RuntimeException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use function app;

abstract class Repository
{
    protected \MongoDB\Laravel\Eloquent\Model $model;

    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    abstract public function model(): string;

    /**
     * Create model instance.
     *
     * @return void
     * @throws \Exception
     */
    private function makeModel(): void
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new RuntimeException("Class {$this->model()} must be an instance of ".Model::class);
        }

        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id): bool
    {
        return $this->find($id)->update($data);
    }

    public function delete($id): int
    {
        return $this->model->destroy($id);
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }
}
