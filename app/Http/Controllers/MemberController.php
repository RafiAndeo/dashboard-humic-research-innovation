<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\MemberExport;
use App\Imports\MemberImport;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function index()
    {
        $data = member::all();
        return view('anggota.index', ['data' => $data]);
    }

    public function memberexport()
    {
        return Excel::download(new MemberExport, 'member.xlsx');
    }

    public function memberimport(Request $request)
    {
        Excel::import(new MemberImport, $request->file('file')->store('temp'));
        return back();
    }

    public function show($id)
    {
        $data = member::find($id);
        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'fakultas' => 'required',
            'pendidikan' => 'required',
            'bidang_ilmu' => 'required',
            'jabatan' => 'required',
            'kelompok_keahlian' => 'required',
            'email' => 'required',
            'photo' => 'required',
            'membership' => 'required',
            'status' => 'required',
            'NIP' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);

        $data = new member();
        $data->nama = $request->nama;
        $data->fakultas = $request->fakultas;
        $data->pendidikan = $request->pendidikan;
        $data->bidang_ilmu = $request->bidang_ilmu;
        $data->jabatan = $request->jabatan;
        $data->kelompok_keahlian = $request->kelompok_keahlian;
        $data->email = $request->email;
        $data->photo = $request->photo;
        $data->membership = $request->membership;
        $data->status = $request->status;
        $data->NIP = $request->NIP;
        $data->role = $request->role;
        $data->password = bcrypt($request->password);

        $data->save();

        return "berhasil membuat member";
    }

    public function login(Request $request)
    {
        $request->validate([
            'NIP' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('NIP', 'password'))) {
            return "OK";
        } else {
            return "ERROR";
        }
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'fakultas' => 'required',
            'pendidikan' => 'required',
            'bidang_ilmu' => 'required',
            'jabatan' => 'required',
            'kelompok_keahlian' => 'required',
            'email' => 'required',
            'photo' => 'required',
            'membership' => 'required',
            'status' => 'required',
            'NIP' => 'required',
            'role' => 'required',
        ]);

        $member = member::find($id);
        $member->nama = $request->nama;
        $member->fakultas = $request->fakultas;
        $member->pendidikan = $request->pendidikan;
        $member->bidang_ilmu = $request->bidang_ilmu;
        $member->jabatan = $request->jabatan;
        $member->kelompok_keahlian = $request->kelompok_keahlian;
        $member->email = $request->email;
        $member->photo = $request->photo;
        $member->membership = $request->membership;
        $member->status = $request->status;
        $member->NIP = $request->NIP;
        $member->role = $request->role;

        $member->save();

        return "berhasil update member";
    }

    public function destroy(string $id)
    {
        $data = member::find($id);
        $data->delete();

        return "berhasil delete member";
    }
}
