<?php

namespace App\Http\Controllers;

use App\Models\partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    public function index()
    {
        $partner = partner::all();
        $count = partner::count();
        // pluck negara
        $negara_raw = partner::select('negara', DB::raw('count(*) as total'))
            ->groupBy('negara')
            ->get();
        $negara = $negara_raw->pluck('negara');
        $total = $negara_raw->pluck('total');
        return view('partner.input_index', ['data' => $partner, 'count' => $count, 'negara' => $negara, 'total' => $total]);
    }

    public function create()
    {
        return view('partner.input_add');
    }

    public function show($id)
    {
        $partner = partner::find($id);
        return $partner;
    }

    public function edit($id)
    {
        $partner = partner::find($id);
        return view('partner.input_edit', ['data' => $partner, 'id' => $id]);
    }

    public function store(Request $request)
    {

        $request->validate([
            "nama_partner" => 'required',
            "sumber" => 'required',
            "institusi" => 'required',
            "jabatan" => 'required',
            "negara" => 'required',
            "type" => 'required',
        ]);

        $partner = new partner();
        $partner->nama_partner = $request->nama_partner;
        $partner->sumber = $request->sumber;
        $partner->institusi = $request->institusi;
        $partner->jabatan = $request->jabatan;
        $partner->negara = $request->negara;
        $partner->type = $request->type;

        $partner->save();

        return redirect()->route('partner.index')->with('success', 'Berhasil Menambahkan Data');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "nama_partner" => 'required',
            "sumber" => 'required',
            "institusi" => 'required',
            "jabatan" => 'required',
            "negara" => 'required',
            "type" => 'required',
        ]);

        $partner = partner::where('id', $id);
        $partner->update([
            'nama_partner' => $request->nama_partner,
            'sumber' => $request->sumber,
            'institusi' => $request->institusi,
            'jabatan' => $request->jabatan,
            'negara' => $request->negara,
            'type' => $request->type,
        ]);

        return redirect()->route('partner.index')->with('success', 'Berhasil Update Data');
    }

    public function destroy(partner $partner, $id)
    {
        $partner = partner::where('id', $id);
        $partner->delete();

        return redirect()->route('partner.index')->with('success', 'Berhasil Menghapus Data');
    }
}
