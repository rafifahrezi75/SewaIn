<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spesifikasi', function (Blueprint $table) {
            $table->id('id_spek');
            $table->unsignedBigInteger('idalat');
            $table->string('spek');
            $table->string('iconspek')->nullable();
            $table->string('satuan')->nullable();
            $table->timestamps();
            
            $table->foreign('idalat')->references('idalat')->on('alat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spesifikasi');
    }
};
