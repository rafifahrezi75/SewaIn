<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesifikasi extends Model
{
    use HasFactory;

    protected $table = 'spesifikasi';
    protected $primaryKey = 'id_spek';

    protected $fillable = [
        'idalat',
        'spek',
        'iconspek',
        'satuan',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'idalat', 'idalat');
    }
}
