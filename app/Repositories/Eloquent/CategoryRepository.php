<?php

namespace App\Repositories\Eloquent;

class CategoryRepository extends Repository{
    public function __construct()
    {
        $this->app->bind(
            'App\Repositories\Interfaces\RepositoryInterface',
            'App\Repositories\Eloquent\CategoryRepository'
        );
    }

    function model()
    {
        return 'App\Models\Category';
    }
}