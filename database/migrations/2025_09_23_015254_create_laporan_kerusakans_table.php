<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakans', function (Blueprint $table) {
            $table->id(); // default "id"
            $table->foreignId('pengguna_id')->constrained('penggunas')->cascadeOnDelete();
            $table->string('lokasi');
            $table->text('deskripsi_kerusakan');
            $table->enum('jenis_kerusakan', ['alat','ruangan','lainnya']);
            $table->string('url_gambar')->nullable();
            $table->enum('status_laporan', ['diajukan','diproses','selesai','dibatalkan'])->default('diajukan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakans');
    }
};
