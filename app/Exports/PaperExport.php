<?php

namespace App\Exports;

use App\Models\paper;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaperExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return paper::all();
    }
}
