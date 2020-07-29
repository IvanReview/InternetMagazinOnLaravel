<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
abstract class CoreRepository
{
    protected $model;

    //пустая модель BlogPost
    public function  __construct()
    {
        $this->model=app($this->getModelClass());
    }


    abstract protected function getModelClass();


    protected function getModel()
    {
        return clone $this->model;
    }


}
