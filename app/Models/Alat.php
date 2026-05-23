<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';
    protected $primaryKey = 'idalat';

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'id_kategori');
    }

    public function spesifikasi()
    {
        return $this->hasMany(Spesifikasi::class, 'idalat', 'idalat');
    }

    public function fotoDetail()
    {
        return $this->hasMany(FotoDetail::class, 'idalat', 'idalat');
    }
}
