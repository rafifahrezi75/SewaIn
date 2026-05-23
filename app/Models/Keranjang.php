<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    protected $fillable = [
        'iduser',
        'idalat',
        'jumlah',
        'hargakeranjang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'id_user');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'idalat', 'idalat');
    }
}
