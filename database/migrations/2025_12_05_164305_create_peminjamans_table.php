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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id('peminjaman_id');
            $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
            $table->foreignId('ruang_id')->constrained('ruangans','ruang_id')->onDelete('cascade');
            $table->unsignedInteger('durasi');
            $table->string('tujuan');
            $table->text('detail_kegiatan');
            $table->date('tanggal_peminjaman');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->string('status')->default('diajukan');
            $table->text('notes');
            $table->timestamps();
            $table->index(['ruang_id','tanggal_peminjaman']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
