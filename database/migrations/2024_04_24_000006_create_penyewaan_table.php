<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->id('idsewa');
            $table->unsignedBigInteger('iduser');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi');
            $table->string('metode_pengiriman');
            $table->text('alamat_sewa')->nullable();
            $table->decimal('lat_sewa', 10, 8)->nullable();
            $table->decimal('lon_sewa', 11, 8)->nullable();
            $table->integer('ongkir')->default(0);
            $table->integer('total_biaya');
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->foreign('iduser')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
