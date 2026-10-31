<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('no_hp', 20);
            $table->string('lokasi');
            $table->string('kecamatan');
            $table->unsignedInteger('tinggi_air');   // satuan cm
            $table->text('keterangan');
            $table->string('foto')->nullable();      // path relatif pada disk public
            $table->string('status')->default('Menunggu'); // Menunggu | Diproses | Selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
