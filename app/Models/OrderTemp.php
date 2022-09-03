<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTemp extends Model
{
    use HasFactory;

    protected $table = 'order_temp';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}
