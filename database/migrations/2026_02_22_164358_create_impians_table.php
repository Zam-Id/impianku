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
        Schema::create('impians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained()->cascadeOnDelete();
            $table->string('nama_impian');
            $table->bigInteger('target_dana'); // Pakai bigInteger untuk angka jutaan/miliaran
            $table->date('jatuh_tempo');
            $table->enum('status', ['berjalan', 'tercapai'])->default('berjalan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impians');
    }
};
