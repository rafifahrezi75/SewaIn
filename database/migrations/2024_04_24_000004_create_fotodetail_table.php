<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotodetail', function (Blueprint $table) {
            $table->id('id_foto');
            $table->unsignedBigInteger('idalat');
            $table->string('fotodetail');
            $table->timestamps();
            
            $table->foreign('idalat')->references('idalat')->on('alat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotodetail');
    }
};
