<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ArticleController extends Controller
{
    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:articles,title',
                'content' => 'required',
                'author_id' => 'exists:authors,id',
            ]);
            if ($validator->fails()) {
                // $errorString = implode(",",$validator->messages()->all());
                return $this->fail($validator->errors(), $validator->messages()->first(), "false", 401);
            }
            $input = $request->all();
            $article = Article::create($input);
            if ($article) {
                $article->authors()->attach($request->get('author_id'));
                return $this->success($article, "Create Article Success");
            }
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function showAll()
    {
        try {
            $articles = Article::all();
            return $this->success($articles, "show all articles");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getArticleById(Request $request)
    {
        try {
            $article = Article::find($request->id);
            return $this->success($article, "show article id = $request->id");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function updateArticleById(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:articles,title',
                'content' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), "false", 401);
            }
            $article = Article::find($request->id)->update([
                'title' => $request->get('title'),
                'desc' => $request->get('desc'),
                'content' => $request->get('content'),
            ]);
            return $this->success($article, "Update Article successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function deleteArticleById(Request $request)
    {
        try {

            $article = Article::findOrFail($request->id);
            foreach ($article->authors as $author) {
                $article->authors()->detach($author->id);
            }
            $article->delete();
            return $this->success($article, "Delete Article successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
    public function getAuthorOfTheArticle(Request $request)
    {
        try {

            $author = Article::findOrFail($request->id)->authors()->get();

            return $this->success($author, "Author of the article id $request->id");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

}
