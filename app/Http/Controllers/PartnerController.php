<?php

namespace App\Http\Controllers;

use App\Models\partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PartnerExport;
use App\Imports\PartnerImport;
use Maatwebsite\Excel\Facades\Excel;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $data = partner::query();

        $institusi_option = partner::select('institusi')->distinct()->pluck('institusi');
        $jabatan_option = partner::select('jabatan')->distinct()->pluck('jabatan');
        $negara_option = partner::select('negara')->distinct()->pluck('negara');
        $type_option = partner::select('type')->distinct()->pluck('type');

        $partner_institusi = partner::select('institusi', DB::raw('count(*) as total'))->groupBy('institusi');
        $partner_jabatan = partner::select('jabatan', DB::raw('count(*) as total'))->groupBy('jabatan');
        $partner_negara = partner::select('negara', DB::raw('count(*) as total'))->groupBy('negara');
        $partner_type = partner::select('type', DB::raw('count(*) as total'))->groupBy('type');

        if ($request->has('institusi') && $request->institusi != 'all') {
            $data = $data->where('institusi', $request->institusi);
            $partner_institusi = $partner_institusi->where('institusi', $request->institusi);
            $partner_jabatan = $partner_jabatan->where('institusi', $request->institusi);
            $partner_negara = $partner_negara->where('institusi', $request->institusi);
            $partner_type = $partner_type->where('institusi', $request->institusi);
        }

        if ($request->has('jabatan') && $request->jabatan != 'all') {
            $data = $data->where('jabatan', $request->jabatan);
            $partner_institusi = $partner_institusi->where('jabatan', $request->jabatan);
            $partner_jabatan = $partner_jabatan->where('jabatan', $request->jabatan);
            $partner_negara = $partner_negara->where('jabatan', $request->jabatan);
            $partner_type = $partner_type->where('jabatan', $request->jabatan);
        }

        if ($request->has('negara') && $request->negara != 'all') {
            $data = $data->where('negara', $request->negara);
            $partner_institusi = $partner_institusi->where('negara', $request->negara);
            $partner_jabatan = $partner_jabatan->where('negara', $request->negara);
            $partner_negara = $partner_negara->where('negara', $request->negara);
            $partner_type = $partner_type->where('negara', $request->negara);
        }

        if ($request->has('type') && $request->type != 'all') {
            $data = $data->where('type', $request->type);
            $partner_institusi = $partner_institusi->where('type', $request->type);
            $partner_jabatan = $partner_jabatan->where('type', $request->type);
            $partner_negara = $partner_negara->where('type', $request->type);
            $partner_type = $partner_type->where('type', $request->type);
        }

        $count = $data->count();
        $data = $data->get();

        $partner_institusi = $partner_institusi->get();
        $label_institusi = $partner_institusi->pluck('institusi');
        $total_institusi = $partner_institusi->pluck('total');

        $partner_jabatan = $partner_jabatan->get();
        $label_jabatan = $partner_jabatan->pluck('jabatan');
        $total_jabatan = $partner_jabatan->pluck('total');

        $partner_negara = $partner_negara->get();
        $label_negara = $partner_negara->pluck('negara');
        $total_negara = $partner_negara->pluck('total');

        $partner_type = $partner_type->get();
        $label_type = $partner_type->pluck('type');
        $total_type = $partner_type->pluck('total');

        // pluck negara
        /* $negara_raw = partner::select('negara', DB::raw('count(*) as total'))
            ->groupBy('negara')
            ->get();
        $negara = $negara_raw->pluck('negara');
        $total = $negara_raw->pluck('total'); */

        return view('partner.index', [
            'data' => $data,
            'count' => $count,

            'institusi_option' => $institusi_option,
            'jabatan_option' => $jabatan_option,
            'negara_option' => $negara_option,
            'type_option' => $type_option,

            'institusi_selected' => $request->institusi,
            'jabatan_selected' => $request->jabatan,
            'negara_selected' => $request->negara,
            'type_selected' => $request->type,

            'label_institusi' => $label_institusi,
            'total_institusi' => $total_institusi,

            'label_jabatan' => $label_jabatan,
            'total_jabatan' => $total_jabatan,

            'label_negara' => $label_negara,
            'total_negara' => $total_negara,

            'label_type' => $label_type,
            'total_type' => $total_type,
        ]);
    }
    public function index_admin()
    {
        $partner = partner::all();
        $count = partner::count();
        // pluck negara
        $negara_raw = partner::select('negara', DB::raw('count(*) as total'))
            ->groupBy('negara')
            ->get();
        $negara = $negara_raw->pluck('negara');
        $total = $negara_raw->pluck('total');

        $partner_negara = partner::select('negara', DB::raw('count(*) as total'))->groupBy('negara');
        $label_negara = $partner_negara->pluck('negara');
        $total_negara = $partner_negara->pluck('total');

        $partner_type = partner::select('type', DB::raw('count(*) as total'))->groupBy('type');
        $label_type = $partner_type->pluck('type');
        $total_type = $partner_type->pluck('total');

        return view('partner.input_index', ['data' => $partner, 'count' => $count, 'negara' => $negara, 'total' => $total, 'label_negara' => $label_negara, 'total_negara' => $total_negara, 'label_type' => $label_type, 'total_type' => $total_type]);
    }

    public function create()
    {
        return view('partner.input_add');
    }

    public function partnerexport()
    {
        return Excel::download(new PartnerExport, 'partner.xlsx');
    }

    public function partnerimport(Request $request)
    {
        Excel::import(new PartnerImport, $request->file('file')->store('temp'));
        return back();
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
