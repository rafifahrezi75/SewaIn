<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyewaanDetail extends Model
{
    use HasFactory;

    protected $table = 'penyewaan_detail';
    protected $primaryKey = 'id_detail';

    protected $guarded = [];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'idsewa', 'idsewa');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'idalat', 'idalat');
    }
}
