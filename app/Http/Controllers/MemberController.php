<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\MemberExport;
use App\Imports\MemberImport;
use App\Models\hki;
use App\Models\paper;
use App\Models\research;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManagerStatic as Image;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $data = member::query();
        $member_fakultas = member::select('fakultas', DB::raw('count(*) as total'))
            ->groupBy('fakultas');
        $member_pendidikan = member::select('pendidikan', DB::raw('count(*) as total'))
            ->groupBy('pendidikan');
        $member_kelompok_keahlian = member::select('kelompok_keahlian', DB::raw('count(*) as total'))
            ->groupBy('kelompok_keahlian');
        $member_jabatan = member::select('jabatan', DB::raw('count(*) as total'))
            ->groupBy('jabatan');

        $fakultas_option = member::select('fakultas')->distinct()->pluck('fakultas');
        $pendidikan_option = member::select('pendidikan')->distinct()->pluck('pendidikan');
        $kelompok_keahlian_option = member::select('kelompok_keahlian')->distinct()->pluck('kelompok_keahlian');
        $jabatan_option = member::select('jabatan')->distinct()->pluck('jabatan');

        if ($request->has('fakultas') && $request->fakultas != 'all') {
            $data = $data->where('fakultas', $request->fakultas);
            $member_fakultas = $member_fakultas->where('fakultas', $request->fakultas);
            $member_pendidikan = $member_pendidikan->where('fakultas', $request->fakultas);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('fakultas', $request->fakultas);
        }

        if ($request->has('pendidikan') && $request->pendidikan != 'all') {
            $data = $data->where('pendidikan', $request->pendidikan);
            $member_fakultas = $member_fakultas->where('pendidikan', $request->pendidikan);
            $member_pendidikan = $member_pendidikan->where('pendidikan', $request->pendidikan);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('pendidikan', $request->pendidikan);
        }

        if ($request->has('kelompok_keahlian') && $request->kelompok_keahlian != 'all') {
            $data = $data->where('kelompok_keahlian', $request->kelompok_keahlian);
            $member_fakultas = $member_fakultas->where('kelompok_keahlian', $request->kelompok_keahlian);
            $member_pendidikan = $member_pendidikan->where('kelompok_keahlian', $request->kelompok_keahlian);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('kelompok_keahlian', $request->kelompok_keahlian);
        }

        if ($request->has('jabatan') && $request->jabatan != 'all') {
            $data = $data->where('jabatan', $request->jabatan);
            $member_fakultas = $member_fakultas->where('jabatan', $request->jabatan);
            $member_kelompok_keahlian = $member_kelompok_keahlian->where('jabatan', $request->jabatan);
            $member_pendidikan = $member_pendidikan->where('jabatan', $request->jabatan);
            $member_jabatan = $member_jabatan->where('jabatan', $request->jabatan);
        }

        $count = $data->count();
        $data = $data->get();

        $member_fakultas = $member_fakultas->get();
        $label_fakultas = $member_fakultas->pluck('fakultas');
        $total_fakultas = $member_fakultas->pluck('total');

        $member_pendidikan = $member_pendidikan->get();
        $label_pendidikan = $member_pendidikan->pluck('pendidikan');
        $total_pendidikan = $member_pendidikan->pluck('total');

        $member_kelompok_keahlian = $member_kelompok_keahlian->get();
        $label_kelompok_keahlian = $member_kelompok_keahlian->pluck('kelompok_keahlian');
        $total_kelompok_keahlian = $member_kelompok_keahlian->pluck('total');

        $member_jabatan = $member_jabatan->get();
        $label_jabatan = $member_jabatan->pluck('jabatan');
        $total_jabatan = $member_jabatan->pluck('total');




        return view('anggota.index', [
            'data' => $data,
            'count' => $count,
            'label_fakultas' => $label_fakultas,
            'total_fakultas' => $total_fakultas,
            'fakultas_option' => $fakultas_option,
            'pendidikan_option' => $pendidikan_option,
            'kelompok_keahlian_option' => $kelompok_keahlian_option,
            'jabatan_option' => $jabatan_option,
            'fakultas_selected' => $request->fakultas,
            'pendidikan_selected' => $request->pendidikan,
            'kelompok_keahlian_selected' => $request->kelompok_keahlian,
            'jabatan_selected' => $request->jabatan,
            'label_pendidikan' => $label_pendidikan,
            'total_pendidikan' => $total_pendidikan,
        ]);
    }

    public function index_admin()
    {
        $data = member::all();
        $count = member::count();
        $raw = member::select('fakultas', DB::raw('count(*) as total'))
            ->groupBy('fakultas')
            ->get();
        $label = $raw->pluck('fakultas');
        $total = $raw->pluck('total');

        $member_fakultas = member::select('fakultas', DB::raw('count(*) as total'))
            ->groupBy('fakultas')->get();
        $label_fakultas = $member_fakultas->pluck('fakultas');
        $total_fakultas = $member_fakultas->pluck('total');

        $member_pendidikan = member::select('pendidikan', DB::raw('count(*) as total'))
            ->groupBy('pendidikan')->get();
        $label_pendidikan = $member_pendidikan->pluck('pendidikan');
        $total_pendidikan = $member_pendidikan->pluck('total');
        return view('anggota.input_index', ['data' => $data, 'count' => $count, 'label' => $label, 'total' => $total, 'label_fakultas' => $label_fakultas, 'total_fakultas' => $total_fakultas, 'label_pendidikan' => $label_pendidikan, 'total_pendidikan' => $total_pendidikan]);
    }

    public function create()
    {
        return view('anggota.input_add');
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

    public function edit($id)
    {
        $data = member::find($id);
        return view('anggota.input_edit', ['data' => $data, 'id' => $id]);
    }

    public function show($id)
    {
        $data = member::find($id);
        $paper = paper::join('member_paper', 'member_paper.paper_id', '=', 'paper.id')
            ->where('member_paper.member_id', $id)
            ->get();

        $research = research::join('member_research', 'member_research.research_id', '=', 'research.id')
            ->where('member_research.member_id', $id)
            ->get();

        $hki = hki::join('member_hki', 'member_hki.hki_id', '=', 'hki.id')
            ->where('member_hki.member_id', $id)
            ->get();

        return view('anggota.show', [
            'data' => $data,
            'id' => $id,
            'paper' => $paper,
            'research' => $research,
            'hki' => $hki
        ]);
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
            'membership' => 'required',
            'status' => 'required',
            'NIP' => 'required',
            'role' => 'required',
            'password' => 'required',
            'photo' => 'image|max:2048'
        ]);
        $data = new member();
        $data->nama = $request->nama;
        $data->fakultas = $request->fakultas;
        $data->pendidikan = $request->pendidikan;
        $data->bidang_ilmu = $request->bidang_ilmu;
        $data->jabatan = $request->jabatan;
        $data->kelompok_keahlian = $request->kelompok_keahlian;
        $data->email = $request->email;
        $data->membership = $request->membership;
        $data->status = $request->status;
        $data->NIP = $request->NIP;
        $data->role = $request->role;
        $data->password = bcrypt($request->password);
        $iamge_file = $request->photo;
        $image = Image::make($iamge_file);
        $data->photo = $image;

        $data->save();

        return redirect()->route('member.index_admin')->with('success', 'Berhasil Menambahkan Data');
    }

    function insert_image(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        $image_file = $request->photo;

        $image = Image::make($image_file);

        Response::make($image->encode('jpeg'));

        $member = member::find($id);
        $member->update([
            "photo" => $image,
        ]);

        return $image;
    }

    function fetch_image($id)
    {
        $member = member::find($id);

        $image_file = Image::make($member->photo);

        $response = Response::make($image_file->encode('jpeg'));

        $response->header('Content-Type', 'image/jpeg');

        return $response;
    }

    public function login_index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'NIP' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('NIP', 'password'))) {
            // return "OK";
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        } else {
            // return "ERROR";
            return back()->withErrors(['error' => 'NIP atau Password anda salah']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login_index')->with('success', 'Berhasil Logout');
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
        $member->membership = $request->membership;
        $member->status = $request->status;
        $member->NIP = $request->NIP;
        $member->role = $request->role;

        $member->save();

        return redirect()->route('member.index_admin')->with('success', 'Berhasil Update Data');
    }

    public function destroy(string $id)
    {
        $data = member::find($id);
        $data->delete();

        return redirect()->route('member.index_admin')->with('success', 'Berhasil Menghapus Data');
    }
}
