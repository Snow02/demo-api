<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class  PostRepository extends Repository implements PostRepositoryInterface {


    function model()
    {
        return 'App\Models\Post';
    }
    public function getListPostsTrashed(){
        return Post::onlyTrashed()->get();
    }
    public function restorePostTrashed($id){
        $post = Post::onlyTrashed()->whereId($id)->first();
        if(!$post){
            return response()->json([
                'message' => 'This post has not been deleted' ,
            ]);
        }
        $post->restore();
        return $post;

    }
    public function getImages(object $post){
        $media_urls = [];
        foreach ($post->media as $media){
            $media_urls[] = [
              'origin_url' => $media->getFullUrl(),
              'thumbnail_url'  => $media->getFullUrl('thumb'),
            ];
        }
        return $images = count($media_urls) ? $media_urls : null;

    }

    public function getAvatar(object $post){
        $images = $this->getImages($post);
        return $avatar = $images[0];
    }



}