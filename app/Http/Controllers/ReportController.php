<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paper;
use App\Models\research;
use App\Models\hki;
use App\Models\member;
use App\Models\partner;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function cetak_pdf_hki()
    {
        $hki = hki::all();

        $pdf = Pdf::loadview('hki_pdf', ['hki' => $hki]);
        return $pdf->download('laporan-hki-pdf');
    }

    public function cetak_pdf_paper()
    {
        $paper = paper::all();

        $pdf = Pdf::loadview('paper_pdf', ['paper' => $paper]);
        return $pdf->download('laporan-paper-pdf');
    }

    public function cetak_pdf_research()
    {
        $research = research::all();

        $pdf = Pdf::loadview('research_pdf', ['research' => $research]);
        return $pdf->download('laporan-research-pdf');
    }

    public function cetak_pdf_member()
    {
        $member = member::all();

        $pdf = Pdf::loadview('member_pdf', ['member' => $member]);
        return $pdf->download('laporan-member-pdf');
    }

    public function cetak_pdf_partner()
    {
        $partner = partner::all();

        $pdf = Pdf::loadview('partner_pdf', ['partner' => $partner]);
        return $pdf->download('laporan-partner-pdf');
    }
}
