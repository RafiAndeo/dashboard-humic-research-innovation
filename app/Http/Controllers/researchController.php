<?php

namespace App\Http\Controllers;

use App\Models\research;
use App\Models\member;
use App\Models\member_research;
use Illuminate\Http\Request;
use App\Exports\ResearchExport;
use App\Imports\ResearchImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\partner;
use App\Models\partner_research;

class researchController extends Controller
{
    public function index()
    {
        $research = research::all();
        $research_count = research::count();
        return view('research.index', ['data' => $research, 'count' => $research_count]);
    }

    public function index_admin()
    {
        $research = research::all();
        $research_count = research::count();
        // count group_by tahun_berakhir
        $tahun_diterima = research::select('tahun_diterima', DB::raw('count(*) as total'))
            ->groupBy('tahun_diterima')
            ->get();
        // tahun diterima di pisah dengan 1 array
        $tahun_diterima_0 = $tahun_diterima->pluck('tahun_diterima');
        $tahun_diterima_1 = $tahun_diterima->pluck('total');
        return view('research.input_index', ['data' => $research, 'count' => $research_count, 'tahun_diterima_0' => $tahun_diterima_0, 'tahun_diterima_1' => $tahun_diterima_1]);
    }

    public function create()
    {
        $research = research::all();
        return view('research.input_add', ['data' => $research]);
    }

    public function researchexport()
    {
        return Excel::download(new ResearchExport, 'research.xlsx');
    }

    public function researchimport()
    {
        Excel::import(new ResearchImport, 'research.xlsx', 'public');

        return "research berhasil diimport";
    }

    public function show($id)
    {
        $data = research::find($id);
        return view('research.input_edit', ['data' => $data]);
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

        return redirect()->route('research.index_admin')->with('success', 'Berhasil Menambahkan Data');
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

        return redirect()->route('research.index_admin')->with('success', 'Berhasil Update Data');
    }

    public function destroy(research $research, $id)
    {
        $research = research::where('id', $id);
        $research->delete();

        return redirect()->route('research.index_admin')->with('success', 'Berhasil Delete Data');
    }

    public function delete_member_from_research(member_research $member_research, $research_id, $member_id)
    {
        $member_research = member_research::where([['research_id', $research_id], ['member_id', $member_id]]);
        $member_research->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Member');
    }

    public function delete_partner_from_research(partner_research $partner_research, $research_id, $partner_id)
    {
        $partner_research = partner_research::where([['research_id', $research_id], ['partner_id', $partner_id]]);
        $partner_research->delete();

        return "Berhasil Menghapus Partner";
    }

    public function add_member_to_research_view($id)
    {
        $research = research::find($id);
        $member = member::all();
        $research_member = member_research::join('member', 'member.id', '=', 'member_research.member_id')->where('member_research.research_id', $id)->get();
        return view('research.input_member', ['data' => $research, 'member' => $member, 'research_member' => $research_member, 'id' => $id]);
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
            return redirect()->back()->with('success', 'Berhasil Menambahkan Member');
        }
    }

    public function add_partner_to_research(Request $request)
    {
        $request->validate([
            'research_id' => 'required',
            'partner_id' => 'required',
        ]);

        if (!(research::where('id', $request->research_id)->exists()) || !(partner::where('id', $request->partner_id)->exists())) {
            return "Salah satu id tidak valid";
        } else {
            $research_partner = new partner_research;
            $research_partner->research_id = $request->research_id;
            $research_partner->partner_id = $request->partner_id;

            $research_partner->save();
            return "Berhasil Menambahkan Partner";
        }
    }

    public function find_members_of_research($id)
    {
        $research_member = member_research::where('research_id', $id)->get();
        return $research_member;
    }

    public function find_partners_of_research($id)
    {
        $research_partner = partner_research::where('research_id', $id)->get();
        return $research_partner;
    }
}
