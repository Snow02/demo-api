<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmRegister extends Model
{
    protected $fillable =['email','token','created_at','updated_at'] ;
}
