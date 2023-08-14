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

class HKIController extends Controller
{
    public function index()
    {
        $data = hki::all();
        return view('hki.index', ['data' => $data]);
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

        return "berhasil membuat hki";
    }

    public function verifikasi($id)
    {
        $research = hki::where('id', $id);
        $research->update(['isVerified' => true]);
        return "OK";
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

        return "berhasil update hki";
    }

    public function destroy($id)
    {
        $data = hki::find($id);
        $data->delete();

        return "berhasil delete hki";
    }

    public function delete_member_from_hki(member_hki $member_hki, $member_id, $hki_id)
    {
        $member_hki = member_hki::where([['hki_id', $hki_id], ['member_id', $member_id]]);
        $member_hki->delete();

        return "berhasil delete member dari hki";
    }

    public function delete_partner_from_hki(partner_hki $partner_hki, $partner_id, $hki_id)
    {
        $partner_hki = partner_hki::where([['hki_id', $hki_id], ['partner_id', $partner_id]]);
        $partner_hki->delete();

        return "berhasil delete partner dari hki";
    }

    public function add_member_to_hki(Request $request)
    {
        $request->validate([
            'hki_id' => 'required',
            'member_id' => 'required',
        ]);

        if (!(hki::where('id', $request->hki_id)->exists()) || !(member::where('id', $request->member_id)->exists())) {
            return "hki atau member tidak ditemukan";
        } else {
            $hki_member = new member_hki;
            $hki_member->hki_id = $request->hki_id;
            $hki_member->member_id = $request->member_id;

            $hki_member->save();
            return "berhasil menambahkan member ke hki";
        }
    }

    public function add_partner_to_hki(Request $request)
    {
        $request->validate([
            'hki_id' => 'required',
            'partner_id' => 'required',
        ]);

        if (!(hki::where('id', $request->hki_id)->exists()) || !(partner::where('id', $request->partner_id)->exists())) {
            return "hki atau partner tidak ditemukan";
        } else {
            $hki_partner = new partner_hki;
            $hki_partner->hki_id = $request->hki_id;
            $hki_partner->partner_id = $request->partner_id;

            $hki_partner->save();
            return "berhasil menambahkan partner ke hki";
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