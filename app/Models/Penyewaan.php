<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $table = 'penyewaan';
    protected $primaryKey = 'idsewa';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(PenyewaanDetail::class, 'idsewa', 'idsewa');
    }
}
