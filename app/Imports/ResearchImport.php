<?php

namespace App\Imports;

use App\Models\research;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResearchImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new research([
            'tahun_diterima' => $row['tahun_diterima'],
            'tahun_berakhir' => $row['tahun_berakhir'],
            'judul' => $row['judul'],
            'tkt' => $row['tkt'],
            'grant' => $row['grant'],
            'skema' => $row['skema'],
            'tipe_pendanaan' => $row['tipe_pendanaan'],
            'pendanaan_external' => $row['pendanaan_external'],
            'tipe_external' => $row['tipe_external'],
            'lama_penelitian' => $row['lama_penelitian'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}
