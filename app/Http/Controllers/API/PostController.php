<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function  add_posts(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'title' => 'required|unique:posts,title',
                'content' => 'required',
                'images.*' => 'image|mimes:jpeg,jpg,png',
                'cate_id' => 'required|exists:categories,id',
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),$validator->messages(),'Fail', 401);
            }
            // Check category
            $cates = Category::where('parent_id',null)->get();
            foreach($cates as $cate){
                if($request->get('cate_id') == $cate->id){
                    return response()->json([
                       'message' => 'Category incorrect !!',
                    ]);
                }
            }


            $post = Post::create([
                'title' =>$request->get('title'),
                'desc' =>$request->get('desc'),
                'content' =>$request->get('content'),
                'cate_id' =>$request->get('cate_id'),
                'user_id' => Auth::id(),
            ]);
            if($post){
                if($request->has('images')){
                    $post->addAllMediaFromRequest()->each(function($file){
                        $file->toMediaCollection('images post');
                    });

                }
            }
            return $this->success($post,'Add post success');

        }
        catch(\ Exception $e){
            return  $this->error($e);
        }

    }
    public function  delete_post(Request $request){
        try{
            $post = Post::findOrFail($request->id);
            $post->delete();
            return $this->success($post,'Delete success');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }

    public function get_list_posts_trashed(){
        try{
            $post = Post::onlyTrashed()->get();
            return $this->success($post,'List post have been deleted');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }
    public function get_list_posts(){
        try{
            $post = Post::withTrashed()->get();
            return $this->success($post,'List post ');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }

    public function  restore_posts_trashed(Request $request ){
        try{
            $post = Post::onlyTrashed()->whereId($request->id)->first();
            if(!$post){
                return response()->json([
                   'message' => 'This post has not been deleted' ,
                ]);
            }
            $post->restore();
            return $this->success($post,'Restore post success');
        } catch (\ Exception $e){
            return $this->error($e);
        }
    }


}
