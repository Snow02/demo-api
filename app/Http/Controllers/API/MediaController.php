<?php

namespace App\Http\Controllers\API;

use App\Models\Media;
use App\Models\Product;
use App\Transformers\MyArraySerializer;
use App\Transformers\MediaTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use League\Fractal\Manager;
use Validator;

class MediaController extends Controller
{

    private $fractal;
    private $mediaTransformer;

//    public function __construct(Manager $fractal, MediaTransformer $mediaTransformer)
//    {
//        $this->fractal = $fractal;
//        $this->fractal->setSerializer(new MyArraySerializer());
//        $this->mediaTransformer = $mediaTransformer;
//    }

//    public function formatMediaData($products)
//    {
//        $products = new Collection($products, $this->mediaTransformer);
//        return $this->fractal->createData($products)->toArray();
//    }

//    public function getAllMedia()
//    {
//        $media = Media::all();
//        $media = $this->formatMediaData($media);
//        return $media;
//    }

    public function uploadMedia($request, $model)
    {
//        if ($request->hasfile('file')) {
//            $file = $request->file('file');
//            $pathImage = $file->getPathname();
//
//                     $category
//                         ->addMediaFromUrl($image_url)
//                         ->toMediaCollection();
//        }

        $model->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection();
        });


    }
}
