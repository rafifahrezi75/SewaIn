<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id_kembali';

    protected $guarded = [];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'id_sewa', 'idsewa');
    }
}

