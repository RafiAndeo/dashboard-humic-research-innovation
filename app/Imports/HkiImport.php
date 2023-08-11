<?php

namespace App\Imports;

use App\Models\hki;
use Maatwebsite\Excel\Concerns\ToModel;

class HkiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new hki([
            'tahun' => $row[0],
            'judul' => $row[1],
            'jenis' => $row[2],
            'status' => $row[3],
        ]);
    }
}
