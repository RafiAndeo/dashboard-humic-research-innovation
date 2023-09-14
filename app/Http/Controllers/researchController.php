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
use Illuminate\Support\Facades\Auth;

class researchController extends Controller
{
    public function index(Request $request)
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


        return view('research.index', [
            'data' => $research,
            'count' => $research_count,
            'tahun_diterima_option' => $tahun_diterima_option,
            'tahun_berakhir_option' => $tahun_berakhir_option,
            'tipe_pendanaan_option' => $tipe_pendanaan_option,
            'tkt_option' => $tkt_option,
            'skema_option' => $skema_option,
            'tahun_diterima_selected' => $request->tahun_diterima,
            'tahun_berakhir_selected' => $request->tahun_berakhir,
            'tipe_pendanaan_selected' => $request->tipe_pendanaan,
            'tkt_selected' => $request->tkt,
            'skema_selected' => $request->skema,
            'label_tahun_diterima' => $label_tahun_diterima,
            'total_tahun_diterima' => $total_tahun_diterima,
            'label_tipe_pendanaan' => $label_tipe_pendanaan,
            'total_tipe_pendanaan' => $total_tipe_pendanaan,
        ]);
    }

    public function index_admin()
    {
        if (Auth::user()->role == 'admin') {
            $research = research::all();
        } else {
            $research = research::join('member_research', 'research.id', '=', 'member_research.research_id')
                ->where('member_research.member_id', Auth::user()->id)
                // ->where('paper.isVerified', true)
                ->get();
        }
        $research_count = research::count();
        // count group_by tahun_berakhir
        $tahun_diterima = research::select('tahun_diterima', DB::raw('count(*) as total'))
            ->groupBy('tahun_diterima')
            ->get();
        // tahun diterima di pisah dengan 1 array
        $tahun_diterima_0 = $tahun_diterima->pluck('tahun_diterima');
        $tahun_diterima_1 = $tahun_diterima->pluck('total');

        $riset_tipe_pendanaan = research::select('tipe_pendanaan', DB::raw('count(*) as total'))->groupBy('tipe_pendanaan');

        $riset_tipe_pendanaan = $riset_tipe_pendanaan->get();
        $label_tipe_pendanaan = $riset_tipe_pendanaan->pluck('tipe_pendanaan');
        $total_tipe_pendanaan = $riset_tipe_pendanaan->pluck('total');

        return view('research.input_index', [
            'data' => $research,
            'count' => $research_count,
            'tahun_diterima_0' => $tahun_diterima_0,
            'tahun_diterima_1' => $tahun_diterima_1,
            'label_tipe_pendanaan' => $label_tipe_pendanaan,
            'total_tipe_pendanaan' => $total_tipe_pendanaan,
        ]);
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
        $research->isVerified = false;
        $research->save();

        if (Auth::user()->role != 'admin') {
            $research_member = new member_research;
            $research_member->research_id = $research->id;
            $research_member->role = $request->role;
            $research_member->member_id = Auth::user()->id;
            $research_member->save();
        }

        return redirect()->route('research.index_admin')->with('success', 'Berhasil Menambahkan Data');
    }

    public function verifikasi($id)
    {
        $research = research::where('id', $id);
        $research->update(['isVerified' => true]);
        return redirect()->route('research.index_admin')->with('success', 'Berhasil Verifikasi Data');
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
        $research_member = member_research::join('member', 'member.id', '=', 'member_research.member_id')
            ->where('member_research.research_id', $id)
            ->select('member.*', 'member_research.*', 'member_research.role as role_member')
            ->get();
        return view('research.input_member', ['data' => $research, 'member' => $member, 'research_member' => $research_member, 'id' => $id]);
    }

    public function add_member_to_research(Request $request)
    {
        $request->validate([
            'research_id' => 'required',
            'member_id' => 'required',
            'role' => 'required',
        ]);

        if (!(research::where('id', $request->research_id)->exists()) || !(member::where('id', $request->member_id)->exists())) {
            return "research atau member tidak ditemukan";
        } else {
            if (member_research::where('research_id', $request->research_id)->where('member_id', $request->member_id)->exists()) {
                return "member sudah ada!";
            } else if (member_research::where('research_id', $request->research_id)->where('role', $request->role)->exists()) {
                return "role member sudah ada!";
            } else {
                $research_member = new member_research;
                $research_member->research_id = $request->research_id;
                $research_member->member_id = $request->member_id;
                $research_member->role = $request->role;

                $research_member->save();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Member');
            }
        }
    }

    public function add_partner_to_research_view($id)
    {
        $research = research::find($id);
        $partner = partner::all();
        $research_partner = partner_research::join('partner', 'partner.id', '=', 'partner_research.partner_id')
            ->where('partner_research.research_id', $id)
            ->select('partner.*', 'partner_research.*', 'partner_research.role as role_partner')
            ->get();
        return view('research.input_partner', ['data' => $research, 'partner' => $partner, 'research_partner' => $research_partner, 'id' => $id]);
    }

    public function add_partner_to_research(Request $request)
    {
        $request->validate([
            'research_id' => 'required',
            'partner_id' => 'required',
            'role' => 'required',
        ]);

        if (!(research::where('id', $request->research_id)->exists()) || !(partner::where('id', $request->partner_id)->exists())) {
            return "research atau partner tidak ditemukan";
        } else {
            if (partner_research::where('research_id', $request->research_id)->where('partner_id', $request->partner_id)->exists()) {
                return "partner sudah ada!";
            } else if (partner_research::where('research_id', $request->research_id)->where('role', $request->role)->exists()) {
                return "role partner sudah ada!";
            } else {
                $research_partner = new partner_research;
                $research_partner->research_id = $request->research_id;
                $research_partner->partner_id = $request->partner_id;
                $research_partner->role = $request->role;

                $research_partner->save();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Partner');
            }
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
