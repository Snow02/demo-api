<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected  $model;

    public function __construct()
    {
        $this->makeModel();
    }
    //
    abstract function model();
    //
    public function makeModel() {
        $model = app()->make( $this->model() );

        return $this->model = $model;
    }

    //----------------------------
    public function selectAll(){
        return $this->model;
    }
    //
    public function find($id){
        return $this->model->findOrFail($id);
    }
    //
    public function create(array $attributes){
        return $this->model->create($attributes);
    }
    //
    public function  update($id, array $attributes){
        $post = $this->model->findOrFail($id);
        if($post){
            $post->update($attributes);
            return $post;
        }
        return false;

    }
    //
    public function  delete($id){
        $post = $this->model->findOrFail($id);
        if($post){
            $post->delete();
            return $post;
        }
        return false;

    }
}