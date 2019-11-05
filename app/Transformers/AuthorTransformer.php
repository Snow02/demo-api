<?php
namespace App\Transformers;

use App\Models\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function transform(Author $author){
        return [
            'name' => $author->name,
            'email' => $author->email,
            'phone' => $author->phone,
            'address' => $author->address,

        ];
    }

}

?>