<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Author extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable = ['name','email','phone','address'];
    protected $hidden = ['created_at','updated_at'];

    public function articles(){
        return $this->belongsToMany(Article::class, 'authors_articles');
    }
    public function registerMediaConversions(Media $media = null)
    {
        // TODO: Implement registerMediaConversions() method.
        $this->addMediaConversion('thumb')
            ->width(365 )
            ->height(250)
            ->sharpen(10);
    }
}
