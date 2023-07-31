<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = member::all();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $data->save();

        return "berhasil membuat member";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
        ]);
        $data = member::find($id);
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
        $data->save();

        return "berhasil update member";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = member::find($id);
        $data->delete();

        return "berhasil menghapus member";
    }
}
