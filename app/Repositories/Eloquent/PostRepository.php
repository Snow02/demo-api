<?php

namespace App\Repositories\Eloquent;

class  PostRepository extends Repository {

    public function __construct()
    {
        $this->app->bind(
            'App\Repositories\Interfaces\RepositoryInterface',
            'App\Repositories\Eloquent\PostRepository'
        );
    }

    function model()
    {
        return 'App\Models\Post';
    }
}