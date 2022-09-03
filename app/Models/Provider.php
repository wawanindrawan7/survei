<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $table = 'provider';
    public $timestamps = false;

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
