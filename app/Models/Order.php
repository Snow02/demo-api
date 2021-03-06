<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    protected $fillable = ['customer_id','date_hire','status'];
    protected $hidden = ['created_at','updated_at'];

    public function articles(){
        return $this->belongsToMany(Article::class,'orders_details')->withPivot('price');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

}
