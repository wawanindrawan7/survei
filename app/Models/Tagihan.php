<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tagihanRekening()
    {
        return $this->hasOne(TagihanRekening::class);
    }
}
