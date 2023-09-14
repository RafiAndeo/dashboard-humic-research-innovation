<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paper;
use App\Models\research;
use App\Models\hki;
use App\Models\member;
use App\Models\member_hki;
use App\Models\member_paper;
use App\Models\member_research;
use App\Models\partner;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // public function cetak_pdf_hki()
    // {
    //     $hki = hki::all();

    //     $pdf = Pdf::loadview('hki_pdf', ['hki' => $hki]);
    //     return $pdf->download('laporan-hki-pdf');
    // }

    public function paper(Request $request)
    {
        $data = paper::query();
        $data_count = paper::query();
        $paper_jenis = paper::select('jenis', DB::raw('count(*) as total'))->groupBy('jenis');
        $tahun = paper::select('tahun', DB::raw('count(*) as total'))->groupBy('tahun');

        if ($request->has('quartile') && $request->quartile != 'all') {
            $data = $data->where('quartile', $request->quartile);

            $paper_jenis = $paper_jenis->where('quartile', $request->quartile);
            $tahun = $tahun->where('quartile', $request->quartile);
            $data_count = $data_count->where('quartile', $request->quartile);
        }

        if ($request->has('tahun') && $request->tahun != 'all') {
            $data = $data->where('tahun', $request->tahun);

            $paper_jenis = $paper_jenis->where('tahun', $request->tahun);
            $tahun = $tahun->where('tahun', $request->tahun);
            $data_count = $data_count->where('tahun', $request->tahun);
        }

        if ($request->has('jenis') && $request->jenis != 'all') {
            $data = $data->where('jenis', $request->jenis);

            $paper_jenis = $paper_jenis->where('jenis', $request->jenis);
            $tahun = $tahun->where('jenis', $request->jenis);
            $data_count = $data_count->where('jenis', $request->jenis);
        }

        $data = $data->where('isVerified', 1)->get();
        $data_count = $data_count->where('isVerified', 1)->count();

        $paper_jenis = $paper_jenis->where('isVerified', 1)->get();
        $label_jenis = $paper_jenis->pluck('jenis');
        $total_jenis = $paper_jenis->pluck('total');

        $tahun = $tahun->where('isVerified', 1)->get();
        $label = $tahun->pluck('tahun');
        $total = $tahun->pluck('total');

        $quartile_option = paper::select('quartile')->where('isVerified', 1)->distinct()->pluck('quartile');
        $tahun_option = paper::select('tahun')->where('isVerified', 1)->distinct()->pluck('tahun');
        $jenis_option = paper::select('jenis')->where('isVerified', 1)->distinct()->pluck('jenis');


        return view('report.report_paper', [
            'data' => $data,
            'data_count' => $data_count,
            'label' => $label,
            'total' => $total,
            'label_jenis' => $label_jenis,
            'total_jenis' => $total_jenis,
            'quartile_option' => $quartile_option,
            'tahun_option' => $tahun_option,
            'jenis_option' => $jenis_option,

        ]);
        // $pdf = Pdf::loadview('report.report_paper', ['data' => $paper]);
        // return $pdf->download('laporan-paper-pdf');
        // return $pdf->stream();
    }

    public function hki(Request $request)
    {
        $data = hki::query();

        $tahun_option = hki::select('tahun')->where('isVerified', 1)->distinct()->pluck('tahun');
        $jenis_option = hki::select('jenis')->where('isVerified', 1)->distinct()->pluck('jenis');
        $status_option = hki::select('status')->where('isVerified', 1)->distinct()->pluck('status');

        $hki_tahun = hki::select('tahun', DB::raw('count(*) as total'))->groupBy('tahun');
        $hki_jenis = hki::select('jenis', DB::raw('count(*) as total'))->groupBy('jenis');
        $hki_status = hki::select('status', DB::raw('count(*) as total'))->groupBy('status');

        if ($request->has('tahun') && $request->tahun != 'all') {
            $data = $data->where('tahun', $request->tahun);
            $hki_tahun = $hki_tahun->where('tahun', $request->tahun);
            $hki_jenis = $hki_jenis->where('tahun', $request->tahun);
            $hki_status = $hki_status->where('tahun', $request->tahun);
        }

        if ($request->has('jenis') && $request->jenis != 'all') {
            $data = $data->where('jenis', $request->jenis);
            $hki_tahun = $hki_tahun->where('jenis', $request->jenis);
            $hki_jenis = $hki_jenis->where('jenis', $request->jenis);
            $hki_status = $hki_status->where('jenis', $request->jenis);
        }

        if ($request->has('status') && $request->status != 'all') {
            $data = $data->where('status', $request->status);
            $hki_tahun = $hki_tahun->where('status', $request->status);
            $hki_jenis = $hki_jenis->where('status', $request->status);
            $hki_status = $hki_status->where('status', $request->status);
        }

        $data = $data->where('isVerified', 1)->get();
        $count = $data->count();

        $hki_tahun = $hki_tahun->where('isVerified', 1)->get();
        $label_tahun = $hki_tahun->pluck('tahun');
        $total_tahun = $hki_tahun->pluck('total');

        $hki_jenis = $hki_jenis->where('isVerified', 1)->get();
        $label_jenis = $hki_jenis->pluck('jenis');
        $total_jenis = $hki_jenis->pluck('total');

        $hki_status = $hki_status->where('isVerified', 1)->get();
        $label_status = $hki_status->pluck('status');
        $total_status = $hki_status->pluck('total');

        return view('report.report_hki', [
            'data' => $data,
            'count' => $count,
            'label_tahun' => $label_tahun,
            'total_tahun' => $total_tahun,
            'label_jenis' => $label_jenis,
            'total_jenis' => $total_jenis,
            'label_status' => $label_status,
            'total_status' => $total_status,
            'tahun_option' => $tahun_option,
            'jenis_option' => $jenis_option,
            'status_option' => $status_option,

        ]);
    }

    public function member(Request $request)
    {
        $member = member::all();
        $data = member::query();
        $member_fakultas = member::select('fakultas', DB::raw('count(*) as total'))
            ->groupBy('fakultas');
        $member_pendidikan = member::select('pendidikan', DB::raw('count(*) as total'))
            ->groupBy('pendidikan');
        $member_kelompok_keahlian = member::select('kelompok_keahlian', DB::raw('count(*) as total'))
            ->groupBy('kelompok_keahlian');
        $member_jabatan = member::select('jabatan', DB::raw('count(*) as total'))
            ->groupBy('jabatan');

        $fakultas_option = member::select('fakultas')->distinct()->pluck('fakultas');
        $pendidikan_option = member::select('pendidikan')->distinct()->pluck('pendidikan');
        $kelompok_keahlian_option = member::select('kelompok_keahlian')->distinct()->pluck('kelompok_keahlian');
        $jabatan_option = member::select('jabatan')->distinct()->pluck('jabatan');

        if ($request->has('fakultas') && $request->fakultas != 'all') {
            $data = $data->where('fakultas', $request->fakultas);
            $member_fakultas = $member_fakultas->where('fakultas', $request->fakultas);
            $member_pendidikan = $member_pendidikan->where('fakultas', $request->fakultas);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('fakultas', $request->fakultas);
        }

        if ($request->has('pendidikan') && $request->pendidikan != 'all') {
            $data = $data->where('pendidikan', $request->pendidikan);
            $member_fakultas = $member_fakultas->where('pendidikan', $request->pendidikan);
            $member_pendidikan = $member_pendidikan->where('pendidikan', $request->pendidikan);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('pendidikan', $request->pendidikan);
        }

        if ($request->has('kelompok_keahlian') && $request->kelompok_keahlian != 'all') {
            $data = $data->where('kelompok_keahlian', $request->kelompok_keahlian);
            $member_fakultas = $member_fakultas->where('kelompok_keahlian', $request->kelompok_keahlian);
            $member_pendidikan = $member_pendidikan->where('kelompok_keahlian', $request->kelompok_keahlian);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('kelompok_keahlian', $request->kelompok_keahlian);
        }

        if ($request->has('jabatan') && $request->jabatan != 'all') {
            $data = $data->where('jabatan', $request->jabatan);
            $member_fakultas = $member_fakultas->where('jabatan', $request->jabatan);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('jabatan', $request->jabatan);
            $member_pendidikan = $member_pendidikan->where('jabatan', $request->jabatan);
            $member_jabatan = $member_jabatan->where('jabatan', $request->jabatan);
        }

        $count = $data->count();
        $data = $data->get();

        $member_fakultas = $member_fakultas->get();
        $label_fakultas = $member_fakultas->pluck('fakultas');
        $total_fakultas = $member_fakultas->pluck('total');

        $member_pendidikan = $member_pendidikan->get();
        $label_pendidikan = $member_pendidikan->pluck('pendidikan');
        $total_pendidikan = $member_pendidikan->pluck('total');

        $member_kelompok_keahlian = $member_kelompok_keahlian->get();
        $label_kelompok_keahlian = $member_kelompok_keahlian->pluck('kelompok_keahlian');
        $total_kelompok_keahlian = $member_kelompok_keahlian->pluck('total');

        $member_jabatan = $member_jabatan->get();
        $label_jabatan = $member_jabatan->pluck('jabatan');
        $total_jabatan = $member_jabatan->pluck('total');
        return view('report.report_member', [
            'data' => $member,
            'count' => $count,
            'label_fakultas' => $label_fakultas,
            'total_fakultas' => $total_fakultas,
            'label_pendidikan' => $label_pendidikan,
            'total_pendidikan' => $total_pendidikan,
            'label_kelompok_keahlian' => $label_kelompok_keahlian,
            'total_kelompok_keahlian' => $total_kelompok_keahlian,
            'label_jabatan' => $label_jabatan,
            'total_jabatan' => $total_jabatan,
            'fakultas_option' => $fakultas_option,
            'pendidikan_option' => $pendidikan_option,
            'kelompok_keahlian_option' => $kelompok_keahlian_option,
            'jabatan_option' => $jabatan_option,
        ]);
    }

    public function partner(Request $request)
    {
        $data = partner::query();

        $institusi_option = partner::select('institusi')->distinct()->pluck('institusi');
        $jabatan_option = partner::select('jabatan')->distinct()->pluck('jabatan');
        $negara_option = partner::select('negara')->distinct()->pluck('negara');
        $type_option = partner::select('type')->distinct()->pluck('type');

        $partner_institusi = partner::select('institusi', DB::raw('count(*) as total'))->groupBy('institusi');
        $partner_jabatan = partner::select('jabatan', DB::raw('count(*) as total'))->groupBy('jabatan');
        $partner_negara = partner::select('negara', DB::raw('count(*) as total'))->groupBy('negara');
        $partner_type = partner::select('type', DB::raw('count(*) as total'))->groupBy('type');

        if ($request->has('institusi') && $request->institusi != 'all') {
            $data = $data->where('institusi', $request->institusi);
            $partner_institusi = $partner_institusi->where('institusi', $request->institusi);
            $partner_jabatan = $partner_jabatan->where('institusi', $request->institusi);
            $partner_negara = $partner_negara->where('institusi', $request->institusi);
            $partner_type = $partner_type->where('institusi', $request->institusi);

            $negara_option = partner::select('negara')->where('institusi', $request->institusi)->distinct()->pluck('negara');
        }

        if ($request->has('jabatan') && $request->jabatan != 'all') {
            $data = $data->where('jabatan', $request->jabatan);
            $partner_institusi = $partner_institusi->where('jabatan', $request->jabatan);
            $partner_jabatan = $partner_jabatan->where('jabatan', $request->jabatan);
            $partner_negara = $partner_negara->where('jabatan', $request->jabatan);
            $partner_type = $partner_type->where('jabatan', $request->jabatan);
        }

        if ($request->has('negara') && $request->negara != 'all') {
            $data = $data->where('negara', $request->negara);
            $partner_institusi = $partner_institusi->where('negara', $request->negara);
            $partner_jabatan = $partner_jabatan->where('negara', $request->negara);
            $partner_negara = $partner_negara->where('negara', $request->negara);
            $partner_type = $partner_type->where('negara', $request->negara);

            $institusi_option = partner::select('institusi')->where('negara', $request->negara)->distinct()->pluck('institusi');
        }

        if ($request->has('type') && $request->type != 'all') {
            $data = $data->where('type', $request->type);
            $partner_institusi = $partner_institusi->where('type', $request->type);
            $partner_jabatan = $partner_jabatan->where('type', $request->type);
            $partner_negara = $partner_negara->where('type', $request->type);
            $partner_type = $partner_type->where('type', $request->type);
        }

        $count = $data->count();
        $data = $data->get();

        $partner_institusi = $partner_institusi->get();
        $label_institusi = $partner_institusi->pluck('institusi');
        $total_institusi = $partner_institusi->pluck('total');

        $partner_jabatan = $partner_jabatan->get();
        $label_jabatan = $partner_jabatan->pluck('jabatan');
        $total_jabatan = $partner_jabatan->pluck('total');

        $partner_negara = $partner_negara->get();
        $label_negara = $partner_negara->pluck('negara');
        $total_negara = $partner_negara->pluck('total');

        $partner_type = $partner_type->get();
        $label_type = $partner_type->pluck('type');
        $total_type = $partner_type->pluck('total');
        return view('report.report_partner', [
            'data' => $data,
            'count' => $count,
            'label_institusi' => $label_institusi,
            'total_institusi' => $total_institusi,
            'label_jabatan' => $label_jabatan,
            'total_jabatan' => $total_jabatan,
            'label_negara' => $label_negara,
            'total_negara' => $total_negara,
            'label_type' => $label_type,
            'total_type' => $total_type,
            'institusi_option' => $institusi_option,
            'jabatan_option' => $jabatan_option,
            'negara_option' => $negara_option,
            'type_option' => $type_option,
        ]);
    }

    public function research(Request $request)
    {
        $research = research::query();
        $riset_tahun_diterima = research::select('tahun_diterima', DB::raw('count(*) as total'))->groupBy('tahun_diterima');
        $riset_tipe_pendanaan = research::select('tipe_pendanaan', DB::raw('count(*) as total'))->groupBy('tipe_pendanaan');
        $riset_tkt = research::select('tkt', DB::raw('count(*) as total'))->groupBy('tkt');
        $riset_skema = research::select('skema', DB::raw('count(*) as total'))->groupBy('skema');

        $tahun_diterima_option = research::select('tahun_diterima')->where('isVerified', 1)->distinct()->pluck('tahun_diterima');
        $tahun_berakhir_option = research::select('tahun_berakhir')->where('isVerified', 1)->distinct()->pluck('tahun_berakhir');
        $tipe_pendanaan_option = research::select('tipe_pendanaan')->where('isVerified', 1)->distinct()->pluck('tipe_pendanaan');
        $tkt_option = research::select('tkt')->distinct()->where('isVerified', 1)->pluck('tkt');
        $skema_option = research::select('skema')->distinct()->where('isVerified', 1)->pluck('skema');

        if ($request->has('tahun_diterima') && $request->tahun_diterima != 'all') {
            $research = $research->where('tahun_diterima', (int) $request->tahun_diterima);
            $riset_tahun_diterima = $riset_tahun_diterima->where('tahun_diterima', (int) $request->tahun_diterima);
            $riset_tipe_pendanaan = $riset_tipe_pendanaan->where('tahun_diterima', (int) $request->tahun_diterima);
        }

        if ($request->has('tahun_berakhir') && $request->tahun_berakhir != 'all') {
            $research = $research->where('tahun_berakhir', (int) $request->tahun_berakhir);
            $riset_tahun_diterima = $riset_tahun_diterima->where('tahun_berakhir', (int) $request->tahun_berakhir);
            $riset_tipe_pendanaan = $riset_tipe_pendanaan->where('tahun_berakhir', (int) $request->tahun_berakhir);
        }

        if ($request->has('tipe_pendanaan') && $request->tipe_pendanaan != 'all') {
            $research = $research->where('tipe_pendanaan', $request->tipe_pendanaan);
            $riset_tahun_diterima = $riset_tahun_diterima->where('tipe_pendanaan', $request->tipe_pendanaan);
            $riset_tipe_pendanaan = $riset_tipe_pendanaan->where('tipe_pendanaan', $request->tipe_pendanaan);
        }

        if ($request->has('tkt') && $request->tkt != 'all') {
            $research = $research->where('tkt', $request->tkt);
            $riset_tahun_diterima = $riset_tahun_diterima->where('tkt', $request->tkt);
            $riset_tipe_pendanaan = $riset_tipe_pendanaan->where('tkt', $request->tkt);
            $riset_tkt = $riset_tkt->where('tkt', $request->tkt);
        }

        if ($request->has('skema') && $request->skema != 'all') {
            $research = $research->where('skema', $request->skema);
            $riset_tahun_diterima = $riset_tahun_diterima->where('skema', $request->skema);
            $riset_tipe_pendanaan = $riset_tipe_pendanaan->where('skema', $request->skema);
            $riset_tkt = $riset_tkt->where('tkt', $request->tkt);
            $riset_skema = $riset_skema->where('skema', $request->skema);
        }

        $research = $research->where('isVerified', 1)->get();
        $research_count = $research->count();

        $riset_tahun_diterima = $riset_tahun_diterima->where('isVerified', 1)->get();
        $label_tahun_diterima = $riset_tahun_diterima->pluck('tahun_diterima');
        $total_tahun_diterima = $riset_tahun_diterima->pluck('total');

        $riset_tipe_pendanaan = $riset_tipe_pendanaan->where('isVerified', 1)->get();
        $label_tipe_pendanaan = $riset_tipe_pendanaan->pluck('tipe_pendanaan');
        $total_tipe_pendanaan = $riset_tipe_pendanaan->pluck('total');

        $riset_tkt = $riset_tkt->where('isVerified', 1)->get();
        $label_tkt = $riset_tkt->pluck('tkt');
        $total_tkt = $riset_tkt->pluck('tkt');

        return view('report.report_research', [
            'data' => $research,
            'data_count' => $research_count,
            'tahun_diterima_option' => $tahun_diterima_option,
            'tahun_berakhir_option' => $tahun_berakhir_option,
            'tipe_pendanaan_option' => $tipe_pendanaan_option,
            'tkt_option' => $tkt_option,
            'skema_option' => $skema_option,
            'label_tahun_diterima' => $label_tahun_diterima,
            'total_tahun_diterima' => $total_tahun_diterima,
            'label_tipe_pendanaan' => $label_tipe_pendanaan,
            'total_tipe_pendanaan' => $total_tipe_pendanaan,
            'label_tkt' => $label_tkt,
            'total_tkt' => $total_tkt,
        ]);
    }

    public function membershow($id)
    {
        $member = member::find($id);
        $hki = member_hki::join('hki', 'hki.id', '=', 'member_hki.hki_id')->where('member_hki.member_id', $id)->where('hki.isVerified', 1)->get();
        $research = member_research::join('research', 'research.id', '=', 'member_research.research_id')->where('member_research.member_id', $id)->where('research.isVerified', 1)->get();
        $paper = member_paper::join('paper', 'paper.id', '=', 'member_paper.paper_id')->where('member_paper.member_id', $id)->where('paper.isVerified', 1)->get();
        // dd(count($research));
        return view('report.report_member_perorang', [
            'data' => $member,
            'hki' => $hki,
            'research' => $research,
            'paper' => $paper,
        ]);
    }
}
