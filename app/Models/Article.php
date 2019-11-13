<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Article extends Model implements HasMedia
{
    use HasMediaTrait;


    protected  $table = "articles";
    protected $fillable = ['title','desc','content'];
    protected $hidden = ['created_at','updated_at'];

    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(350)
            ->height(350)
            ->sharpen(8);
    }


    public function authors(){
        return $this->belongsToMany(Author::class, 'authors_articles');
    }

}


