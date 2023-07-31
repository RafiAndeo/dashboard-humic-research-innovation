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
        Schema::create('research', function (Blueprint $table) {
            $table->id('research_id');

            $table->bigInteger('tahun_diterima');
            $table->bigInteger('tahun_berakhir');
            $table->string('judul');
            $table->bigInteger('tkt');
            $table->bigInteger('grant');
            $table->string('skema');
            $table->string('tipe_pendanaan');
            $table->string('pendanaan_external');
            $table->string('tipe_external');
            $table->string('lama_penelitian');
            $table->string('keterangan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
