<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Transformers\ArticleTransformer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Validator;

/**
 * @property  MediaController
 *
 */
class ArticleController extends Controller
{

    private $fractal;
    private $articleTransformer;

    public function __construct(
        Manager $fractal,
        ArticleTransformer $articleTransformer

    ) {
        $this->fractal = $fractal;
        $this->articleTransformer = $articleTransformer;
    }
    public function formatArticleData($articles){
        $articles = new Collection($articles, $this->articleTransformer); // Create a resource collection transformer
        return  $this->fractal->createData($articles)->toArray(); // Transform data
    }

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
                if($request->hasFile('images')){
//                    $article->addMediaFromRequest('images')->toMediaCollection("Image Article");

                    $fileAdders = $article
                        ->addAllMediaFromRequest(['images'])
                        ->each(function ($fileAdder) {
                            $fileAdder->toMediaCollection('article-images');
                        });

                }
                return $this->success($article, "Create Article Success");
            }
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAll()
    {
        try {
            // Get all
//            $articles = Article::with('authors')->get();
            // Get all article with at least one author
            $articles = Article::Has('authors')->get();
            $articles = $this->formatArticleData($articles);
            return $this->success($articles, "show all articles");

        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getArticleById(Request $request)
    {
        try {
            $article = Article::find($request->id);
            $article->authors;

            $media_urls = [];
            foreach($article->media as $media){
                $media_urls[] = [
                    'origin_url' => $media->getFullUrl(),
                    'thumbnail_url' => $media->getFullUrl('thumb'),
                ];
                $article->images = $media_urls;
                $article->avatar = $media_urls[0];
            }

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
