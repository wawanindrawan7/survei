<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';
    public $timestamps = false;

    public function tagihanRekening()
    {
        return $this->hasMany(TagihanRekening::class);
    }

    
}
