<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Validator;
class AuthorController extends Controller
{
    public function addAuthor(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:authors,email|email',
                'article_id' => 'exists:articles,id',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                // $errorString = implode(",",$validator->messages()->all());
                return $this->fail($validator->errors(), $validator->messages()->first(), "false", 401);
            }
            $input = $request->all();
            $author = Author::create($input);
            if($author){
                $author->articles()->attach($request->get('article_id'));
                return $this->success($author, "Create Author Success");
            }
        }catch(\Exception $e){
            return $this->error($e);
        }
    }
}
