<?php

namespace App\Imports;

use App\Models\partner;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartnerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new partner([
            'nama_partner' => $row['nama_partner'],
            'sumber' => $row['sumber'],
            'institusi' => $row['institusi'],
            'jabatan' => $row['jabatan'],
            'negara' => $row['negara'],
            'type' => $row['type'],
        ]);
    }
}
