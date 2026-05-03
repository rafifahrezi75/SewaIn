<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $guarded = [];

    public function alat()
    {
        return $this->hasMany(Alat::class, 'idkategori', 'id_kategori');
    }
}
