<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('id_kembali');
            $table->unsignedBigInteger('id_sewa');
            $table->datetime('tanggal_kembali');
            $table->string('kondisi');
            $table->integer('keterlambatan_hari')->default(0);
            $table->integer('denda_per_hari')->default(0);
            $table->integer('denda_kerusakan')->default(0);
            $table->integer('total_denda')->default(0);
            $table->text('catatan_admin')->nullable();
            $table->string('status');
            $table->string('metode_kembali');
            $table->timestamps();
            
            $table->foreign('id_sewa')->references('idsewa')->on('penyewaan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
