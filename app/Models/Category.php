<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title','desc','content','parent_id'];
    protected $hidden = ['created_at','updated_at'];

    public function posts(){
        return $this->hasMany(Post::class,'cate_id');
    }
}
