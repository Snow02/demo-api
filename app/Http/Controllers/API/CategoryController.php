<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

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
            $cate = $this->categoryRepository->create($input);
            return $this->success($cate , "Add category success ");
        }
        catch(\ Exception $e){
            return $this->error($e);
        }
    }

    public function getListCategories(){
        try{
            $cates = $this->categoryRepository->selectAll()->get();
            return $this->success($cates, "List Categories");
        }
        catch (\Exception $e){
            return $this->error($e);
        }
    }
}
