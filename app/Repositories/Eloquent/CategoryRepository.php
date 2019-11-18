<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends Repository implements CategoryRepositoryInterface {


    function model()
    {
        return 'App\Models\Category';
    }
}