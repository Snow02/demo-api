<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthorController extends Controller
{
    public function addAuthor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:authors,email|email',
                'article_id' => 'exists:articles,id',
                'phone' => 'required',
                'address' => 'required'
            ]);
            if ($validator->fails()) {
                // $errorString = implode(",",$validator->messages()->all());
                return $this->fail($validator->errors(), $validator->messages()->first(), "false", 401);
            }
            $input = $request->all();
            $author = Author::create($input);
            if ($author) {
                $author->articles()->attach($request->get('article_id'));
                return $this->success($author, "Create Author Success");
            }
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getListAuthors(Request $request)
    {
        try {
            $authors = Author::all();
            return $this->success($authors, "show info author");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getAuthor(Request $request)
    {
        try {
            $author = Author::find($request->id);
            return $this->success($author, "show info author");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function updateAuthor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:authors,email|email',
                'article_id' => 'exists:articles,id',
                'phone' => 'required',
                'address' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), "false", 401);
            }
            $author = Author::find($request->id)->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
            ]);
            return $this->success($author, "Update Successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function deleteAuthor(Request $request)
    {
        try {

            $author = Author::findOrFail($request->id);
            foreach ($author->articles as $article) {
                $author->articles()->detach($article->id);
            }
            $author->delete();
            return $this->success($author, "Delete Successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function searchAuthor(Request $request)
    {
        try {
            $authors = Author::where('name', 'like', "%{$request->data}%")->orWhere('email', 'like', "%{$request->data}%")->get();
            return $this->success($authors, "Success");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getListArticleByAuthorId(Request $request)
    {
        try {
//            $articles = Author::whereId($request->id)->with('articles')->get();
//            or
            $articles = Author::find($request->id)->articles()->get();
            return $this->success($articles,200);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

}
