<?php

namespace App\Exports;

use App\Models\partner;
use Maatwebsite\Excel\Concerns\FromCollection;

class PartnerExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return partner::all();
    }
}
