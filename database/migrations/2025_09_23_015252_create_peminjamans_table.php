<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengguna_id')->constrained('penggunas')->cascadeOnDelete();
    $table->date('tanggal');
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->enum('status_peminjaman', [
        'pending','disetujui','ditolak','selesai','dibatalkan'
    ])->default('pending');
    $table->timestamps();
});


    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
