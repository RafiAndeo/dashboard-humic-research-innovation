<?php

namespace App\Http\Controllers;

use App\Models\paper;
use Illuminate\Http\Request;
use App\Models\member_paper;
use App\Models\member;

class paperController extends Controller
{
    public function index()
    {
        $data = paper::all();
        return view('publikasi.index', ['data' => $data]);
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



        $paper = paper::where('id', $id);
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

        return "OK";
    }

    public function destroy(paper $paper, $id)
    {
        $paper = paper::where('id', $id);
        $paper->delete();

        return "OK";
    }

    public function delete_member_from_paper(member_paper $member_paper, $member_id, $paper_id)
    {
        $member_paper = member_paper::where([['paper_id', $paper_id], ['member_id', $member_id]]);
        $member_paper->delete();

        return "berhasil delete member dari paper";
    }

    public function add_member_to_paper(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'paper_id' => 'required',
        ]);

        if (!(paper::where('id', $request->paper_id)->exists()) || !(member::where('id', $request->member_id)->exists())) {
            return "paper atau member tidak ditemukan";
        } else {
            $paper_member = new member_paper;
            $paper_member->paper_id = $request->paper_id;
            $paper_member->member_id = $request->member_id;

            $paper_member->save();
            return "berhasil menambahkan member ke paper";
        }
    }

    public function find_members_of_paper($id)
    {
        $data = member_paper::where('paper_id', $id)->get();
        return $data;
    }
}