<?php

namespace App\Repositories\Redis;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class RedisPostRepository implements PostRepositoryInterface
{
    public function selectAll(){
        return  Post::all();
    }
    public function find($id){
        return Post::findOrFail($id);
    }

}