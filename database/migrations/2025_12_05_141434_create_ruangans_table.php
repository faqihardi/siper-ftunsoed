<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id('ruang_id');
            $table->foreignId('gedung_id')->constrained('gedungs','gedung_id')->onDelete('cascade');
            $table->string('nama_ruang');
            $table->unsignedInteger('kapasitas');
            $table->string('tipe_ruang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
