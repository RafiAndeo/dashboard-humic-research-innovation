<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\MemberImport;
use App\Imports\HkiImport;
use App\Imports\PaperImport;
use App\Imports\PartnerImport;
use App\Imports\ResearchImport;
use Maatwebsite\Excel\Facades\Excel;


class ImportController extends Controller
{
    public function import_all()
    {
        Excel::import(new HkiImport, 'hki.xlsx', 'public');
        Excel::import(new PaperImport, 'paper.xlsx', 'public');
        Excel::import(new PartnerImport, 'partner.xlsx', 'public');
        Excel::import(new ResearchImport, 'research.xlsx', 'public');
        Excel::import(new MemberImport, 'member.xlsx', 'public');

        return "OK";
    }
}
