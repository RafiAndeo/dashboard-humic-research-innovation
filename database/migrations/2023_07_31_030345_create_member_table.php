<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('fakultas');
            $table->string('pendidikan');
            $table->string('bidang_ilmu');
            $table->string('jabatan');
            $table->string('kelompok_keahlian');
            $table->string('email');
            $table->string('membership');
            $table->string('status');
            $table->bigInteger('NIP');
            $table->string('role');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });


        DB::statement("ALTER TABLE member ADD photo LONGBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
