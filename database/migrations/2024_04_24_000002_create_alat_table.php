<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->id('idalat');
            $table->unsignedBigInteger('idkategori');
            $table->string('nama_alat');
            $table->integer('harga_sewa');
            $table->integer('stok');
            $table->string('status')->default('tersedia');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
            
            $table->foreign('idkategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
