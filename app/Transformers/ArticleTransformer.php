<?php
namespace App\Transformers;

use App\Models\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
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

        return [
            'id' => $article->id,
            'title' => $article->title,
            'desc' => $article->desc,
            'content' => $article->content,
            'images' => $media_urls,
            'avatar' => $article->avatar,

        ];
    }
}
?>