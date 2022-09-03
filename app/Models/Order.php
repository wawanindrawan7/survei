<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tiketItem()
    {
        return $this->hasMany(TiketItem::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class,'order_id');
    }

    public function orderCustomer()
    {
        return $this->hasOne(OrderCustomer::class,'order_id');
    }
}
