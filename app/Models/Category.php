<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";


    //Relationship 1 - n vs 'products'
    public function products(){
        return $this->HasMany('App\Products','product_id','id');
    }
}
