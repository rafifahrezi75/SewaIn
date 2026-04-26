<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyewaan_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('idsewa');
            $table->unsignedBigInteger('idalat');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('subtotal');
            $table->string('gambar_ktp')->nullable();
            $table->timestamps();
            
            $table->foreign('idsewa')->references('idsewa')->on('penyewaan')->onDelete('cascade');
            $table->foreign('idalat')->references('idalat')->on('alat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaan_detail');
    }
};
