<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
class ProductController extends Controller
{
    public function getProduct(){
        try{
            $products = Product::all();
            return response()->json([
                'result'  => 200,
                'message' => "List Product",
                'data'    => $products
            ]);
        }
        catch(\Exception $e)
        {
            return $this->error($e);
        }

    }

    public function getProductById(Request $request){
        try {
            $product = Product::find($request->id);
            if(empty($product)){
                return response()->json([
                    'result'  => 204,
                    'message' => "No Product",

                ]);
            }
            return response()->json([
                'result'  => 200,
                'message' => "Show a Product $request->id",
                'data'    => $product
            ]);
        }
        catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function getProductByCatId(Request $request){
        try{
            $products = Product::whereCateId($request->cate_id)->get();

            return $this->success($products,"List Product of the category $request->cat_id");
        } catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function addProduct(Request $request){
        try{
            $rules = [
                'name' => 'required|unique:products,name|min:5',
                'price'=>'required',
                'cate_id' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'user_id' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'image.*' => 'image|mimes:jpg,jpeg,png'
            ];
            $validator = Validator::make($rules);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), "false", 401);
            }
            $input = $request->all();
            $product = Product::create($input);
            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $product->image = $filename;
            }
            return $this->success($product, "Add product Successfull");

        }catch(\Exception $e){
            return $this->error($e);
        }


    }

}
