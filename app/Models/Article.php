<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title','desc','content'];
    protected $hidden = ['created_at','updated_at'];

    public function authors(){
        return $this->belongsToMany(Authors::class, 'authors_articles');
    }
}


