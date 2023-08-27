<?php

namespace App\Http\Controllers;

use App\Models\hki;
use App\Exports\HkiExport;
use App\Imports\HkiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\member_hki;
use App\Models\member;
use App\Models\partner;
use App\Models\partner_hki;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HKIController extends Controller
{
    public function index(Request $request)
    {
        $data = hki::query();

        $tahun_option = hki::select('tahun')->distinct()->pluck('tahun');
        $jenis_option = hki::select('jenis')->distinct()->pluck('jenis');

        $hki_tahun = hki::select('tahun', DB::raw('count(*) as total'))->groupBy('tahun');
        $hki_jenis = hki::select('jenis', DB::raw('count(*) as total'))->groupBy('jenis');

        if ($request->has('tahun') && $request->tahun != 'all') {
            $data = $data->where('tahun', $request->tahun);
            $hki_tahun = $hki_tahun->where('tahun', $request->tahun);
            $hki_jenis = $hki_jenis->where('tahun', $request->tahun);
        }

        if ($request->has('jenis') && $request->jenis != 'all') {
            $data = $data->where('jenis', $request->jenis);
            $hki_tahun = $hki_tahun->where('jenis', $request->jenis);
            $hki_jenis = $hki_jenis->where('jenis', $request->jenis);
        }

        $data = $data->get();
        $count = $data->count();

        $hki_tahun = $hki_tahun->get();
        $label_tahun = $hki_tahun->pluck('tahun');
        $total_tahun = $hki_tahun->pluck('total');

        $hki_jenis = $hki_jenis->get();
        $label_jenis = $hki_jenis->pluck('jenis');
        $total_jenis = $hki_jenis->pluck('total');



        return view('hki.index', [
            'data' => $data,
            'count' => $count,

            'tahun_option' => $tahun_option,
            'jenis_option' => $jenis_option,
            'tahun_selected' => $request->tahun,
            'jenis_selected' => $request->jenis,

            'label_tahun' => $label_tahun,
            'total_tahun' => $total_tahun,

            'label_jenis' => $label_jenis,
            'total_jenis' => $total_jenis,
        ]);
    }

    public function index_admin()
    {
        if (Auth::user()->role == 'admin') {
            $data = hki::all();
        } else {
            $data = hki::join('member_hki', 'hki.id', '=', 'member_hki.hki_id')
                ->where('member_hki.member_id', Auth::user()->id)
                // ->where('paper.isVerified', true)
                ->get();
        }
        $count = hki::count();
        $raw = hki::select('jenis', DB::raw('count(*) as total'))
            ->groupBy('jenis')
            ->get();
        $label = $raw->pluck('jenis');
        $total = $raw->pluck('total');

        $tahun = hki::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->get();
        $label_tahun = $tahun->pluck('tahun');
        $total_tahun = $tahun->pluck('total');


        return view('hki.input_index', ['data' => $data, 'count' => $count, 'label' => $label, 'total' => $total, 'label_tahun' => $label_tahun, 'total_tahun' => $total_tahun]);
    }

    public function create()
    {
        return view('hki.input_add');
    }

    public function hkiexport()
    {
        return Excel::download(new HkiExport, 'hki.xlsx');
    }

    public function hkiimport()
    {
        Excel::import(new HkiImport, 'hki.xlsx', 'public');

        return "hki berhasil diimport";
    }

    public function show($id)
    {
        $data = hki::find($id);
        return $data;
    }

    public function edit($id)
    {
        $data = hki::find($id);
        return view('hki.input_edit', ['data' => $data, 'id' => $id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'judul' => 'required',
            'jenis' => 'required',
            'status' => 'required',
        ]);

        $data = new hki();
        $data->jenis = $request->jenis;
        $data->judul = $request->judul;
        $data->tahun = $request->tahun;
        $data->status = $request->status;
        $data->isVerified = false;

        $data->save();

        if (Auth::user() && Auth::user()->role == 'user') {
            $hki_member = new member_hki;
            $hki_member->hki_id = $data->id;
            $hki_member->member_id = Auth::user()->id;
            $hki_member->save();
        }

        return redirect()->route('hki.index_admin')->with('success', 'Berhasil Tambah Data');
    }

    public function verifikasi($id)
    {
        $research = hki::where('id', $id);
        $research->update(['isVerified' => true]);
        return redirect()->route('hki.index_admin')->with('success', 'Berhasil Verifikasi Data');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required',
            'judul' => 'required',
            'jenis' => 'required',
            'status' => 'required',
        ]);

        $hki = hki::find($id);
        $hki->tahun = $request->tahun;
        $hki->judul = $request->judul;
        $hki->jenis = $request->jenis;
        $hki->status = $request->status;

        $hki->save();

        return redirect()->route('hki.index_admin')->with('success', 'Berhasil Update Data');
    }

    public function destroy($id)
    {
        $data = hki::find($id);
        $data->delete();

        return redirect()->route('hki.index_admin')->with('success', 'Berhasil Hapus Data');
    }

    public function delete_member_from_hki(member_hki $member_hki, $hki_id, $member_id)
    {
        $member_hki = member_hki::where([['hki_id', $hki_id], ['member_id', $member_id]]);
        $member_hki->delete();

        return redirect()->back()->with('success', 'Berhasil Hapus Member');
    }

    public function delete_partner_from_hki(partner_hki $partner_hki, $hki_id, $partner_id)
    {
        $partner_hki = partner_hki::where([['hki_id', $hki_id], ['partner_id', $partner_id]]);
        $partner_hki->delete();

        return redirect()->back()->with('success', 'Berhasil Hapus Partner');
    }

    public function add_member_to_hki_view($id)
    {
        $data = hki::find($id);
        $member = member::all();
        $hki_member = member_hki::join('member', 'member.id', '=', 'member_hki.member_id')
            ->where('hki_id', $id)
            ->get();
        return view('hki.input_member', ['data' => $data, 'member' => $member, 'hki_member' => $hki_member, 'id' => $id]);
    }

    public function add_member_to_hki(Request $request)
    {
        $request->validate([
            'hki_id' => 'required',
            'member_id' => 'required',
            'role' => 'required',
        ]);

        if (!(hki::where('id', $request->hki_id)->exists()) || !(member::where('id', $request->member_id)->exists())) {
            return "hki atau member tidak ditemukan";
        } else {
            $hki_member = new member_hki;
            $hki_member->hki_id = $request->hki_id;
            $hki_member->member_id = $request->member_id;
            $hki_member->role = $request->role;

            $hki_member->save();
            return redirect()->back()->with('success', 'Berhasil Tambah Member');
        }
    }

    public function add_partner_to_hki_view($id)
    {
        $data = hki::find($id);
        $partner = partner::all();
        $hki_partner = partner_hki::join('partner', 'partner.id', '=', 'partner_hki.partner_id')
            ->where('hki_id', $id)
            ->get();
        return view('hki.input_partner', ['data' => $data, 'partner' => $partner, 'hki_partner' => $hki_partner, 'id' => $id]);
    }

    public function add_partner_to_hki(Request $request)
    {
        $request->validate([
            'hki_id' => 'required',
            'partner_id' => 'required',
            'role' => 'required',
        ]);

        if (!(hki::where('id', $request->hki_id)->exists()) || !(partner::where('id', $request->partner_id)->exists())) {
            return "hki atau partner tidak ditemukan";
        } else {
            $hki_partner = new partner_hki;
            $hki_partner->hki_id = $request->hki_id;
            $hki_partner->partner_id = $request->partner_id;
            $hki_partner->role = $request->role;

            $hki_partner->save();
            return redirect()->back()->with('success', 'Berhasil Tambah Partner');
        }
    }

    public function find_members_of_hki($id)
    {
        $data = member_hki::where('hki_id', $id)->get();
        return $data;
    }

    public function find_partners_of_hki($id)
    {
        $data = partner_hki::where('hki_id', $id)->get();
        return $data;
    }
}
