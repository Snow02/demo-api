<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
class Post extends Model implements HasMedia
{

    use SoftDeletes , HasMediaTrait;

    protected $fillable = ['title','alias','desc','content','user_id','cate_id'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function  category(){
        return $this->belongsTo(Category::class ,'cate_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(Media $media=null)
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->nonOptimized();
    }

}
