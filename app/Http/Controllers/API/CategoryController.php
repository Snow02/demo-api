<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add_category(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'parent_id' => 'exists:categories,id',
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),$validator->messages()->first(),'Fail', 401);
            }
            $input = $request->all();
            $post = Category::create($input);
            return $this->success($post , "Add category success ");
        }
        catch(\ Exception $e){
            return $this->error($e);
        }
    }
}
