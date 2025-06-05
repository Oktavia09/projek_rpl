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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id('id_siswa'); // Kolom id_siswa sebagai primary key
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Kunci asing ke tabel users
            $table->string('nisn')->unique()->nullable(); // NISN, unik dan nullable
            $table->string('kelas')->nullable(); // Kelas siswa
            $table->year('tahun_masuk')->nullable(); // Tahun masuk
            $table->enum('status_siswa', ['aktif', 'nonaktif', 'lulus'])->default('aktif'); // Status siswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
