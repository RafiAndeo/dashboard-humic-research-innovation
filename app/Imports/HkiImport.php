<?php

namespace App\Imports;

use App\Models\hki;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HkiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new hki([
            'tahun' => $row['tahun'],
            'judul' => $row['judul'],
            'jenis' => $row['jenis'],
            'status' => $row['status'],
        ]);
    }
}