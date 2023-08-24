<?php

namespace App\Imports;

use App\Models\paper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PaperImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new paper([
            'jenis' => $row['jenis'],
            'judul' => $row['judul'],
            'nama_jurnal' => $row['nama_jurnal'],
            'issue' => $row['issue'],
            'volume' => $row['volume'],
            'tahun' => $row['tahun'],
            'quartile' => $row['quartile'],
            'index' => $row['index'],
            'link' => $row['link'],
            'isVerified' => false,
        ]);
    }
}