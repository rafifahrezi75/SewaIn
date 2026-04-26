<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idalat');
            $table->integer('jumlah');
            $table->integer('hargakeranjang');
            $table->timestamps();
            
            $table->foreign('iduser')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('idalat')->references('idalat')->on('alat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
