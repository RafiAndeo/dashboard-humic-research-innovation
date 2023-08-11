<?php

namespace App\Exports;

use App\Models\hki;
use Maatwebsite\Excel\Concerns\FromCollection;

class HkiExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return hki::all();
    }
}
