<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoDetail extends Model
{
    use HasFactory;

    protected $table = 'fotodetail';
    protected $primaryKey = 'id_foto';

    protected $fillable = [
        'idalat',
        'fotodetail',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'idalat', 'idalat');
    }
}
