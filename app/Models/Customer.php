<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use Notifiable;
    protected $fillable = ['name','phone','address','email'];
    protected $hidden = ['created_at','updated_at'];

    public function orders(){
        return $this->hasMany(Order::class);
    }


}
