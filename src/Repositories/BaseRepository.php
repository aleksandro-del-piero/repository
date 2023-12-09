<?php


namespace AleksandroDelPiero\Repository\Repositories;

use AleksandroDelPiero\Repository\Contracts\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements Repository
{
    /**
     * @var Model|mixed
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     * @param Container $container
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(Container $container)
    {
        $this->model = $container->make($this->getModel());
    }

    /**
     * @return Model|mixed
     */
    public function instance()
    {
        return $this->model;
    }

    /**
     * Get model class
     * @return string
     */
    abstract public function getModel():string;
}
