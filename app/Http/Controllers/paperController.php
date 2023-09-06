<?php

namespace App\Http\Controllers;

use App\Models\paper;
use Illuminate\Http\Request;
use App\Models\member_paper;
use App\Models\member;
use App\Exports\PaperExport;
use App\Imports\PaperImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\partner_paper;
use App\Models\partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class paperController extends Controller
{
    public function index(Request $request)
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

        $data = $data->get();
        $data_count = $data_count->count();

        $paper_jenis = $paper_jenis->get();
        $label_jenis = $paper_jenis->pluck('jenis');
        $total_jenis = $paper_jenis->pluck('total');

        $tahun = $tahun->get();
        $label = $tahun->pluck('tahun');
        $total = $tahun->pluck('total');

        $quartile_option = paper::select('quartile')->distinct()->pluck('quartile');
        $tahun_option = paper::select('tahun')->distinct()->pluck('tahun');
        $jenis_option = paper::select('jenis')->distinct()->pluck('jenis');


        return view('publikasi.index', [
            'data' => $data,
            'label_jenis' => $label_jenis,
            'total_jenis' => $total_jenis,
            'count' => $data_count,
            'label' => $label,
            'total' => $total,
            'quartile' => $quartile_option,
            'tahun' => $tahun_option,
            'jenis' => $jenis_option,
            'quartile_selected' => $request->quartile,
            'tahun_selected' => $request->tahun,
            'jenis_selected' => $request->jenis,
        ]);
    }

    public function index_admin()
    {
        if (Auth::user()->role == 'admin') {
            $data = paper::all();
        } else {
            $data = paper::join('member_paper', 'paper.id', '=', 'member_paper.paper_id')
                ->where('member_paper.member_id', Auth::user()->id)
                // ->where('paper.isVerified', true)
                ->get();
        }

        $data_count = paper::count();
        // count group_by tahun_berakhir
        $tahun = paper::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->get();
        // tahun diterima di pisah dengan 1 array
        $label = $tahun->pluck('tahun');
        $total = $tahun->pluck('total');

        $paper_jenis = paper::select('jenis', DB::raw('count(*) as total'))
            ->groupBy('jenis')
            ->get();

        $label_jenis = $paper_jenis->pluck('jenis');
        $total_jenis = $paper_jenis->pluck('total');

        return view('publikasi.input_index', ['data' => $data, 'count' => $data_count, 'label' => $label, 'total' => $total, 'label_jenis' => $label_jenis, 'total_jenis' => $total_jenis]);
    }

    public function create()
    {
        $data = paper::all();
        return view('publikasi.input_add', ['data' => $data]);
    }

    public function paperexport()
    {
        return Excel::download(new PaperExport, 'paper.xlsx');
    }

    public function paperimport()
    {
        Excel::import(new PaperImport, 'paper.xlsx', 'public');

        return "paper berhasil diimport";
    }

    public function show($id)
    {
        $data = paper::find($id);
        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            "jenis" => 'required',
            "judul" => 'required',
            "nama_jurnal" => 'required',
            "issue" => 'required',
            "volume" => 'required',
            "tahun" => 'required',
            "quartile" => 'required',
            "index" => 'required',
            "link" => 'required',
        ]);

        $paper = new paper();
        $paper->jenis = $request->jenis;
        $paper->judul = $request->judul;
        $paper->nama_jurnal = $request->nama_jurnal;
        $paper->issue = $request->issue;
        $paper->volume = $request->volume;
        $paper->tahun = $request->tahun;
        $paper->quartile = $request->quartile;
        $paper->index = $request->index;
        $paper->link = $request->link;
        $paper->isVerified = false;

        $paper->save();

        if (Auth::user()->role != 'admin') {
            $member_paper = new member_paper;
            $member_paper->paper_id = $paper->id;
            $member_paper->role = $request->role;
            $member_paper->member_id = Auth::user()->id;
            $member_paper->save();
        }

        return redirect()->route('paper.index_admin')->with('success', 'Berhasil Menambahkan Data');
    }

    public function verifikasi($id)
    {
        $research = paper::where('id', $id);
        $research->update(['isVerified' => true]);
        return redirect()->route('paper.index_admin')->with('success', 'Berhasil Verifikasi Data');
    }

    public function edit($id)
    {
        $data = paper::find($id);
        return view('publikasi.input_edit', ['data' => $data, 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "jenis" => 'required',
            "judul" => 'required',
            "nama_jurnal" => 'required',
            "issue" => 'required',
            "volume" => 'required',
            "tahun" => 'required',
            "quartile" => 'required',
            "index" => 'required',
            "link" => 'required',
        ]);



        $paper = paper::where('id', $id);
        $paper->update([
            "jenis" => $request->jenis,
            "judul" => $request->judul,
            "nama_jurnal" => $request->nama_jurnal,
            "issue" => $request->issue,
            "volume" => $request->volume,
            "tahun" => $request->tahun,
            "quartile" => $request->quartile,
            "index" => $request->index,
            "link" => $request->link,
        ]);

        return redirect()->route('paper.index_admin')->with('success', 'Berhasil Update Data');
    }

    public function destroy(paper $paper, $id)
    {
        $paper = paper::where('id', $id);
        $paper->delete();

        return redirect()->route('paper.index_admin')->with('success', 'Berhasil Menghapus Data');
    }

    public function delete_member_from_paper(member_paper $member_paper, $paper_id, $member_id)
    {
        $member_paper = member_paper::where([['paper_id', $paper_id], ['member_id', $member_id]]);
        $member_paper->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Member');
    }

    public function delete_partner_from_paper(partner_paper $partner_paper, $paper_id, $partner_id)
    {
        $partner_paper = partner_paper::where([['paper_id', $paper_id], ['partner_id', $partner_id]]);
        $partner_paper->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Partner');
    }


    public function add_member_to_paper_view($id)
    {
        $data = paper::find($id);
        $member = member::all();
        $paper_member = member_paper::join('member', 'member.id', '=', 'member_paper.member_id')->where('member_paper.paper_id', $id)->select('member.*', 'member_paper.*', 'member_paper.role as role_member')->get();
        return view('publikasi.input_member', ['data' => $data, 'member' => $member, 'paper_member' => $paper_member, 'id' => $id]);
    }

    public function add_member_to_paper(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'paper_id' => 'required',
            'role' => 'required'
        ]);

        if (!(paper::where('id', $request->paper_id)->exists()) || !(member::where('id', $request->member_id)->exists())) {
            return "paper atau member tidak ditemukan";
        } else {
            if (member_paper::where('paper_id', $request->paper_id)->where('member_id', $request->member_id)->exists()) {
                return "member sudah ada!";
            } else if (partner_paper::where('paper_id', $request->paper_id)->where('partner_id', $request->member_id)->exists()) {
                return "member sudah ada!";
            } else {
                $paper_member = new member_paper;
                $paper_member->paper_id = $request->paper_id;
                $paper_member->member_id = $request->member_id;
                $paper_member->role = $request->role;

                $paper_member->save();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Member');
            }
        }
    }

    public function add_partner_to_paper_view($id)
    {
        $data = paper::find($id);
        $partner = partner::all();
        $paper_partner = partner_paper::join('partner', 'partner.id', '=', 'partner_paper.partner_id')
            ->where('partner_paper.paper_id', $id)
            ->select('partner.*', 'partner_paper.*', 'partner_paper.role as role_partner')
            ->get();
        return view('publikasi.input_partner', ['data' => $data, 'partner' => $partner, 'paper_partner' => $paper_partner, 'id' => $id]);
    }

    public function add_partner_to_paper(Request $request)
    {
        $request->validate([
            'partner_id' => 'required',
            'paper_id' => 'required',
        ]);

        if (!(paper::where('id', $request->paper_id)->exists()) || !(partner::where('id', $request->partner_id)->exists())) {
            return "paper atau partner tidak ditemukan";
        } else {
            if (member_paper::where('paper_id', $request->paper_id)->where('member_id', $request->partner_id)->exists()) {
                return "partner sudah ada!";
            } else if (partner_paper::where('paper_id', $request->paper_id)->where('partner_id', $request->partner_id)->exists()) {
                return "partner sudah ada!";
            } else {
                $paper_partner = new partner_paper;
                $paper_partner->paper_id = $request->paper_id;
                $paper_partner->partner_id = $request->partner_id;
                $paper_partner->role = $request->role;

                $paper_partner->save();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Partner');
            }
        }
    }

    public function find_members_of_paper($id)
    {
        $data = member_paper::where('paper_id', $id)->get();
        return $data;
    }

    public function find_partners_of_paper($id)
    {
        $data = partner_paper::where('paper_id', $id)->get();
        return $data;
    }
}