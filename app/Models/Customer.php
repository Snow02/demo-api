<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','phone','address'];
    protected $hidden = ['created_at','updated_at'];

    public function orders(){
        return $this->hasMany(Order::class);
    }


}
