<?php

namespace App\Http\Controllers;

use App\Models\paper;
use Illuminate\Http\Request;

class paperController extends Controller
{
    public function index()
    {
        $paper = paper::all();
        return $paper;
    }

    public function show($id)
    {
        $paper = paper::find($id);
        return $paper;
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

        $paper->save();

        return "OK";
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

        $paper = paper::find($id);
        $paper->jenis = $request->jenis;
        $paper->judul = $request->judul;
        $paper->nama_jurnal = $request->nama_jurnal;
        $paper->issue = $request->issue;
        $paper->volume = $request->volume;
        $paper->tahun = $request->tahun;
        $paper->quartile = $request->quartile;
        $paper->index = $request->index;
        $paper->link = $request->link;

        $paper->save();

        return "OK";
    }

    public function destroy(paper $paper, $id)
    {
        $paper = paper::find($id);
        $paper->delete();

        return "OK";
    }
}
