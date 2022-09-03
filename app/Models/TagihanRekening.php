<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanRekening extends Model
{
    use HasFactory;

    protected $table = 'tagihan_rekening';
    public $timestamps = false;

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
