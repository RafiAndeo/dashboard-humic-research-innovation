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

    public function paper()
    {
        $paper = paper::all();
        return view('report.report_paper', ['data' => $paper]);
        // $pdf = Pdf::loadview('report.report_paper', ['data' => $paper]);
        // return $pdf->download('laporan-paper-pdf');
        // return $pdf->stream();
    }

    public function hki()
    {
        $hki = hki::all();
        return view('report.report_hki', ['data' => $hki]);
        // $pdf = Pdf::loadview('report.report_paper', ['data' => $paper]);
        // return $pdf->download('laporan-paper-pdf');
        // return $pdf->stream();
    }

    public function member()
    {
        $member = member::all();
        return view('report.report_member', ['data' => $member]);
    }

    public function partner()
    {
        $partner = partner::all();
        return view('report.report_partner', ['data' => $partner]);
    }

    public function research()
    {
        $research = research::all();
        return view('report.report_research', ['data' => $research]);
        // $pdf = Pdf::loadview('report.report_paper', ['data' => $paper]);
        // return $pdf->download('laporan-paper-pdf');
        // return $pdf->stream();
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
