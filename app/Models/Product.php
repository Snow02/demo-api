<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';


    public function category(){
        return $this->belongsTo('App\Category','cate_id','id');
    }

    public function productImg(){
        return $this->HasMany('App\productImages','product_id','id');
    }


    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }

}
