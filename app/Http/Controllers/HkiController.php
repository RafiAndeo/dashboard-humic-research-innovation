<?php

namespace App\Http\Controllers;

use App\Models\hki;
use Illuminate\Http\Request;

class HKIController extends Controller
{
    public function index()
    {
        $data = hki::all();
        return $data;
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

        $data->save();

        return "berhasil membuat hki";
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

    function destroy($id)
    {
        $data = hki::find($id);
        $data->delete();

        return "berhasil delete hki";
    }
}
