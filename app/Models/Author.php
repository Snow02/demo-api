<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name','email','phone','address'];
    protected $hidden = ['created_at','updated_at'];

    public function articles(){
        return $this->belongsToMany(Article::class, 'authors_articles');
    }
}
