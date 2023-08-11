<?php

namespace App\Http\Controllers;

use App\Models\partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partner = partner::all();
        return $partner;
    }

    public function show($id)
    {
        $partner = partner::find($id);
        return $partner;
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

        return "OK";
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

        return "OK";
    }

    public function destroy(partner $partner, $id)
    {
        $partner = partner::where('id', $id);
        $partner->delete();

        return "OK";
    }
}