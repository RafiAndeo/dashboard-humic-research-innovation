<?php

namespace App\Http\Controllers;

use App\Models\research;
use Illuminate\Http\Request;

class researchController extends Controller
{
    public function index()
    {
        $research = research::all();
        return $research;
    }

    public function show($id)
    {
        $research = research::find($id);
        return $research;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_diterima' => 'required',
            'tahun_berakhir' => 'required',
            'judul' => 'required',
            'tkt' => 'required',
            'grant' => 'required',
            'skema' => 'required',
            'tipe_pendanaan' => 'required',
            'pendanaan_external' => 'required',
            'tipe_external' => 'required',
            'lama_penelitian' => 'required',
            'keterangan' => 'required',
        ]);

        $research = new research();
        $research->tahun_diterima = $request->tahun_diterima;
        $research->tahun_berakhir = $request->tahun_berakhir;
        $research->judul = $request->judul;
        $research->tkt = $request->tkt;
        $research->grant = $request->grant;
        $research->skema = $request->skema;
        $research->tipe_pendanaan = $request->tipe_pendanaan;
        $research->pendanaan_external = $request->tipe_pendanaan;
        $research->tipe_external = $request->tipe_external;
        $research->lama_penelitian = $request->lama_penelitian;
        $research->keterangan = $request->keterangan;

        $research->save();

        return "OK";
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_diterima' => 'required',
            'tahun_berakhir' => 'required',
            'judul' => 'required',
            'tkt' => 'required',
            'grant' => 'required',
            'skema' => 'required',
            'tipe_pendanaan' => 'required',
            'pendanaan_external' => 'required',
            'tipe_external' => 'required',
            'lama_penelitian' => 'required',
            'keterangan' => 'required',
        ]);

        $research = research::where('research_id', $id);
        $research->update([
            'tahun_diterima' => $request->tahun_diterima,
            'tahun_berakhir' => $request->tahun_berakhir,
            'judul' => $request->judul,
            'tkt' => $request->tkt,
            'grant' => $request->grant,
            'skema' => $request->skema,
            'tipe_pendanaan' => $request->tipe_pendanaan,
            'pendanaan_external' => $request->pendanaan_external,
            'tipe_external' => $request->tipe_external,
            'member' => $request->member,
            'lama_penelitian' => $request->lama_penelitian,
            'keterangan' => $request->keterangan,
        ]);

        $research->save();

        return "OK";
    }

    public function destroy(research $research, $id)
    {
        $research = research::where('research_id', $id);
        $research->delete();

        return "OK";
    }
}
