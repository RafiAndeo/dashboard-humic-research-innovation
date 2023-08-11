<?php

namespace App\Exports;

use App\Models\research;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResearchExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return research::all();
    }
}
