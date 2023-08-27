<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('member')->insert([
            'nama' => Str::random(10),
            'fakultas' => Str::random(10),
            'pendidikan' => Str::random(10),
            'bidang_ilmu' => Str::random(10),
            'jabatan' => Str::random(10),
            'kelompok_keahlian' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'membership' => Str::random(10),
            'status' => Str::random(10),
            'NIP' => random_int(10000000, 99999999),
            'password' => bcrypt('password'),
            'role' => Str::random(10),
        ]);

        DB::table('research')->insert([
            'tahun_diterima' => random_int(2000, 2023),
            'tahun_berakhir' => random_int(2000, 2023),
            'judul' => Str::random(10),
            'tkt' => random_int(1000, 1000000000),
            'grant' => random_int(1000, 1000000000),
            'skema' => Str::random(10),
            'tipe_pendanaan' => Str::random(10),
            'pendanaan_external' => Str::random(10),
            'tipe_external' => Str::random(10),
            'lama_penelitian' => random_int(1, 10),
            'keterangan' => Str::random(10),
            'isVerified' => false
        ]);

        DB::table('paper')->insert([
            "jenis" => Str::random(10),
            "judul" => Str::random(10),
            "nama_jurnal" => Str::random(10),
            "issue" => Str::random(10),
            "volume" => Str::random(10),
            "tahun" => random_int(2000, 2023),
            "quartile" => Str::random(10),
            "index" => Str::random(10),
            "link" => Str::random(10),
            'isVerified' => false
        ]);

        DB::table('hki')->insert([
            'tahun' => random_int(2000, 2023),
            'judul' => Str::random(10),
            'jenis' => Str::random(10),
            'status' => Str::random(10),
            'isVerified' => false
        ]);

        DB::table('partner')->insert([
            "nama_partner" => Str::random(10),
            "sumber" => Str::random(10),
            "institusi" => Str::random(10),
            "jabatan" => Str::random(10),
            "negara" => Str::random(10),
            "type" => Str::random(10),
        ]);
    }
}