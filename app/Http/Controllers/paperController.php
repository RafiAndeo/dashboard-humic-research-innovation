<?php

namespace App\Http\Controllers;

use App\Models\paper;
use Illuminate\Http\Request;

class paperController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            "jenis" => 'required',
            "judul" => 'required',
            "nama_jurnal" => 'required',
            "issue" => 'required',
            "volume" => 'required',
            "tahun" => 'required',
            "quartile" => 'required',
            "index" => 'required',
            "link" => 'required',
        ]);

        $paper = new paper();
        $paper->jenis = $request->jenis;
        $paper->judul = $request->judul;
        $paper->nama_jurnal = $request->nama_jurnal;
        $paper->issue = $request->issue;
        $paper->volume = $request->volume;
        $paper->tahun = $request->tahun;
        $paper->quartile = $request->quartile;
        $paper->index = $request->index;
        $paper->link = $request->link;

        $paper->save;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "jenis" => 'required',
            "judul" => 'required',
            "nama_jurnal" => 'required',
            "issue" => 'required',
            "volume" => 'required',
            "tahun" => 'required',
            "quartile" => 'required',
            "index" => 'required',
            "link" => 'required',
        ]);



        $paper = paper::where('paper_id', $id);
        $paper->update([
            "jenis" => $request->jenis,
            "judul" => $request->judul,
            "nama_jurnal" => $request->nama_jurnal,
            "issue" => $request->issue,
            "volume" => $request->volume,
            "tahun" => $request->tahun,
            "quartile" => $request->quartile,
            "index" => $request->index,
            "link" => $request->link,
        ]);

        $paper->save();
    }

}