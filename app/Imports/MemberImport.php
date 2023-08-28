<?php

namespace App\Imports;

use App\Models\member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class MemberImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new member([
            'nama' => $row['nama'],
            'fakultas' => $row['fakultas'],
            'pendidikan' => $row['pendidikan'],
            'bidang_ilmu' => $row['bidang_ilmu'],
            'jabatan' => $row['jabatan'],
            'kelompok_keahlian' => $row['kelompok_keahlian'],
            'email' => $row['email'],
            'photo' => $row['photo'],
            'membership' => $row['membership'],
            'status' => $row['status'],
            'role' => $row['role'],
            'NIP' => $row['nip'],
            'password' => Hash::make("password"),
        ]);
    }
}
