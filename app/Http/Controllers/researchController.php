<?php

namespace App\Http\Controllers;

use App\Models\research;
use App\Models\member;
use App\Models\member_research;
use Illuminate\Http\Request;

class researchController extends Controller
{
    public function index()
    {
        $research = research::all();
        return view('research.index', ['research' => $research]);
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

        $research = research::where('id', $id);
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
            'lama_penelitian' => $request->lama_penelitian,
            'keterangan' => $request->keterangan,
        ]);

        $research->save();

        return "OK";
    }

    public function destroy(research $research, $id)
    {
        $research = research::where('id', $id);
        $research->delete();

        return "OK";
    }

    public function delete_member_from_research(member_research $member_research, $research_id, $member_id)
    {
        $member_research = member_research::where([['research_id', $research_id], ['member_id', $member_id]]);
        $member_research->delete();

        return "OK";
    }

    public function add_member_to_research(Request $request)
    {
        $request->validate([
            'research_id' => 'required',
            'member_id' => 'required',
        ]);

        if (!(research::where('id', $request->research_id)->exists()) || !(member::where('id', $request->member_id)->exists())) {
            return "Salah satu id tidak valid";
        } else {
            $research_member = new member_research;
            $research_member->research_id = $request->research_id;
            $research_member->member_id = $request->member_id;

            $research_member->save();
            return "OK";
        }
    }

    public function find_members_of_research($id)
    {
        $research_member = member_research::where('research_id', $id)->get();
        return $research_member;
    }
}
