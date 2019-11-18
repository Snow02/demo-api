<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected  $postRepository;

    // contract
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;

    }

    public function  addPost(Request $request){
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
            $input = [
                'title' =>$request->get('title'),
                'desc' =>$request->get('desc'),
                'alias' =>$request->get('alias'),
                'content' =>$request->get('content'),
                'cate_id' =>$request->get('cate_id'),
                'user_id' => Auth::id(),
            ];
            $post = $this->postRepository->create($input);

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
    public function  deletePost(Request $request){
        try{
            $post = $this->postRepository->delete($request->id);
            return $this->success($post, " Delete post success");
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }

    public function getListPostsTrashed(){
        try{
            $post = $this->postRepository->getListPostsTrashed();
            return $this->success($post,'List post have been deleted');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }

    public function  restorePostTrashed(Request $request ){
        try{
            $post = $this->postRepository->restorePostTrashed($request->id);
            return $this->success($post,'Restore post success');
        } catch (\ Exception $e){
            return $this->error($e);
        }
    }
    public function  getPostById(Request $request ){
        try{
            $post = $this->postRepository->find($request->id);
            return $this->success($post,'Info Post ');
        } catch (\ Exception $e){
            return $this->error($e);
        }
    }

    public  function  editPostById(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'content' => 'required',
                'images.*' => 'image|mimes:jpeg,jpg,png',
                'cate_id' =>'required|exists:categories,id',
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),$validator->messages(),'Fail', 401);
            }
            $cates = Category::where('parent_id',null);
            foreach($cates as $cate ){
                if($request->get('cate_id') == $cate->id){
                    return response()->json([
                       'message' => 'Category incorrect',
                    ]);
                }
            }

            $input = [
                'title' => $request->get('title'),
                'alias' => $request->get('alias'),
                'desc' => $request->get('desc'),
                'content' =>$request->get('content'),
                'cate_id' => $request->get('cate_id'),
                'user_id' => Auth::id(),
            ];
            $post = $this->postRepository->update($request->id,$input);
            if($post){
                if($request->has('images')){
                    $post->addAllMediaFromRequest('images')->each(function($file){
                       $file->toMediaCollection('image-post');
                    });
                }
            }
            return $this->success($post,'Update Post Success');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }

    public function  getPostsByCateId(Request $request){
        try{

            $posts = $this->postRepository->selectAll()->where('cate_id',$request->id)->with('category')->get();
            if($posts->isEmpty()){
                return response()->json([
                    'message' => 'The category contains no posts ',
                ]);
            }
            if($posts->isNotEmpty()){
                foreach($posts as $post){
                    // get images post
                    $post->images = $this->postRepository->getImages($post);
                    $post->avatar = $this->postRepository->getAvatar($post);
                }
                return $this->success($posts,"List post");
            }
        }
        catch(\ Exception $e){
            return $this->error($e);
        }

    }

    public function  getPostsByUserId(Request $request){
        try{
            $posts = $this->postRepository->selectAll()->where('user_id',$request->id)->with('category','user')->get();

//            $posts = Post::where('user_id',$request->id)->with('category','user')->get();

            if($posts->isEmpty()){
                return response()->json([
                    'message' => 'The user has no posts ',
                ]);
            }
            if($posts->isNotEmpty()){

                // get images by post
                foreach($posts as $post){
                    $post->images = $this->postRepository->getImages($post);
                    $post->avatar = $this->postRepository->getAvatar($post);
                }

                return $this->success($posts,"List posts by user");
            }
        }
        catch(\ Exception $e){
            return $this->error($e);
        }
    }

    public function getListPosts(){
        try{
            $post = $this->postRepository->selectAll()->get();
            return $this->success($post,'List post ');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }
    }

}
