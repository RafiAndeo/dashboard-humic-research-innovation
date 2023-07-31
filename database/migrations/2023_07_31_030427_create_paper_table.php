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
        Schema::create('paper', function (Blueprint $table) {
            $table->id('paper_id');

            $table->string('jenis');
            $table->string('judul');
            $table->string('nama_jurnal');
            $table->string('issue');
            $table->string('volume');
            $table->bigInteger('tahun');
            $table->string('quartile');
            $table->string('index');
            $table->string('link');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper');
    }
};
