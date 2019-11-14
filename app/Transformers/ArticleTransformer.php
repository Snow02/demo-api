<?php
namespace App\Transformers;

use App\Models\Article;
use App\Models\Author;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    private $fractal;
    private $authorTransformer;
    public function __construct(Manager $fractal, AuthorTransformer $authorTransformer)
    {
        $this->fractal = $fractal;
        $this->authorTransformer = $authorTransformer;
    }

    public function formatAuthorData($authors)
    {
        $authors = new Collection($authors, $this->authorTransformer); // Create a resource collection transformer
        return $this->fractal->createData($authors)->toArray(); // Transform data
    }


    protected $availableIncludes = ['media','authors'];


    public function transform(Article $article)
    {
        $media_urls =[];
        foreach($article->media as $media){
            $media_urls[] = [
                'origin_url' => $media->getFullUrl(),
                'thumbnail_url' =>$media->getFullUrl('thumb'),
            ];
        }
        $article->avatar = count($media_urls) ? $media_urls[0] : Null ;

        $authors = $this->formatAuthorData($article->authors);
//        $authors = $article->authors;
        return [
            'id' => $article->id,
            'title' => $article->title,
            'desc' => $article->desc,
            'content' => $article->content,
            'images' => $media_urls,
            'avatar' => $article->avatar,
            'author' => $authors,

        ];
    }



}
?>