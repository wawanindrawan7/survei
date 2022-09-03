<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketItem extends Model
{
    use HasFactory;
    protected $table = 'tiket_item';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}
