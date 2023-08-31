<?php

use App\Http\Controllers\HKIController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\paperController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\researchController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ReportController;
use App\Models\paper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/token', function () {
    return csrf_token();
});

Route::get('/', function () {
    // ->where('isVerified', '=', 1)
    $paper_count = DB::table('paper')->count();
    $research_count = DB::table('research')->count();
    $hki_count = DB::table('hki')->count();
    $member_count = DB::table('member')->count();

    $raw_paper = DB::table('paper')->select('tahun')->get();
    $raw_research = DB::table('research')->select('tahun_diterima')->get();
    $raw_hki = DB::table('hki')->select('tahun')->get();

    $paper = [];
    $research = [];
    $hki = [];

    foreach ($raw_paper as $p) {
        $paper[] = $p->tahun;
    }

    foreach ($raw_research as $r) {
        $research[] = $r->tahun_diterima;
    }

    foreach ($raw_hki as $h) {
        $hki[] = $h->tahun;
    }

    $label = array_unique(array_merge($paper, $research, $hki));
    sort($label);


    $paper_count_by_year = [];
    $research_count_by_year = [];
    $hki_count_by_year = [];

    foreach ($label as $l) {
        $paper_count_by_year[] = DB::table('paper')->where('tahun', $l)->count();
        $research_count_by_year[] = DB::table('research')->where('tahun_diterima', $l)->count();
        $hki_count_by_year[] = DB::table('hki')->where('tahun', $l)->count();
    }

    // to string
    $label = implode(",", $label);
    $paper_count_by_year = implode(",", $paper_count_by_year);
    $research_count_by_year = implode(",", $research_count_by_year);
    $hki_count_by_year = implode(",", $hki_count_by_year);

    $paper_quartile = paper::select('quartile', DB::raw('count(*) as total'))
        ->groupBy('quartile')
        ->get();
    $label_quartile = $paper_quartile->pluck('quartile');
    $value_quartile = $paper_quartile->pluck('total');

    $paper_jenis = paper::select('jenis', DB::raw('count(*) as total'))
        ->groupBy('jenis')
        ->get();
    $label_jenis = $paper_jenis->pluck('jenis');
    $value_jenis = $paper_jenis->pluck('total');

    // dd($label);

    return view('dashboard', [
        'paper_count' => $paper_count,
        'research_count' => $research_count,
        'hki_count' => $hki_count,
        'member_count' => $member_count,
        'label' => $label,
        'paper_count_by_year' => $paper_count_by_year,
        'research_count_by_year' => $research_count_by_year,
        'hki_count_by_year' => $hki_count_by_year,
        'label_quartile' => $label_quartile,
        'value_quartile' => $value_quartile,
        'label_jenis' => $label_jenis,
        'value_jenis' => $value_jenis,
    ]);
})->name('dashboard');

Route::get('/hki', [HKIController::class, 'index'])->name('hki.index');
// Route::get('/hki/{id}', [HKIController::class, 'show'])->name('hki.show');
Route::get('/hki/input', [HKIController::class, 'index_admin'])->name('hki.index_admin')->middleware('auth');
Route::get('/hki/input/add', [HKIController::class, 'create'])->name('hki.create')->middleware('auth');
Route::post('/hki/input/add', [HKIController::class, 'store'])->name('hki.store')->middleware('auth');
Route::get('/hki/input/edit/{id}', [HKIController::class, 'edit'])->name('hki.edit')->middleware('auth');
Route::put('/hki/input/{id}', [HKIController::class, 'update'])->name('hki.update')->middleware('auth');
Route::delete('/hki/input/{id}', [HKIController::class, 'destroy'])->name('hki.destroy')->middleware('auth');
// member hki
Route::get('/hki/input/add_member_to_hki/{id}', [HKIController::class, 'add_member_to_hki_view'])->name('hki.add_member_to_hki_view')->middleware('auth');
Route::post('/hki/input/add_member_to_hki', [HKIController::class, 'add_member_to_hki'])->name('hki.add_member_to_hki')->middleware('auth');
Route::delete('/hki/input/{hki_id}/{member_id}', [HKIController::class, 'delete_member_from_hki'])->name('hki.delete_member_from_hki')->middleware('auth');
Route::get('/hki/input/{id}/members', [HKIController::class, 'find_members_of_hki'])->name('hki.find_members_of_hki')->middleware('auth');
// partner hki
Route::get('/hki/input/add_partner_to_hki/{id}', [HKIController::class, 'add_partner_to_hki_view'])->name('hki.add_partner_to_hki_view')->middleware('auth');
Route::post('/hki/input/add_partner_to_hki', [HKIController::class, 'add_partner_to_hki'])->name('hki.add_partner_to_hki')->middleware('auth');
Route::delete('/hki/input/partner/{hki_id}/{partner_id}', [HKIController::class, 'delete_partner_from_hki'])->name('hki.delete_partner_from_hki')->middleware('auth');
Route::get('/hki/input/{id}/partners', [HKIController::class, 'find_partners_of_hki'])->name('hki.find_partners_of_hki')->middleware('auth');
// verify hki
Route::get('/hki/input/verify/{id}', [HKIController::class, 'verifikasi'])->name('hki.verifikasi')->middleware('auth');;
// excel
Route::get('/hki/export', [HKIController::class, 'hkiexport'])->name('hki.export');
Route::post('/hki/import', [HKIController::class, 'hkiimport'])->name('hki.import')->middleware('auth');

Route::post('/login', [MemberController::class, 'login'])->name('member.login_proses');
Route::post('/logout', [MemberController::class, 'logout'])->name('member.logout');

Route::get('/member', [MemberController::class, 'index'])->name('member.index');
Route::get('/member/show/{id}', [MemberController::class, 'show'])->name('member.show');
Route::get('/member/input/', [MemberController::class, 'index_admin'])->name('member.index_admin')->middleware('auth');
// Route::get('/member/input/{id}', [MemberController::class, 'show'])->name('member.show')->middleware('auth');
Route::get('/member/input/add', [MemberController::class, 'create'])->name('member.create')->middleware('auth');
Route::post('/member/input/add', [MemberController::class, 'store'])->name('member.store')->middleware('auth');
Route::get('/member/input/edit/{id}', [MemberController::class, 'edit'])->name('member.edit')->middleware('auth');
Route::put('/member/input/edit/{id}', [MemberController::class, 'update'])->name('member.update')->middleware('auth');
Route::delete('/member/input/{id}', [MemberController::class, 'destroy'])->name('member.destroy')->middleware('auth');
Route::get('/login', [MemberController::class, 'login_index'])->name('member.login_index');
Route::get('/member/export', [MemberController::class, 'memberexport'])->name('member.export');
Route::post('/member/import', [MemberController::class, 'memberimport'])->name('member.import')->middleware('auth');

Route::get('/partner', [PartnerController::class, 'index'])->name('partner.index')->middleware('auth');
Route::get('/partner/input', [PartnerController::class, 'index_admin'])->name('partner.index_admin')->middleware('auth');
Route::get('/partner/input/add', [PartnerController::class, 'create'])->name('partner.create')->middleware('auth');
Route::post('/partner/input/add', [PartnerController::class, 'store'])->name('partner.store')->middleware('auth');
Route::get('/partner/input/edit/{id}', [PartnerController::class, 'edit'])->name('partner.edit')->middleware('auth');
Route::put('/partner/input/edit/{id}', [PartnerController::class, 'update'])->name('partner.update')->middleware('auth');
Route::delete('/partner/input/delete/{id}', [PartnerController::class, 'destroy'])->name('partner.destroy')->middleware('auth');

Route::get('/research', [researchController::class, 'index'])->name('research.index');
Route::get('/research/input', [researchController::class, 'index_admin'])->name('research.index_admin')->middleware('auth');
Route::get('/research/input/add', [researchController::class, 'create'])->name('research.create')->middleware('auth');
Route::get('/research/input/edit/{id}', [researchController::class, 'show'])->name('research.show')->middleware('auth');
Route::post('/research/input', [researchController::class, 'store'])->name('research.store')->middleware('auth');
Route::put('/research/input/{id}', [researchController::class, 'update'])->name('research.update')->middleware('auth');
Route::delete('/research/input/delete/{id}', [researchController::class, 'destroy'])->name('research.destroy')->middleware('auth');
// verify research
Route::get('/research/input/verify/{id}', [researchController::class, 'verifikasi'])->name('research.verifikasi')->middleware('auth');
// add member research
Route::get('/research/input/add_member_to_research/{id}', [researchController::class, 'add_member_to_research_view'])->name('research.add_member_to_research_view')->middleware('auth');
Route::post('/research/input/add_member_to_research', [researchController::class, 'add_member_to_research'])->name('research.add_member_to_research')->middleware('auth');
Route::delete('/research/input/{research_id}/{member_id}', [researchController::class, 'delete_member_from_research'])->name('research.delete_member_from_research')->middleware('auth');
Route::get('/research/input/{id}/members', [researchController::class, 'find_members_of_research'])->name('research.find_members_of_research')->middleware('auth');
// add partner research
Route::get('/research/input/add_partner_to_research/{id}', [researchController::class, 'add_partner_to_research_view'])->name('research.add_partner_to_research_view')->middleware('auth');;
Route::post('/research/input/add_partner_to_research', [researchController::class, 'add_partner_to_research'])->name('research.add_partner_to_research')->middleware('auth');;
Route::delete('/research/input/{research_id}/{partner_id}', [researchController::class, 'delete_partner_from_research'])->name('research.delete_partner_from_research')->middleware('auth');;
Route::get('/research/input/{id}/partners', [researchController::class, 'find_partners_of_research'])->name('research.find_partners_of_research')->middleware('auth');;
// excel
Route::get('/research/export', [researchController::class, 'researchexport'])->name('research.export')->middleware('auth');
Route::post('/research/import', [researchController::class, 'researchimport'])->name('research.import')->middleware('auth');

// PAPER
Route::get('/paper', [paperController::class, 'index'])->name('paper.index');
// Route::get('/paper/{id}', [paperController::class, 'show'])->name('paper.show');
Route::get('/paper/input', [paperController::class, 'index_admin'])->name('paper.index_admin');
Route::get('/paper/input/add', [paperController::class, 'create'])->name('paper.create');
Route::post('/paper/input/add', [paperController::class, 'store'])->name('paper.store');
Route::get('/paper/input/edit/{id}', [paperController::class, 'edit'])->name('paper.edit');
Route::put('/paper/input/edit/{id}', [paperController::class, 'update'])->name('paper.update');
Route::delete('/paper/input/delete/{id}', [paperController::class, 'destroy'])->name('paper.destroy');
// verify Paper
Route::get('/paper/input/verify/{id}', [paperController::class, 'verifikasi'])->name('paper.verifikasi')->middleware('auth');
// member paper
Route::get('/paper/input/add_member_to_paper/{id}', [paperController::class, 'add_member_to_paper_view'])->name('paper.add_member_to_paper_view');
Route::post('/paper/input/add_member_to_paper', [paperController::class, 'add_member_to_paper'])->name('paper.add_member_to_paper');
Route::delete('/paper/input/{paper_id}/{member_id}', [paperController::class, 'delete_member_from_paper'])->name('paper.delete_member_from_paper');
Route::get('/paper/input/{id}/members', [paperController::class, 'find_members_of_paper'])->name('paper.find_members_of_paper');
// partner paper
Route::get('/paper/input/add_partner_to_paper/{id}', [paperController::class, 'add_partner_to_paper_view'])->name('paper.add_partner_to_paper_view');
Route::post('/paper/add_partner_to_paper', [paperController::class, 'add_partner_to_paper'])->name('paper.add_partner_to_paper');
Route::delete('/paper/{paper_id}/{partner_id}', [paperController::class, 'delete_partner_from_paper'])->name('paper.delete_partner_from_paper');
Route::get('/paper/{id}/partners', [paperController::class, 'find_partners_of_paper'])->name('paper.find_partners_of_paper');
// partner excel
Route::get('/paper/export', [paperController::class, 'paperexport'])->name('paper.export');
Route::post('/paper/import', [paperController::class, 'paperimport'])->name('paper.import');


//import all
Route::post('/importall', [ImportController::class, 'import_all']);

//Store and fetch images
Route::post('/member/store_image/{id}', [MemberController::class, 'insert_image']);
Route::get('/member/fetch_image/{id}', [MemberController::class, 'fetch_image']);


// report
Route::get('/report/paper', [ReportController::class, 'paper'])->name('report.paper');
Route::get('/report/hki', [ReportController::class, 'hki'])->name('report.hki');
Route::get('/report/research', [ReportController::class, 'research'])->name('report.research');
Route::get('/report/member', [ReportController::class, 'member'])->name('report.member');
Route::get('/report/partner', [ReportController::class, 'partner'])->name('report.partner');
