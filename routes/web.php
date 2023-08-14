<?php

use App\Http\Controllers\HKIController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\paperController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\researchController;
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
    return view('dashboard');
})->name('dashboard');

Route::get('/hki', [HKIController::class, 'index'])->name('hki.index');
Route::get('/hki/{id}', [HKIController::class, 'show'])->name('hki.show');
Route::post('/hki', [HKIController::class, 'store'])->name('hki.store');
Route::put('/hki/{id}', [HKIController::class, 'update'])->name('hki.update');
Route::delete('/hki/{id}', [HKIController::class, 'destroy'])->name('hki.destroy');
Route::post('/hki/add_member_to_hki', [HKIController::class, 'add_member_to_hki'])->name('hki.add_member_to_hki');
Route::delete('/hki/{hki_id}/{member_id}', [HKIController::class, 'delete_member_from_hki'])->name('hki.delete_member_from_hki');
Route::get('/hki/{id}/members', [HKIController::class, 'find_members_of_hki'])->name('hki.find_members_of_hki');
Route::post('/hki/add_partner_to_hki', [HKIController::class, 'add_partner_to_hki'])->name('hki.add_partner_to_hki');
Route::delete('/hki/{hki_id}/{partner_id}', [HKIController::class, 'delete_partner_from_hki'])->name('hki.delete_partner_from_hki');
Route::get('/hki/{id}/partners', [HKIController::class, 'find_partners_of_hki'])->name('hki.find_partners_of_hki');
Route::get('/hki/export', [HKIController::class, 'hkiexport'])->name('hki.export');
Route::post('/hki/import', [HKIController::class, 'hkiimport'])->name('hki.import')->middleware('auth', 'admin');

Route::post('/login', [MemberController::class, 'login'])->name('member.login_proses');
Route::post('/logout', [MemberController::class, 'logout'])->name('member.logout');

Route::get('/member', [MemberController::class, 'index'])->name('member.index');
Route::get('/member/input/', [MemberController::class, 'index_admin'])->name('member.index_admin')->middleware('auth', 'admin');
// Route::get('/member/input/{id}', [MemberController::class, 'show'])->name('member.show')->middleware('auth', 'admin');
Route::get('/member/input/add', [MemberController::class, 'create'])->name('member.create')->middleware('auth', 'admin');
Route::post('/member/input/add', [MemberController::class, 'store'])->name('member.store')->middleware('auth', 'admin');
Route::get('/member/input/edit/{id}', [MemberController::class, 'edit'])->name('member.edit')->middleware('auth', 'admin');
Route::put('/member/input/edit/{id}', [MemberController::class, 'update'])->name('member.update')->middleware('auth', 'admin');
Route::delete('/member/input/{id}', [MemberController::class, 'destroy'])->name('member.destroy')->middleware('auth', 'admin');
Route::get('/login', [MemberController::class, 'login_index'])->name('member.login_index');
Route::get('/member/export', [MemberController::class, 'memberexport'])->name('member.export');
Route::post('/member/import', [MemberController::class, 'memberimport'])->name('member.import')->middleware('auth', 'admin');

Route::get('/partner/input', [PartnerController::class, 'index'])->name('partner.index');
Route::get('/partner/input/add', [PartnerController::class, 'create'])->name('partner.create');
Route::post('/partner/input/add', [PartnerController::class, 'store'])->name('partner.store');
Route::get('/partner/input/edit/{id}', [PartnerController::class, 'edit'])->name('partner.edit');
Route::put('/partner/input/edit/{id}', [PartnerController::class, 'update'])->name('partner.update');
Route::delete('/partner/input/delete/{id}', [PartnerController::class, 'destroy'])->name('partner.destroy');

Route::get('/research', [researchController::class, 'index'])->name('research.index');
Route::get('/research/input', [researchController::class, 'index_admin'])->name('research.index_admin')->middleware('auth', 'admin');
Route::get('/research/input/add', [researchController::class, 'create'])->name('research.create')->middleware('auth', 'admin');
Route::get('/research/input/edit/{id}', [researchController::class, 'show'])->name('research.show')->middleware('auth', 'admin');
Route::post('/research/input', [researchController::class, 'store'])->name('research.store')->middleware('auth', 'admin');
Route::put('/research/input/{id}', [researchController::class, 'update'])->name('research.update')->middleware('auth', 'admin');
Route::delete('/research/input/delete/{id}', [researchController::class, 'destroy'])->name('research.destroy')->middleware('auth', 'admin');
// add member research
Route::get('/research/input/add_member_to_research/{id}', [researchController::class, 'add_member_to_research_view'])->name('research.add_member_to_research_view')->middleware('auth', 'admin');
Route::post('/research/input/add_member_to_research', [researchController::class, 'add_member_to_research'])->name('research.add_member_to_research')->middleware('auth', 'admin');
Route::delete('/research/input/{research_id}/{member_id}', [researchController::class, 'delete_member_from_research'])->name('research.delete_member_from_research')->middleware('auth', 'admin');
Route::get('/research/input/{id}/members', [researchController::class, 'find_members_of_research'])->name('research.find_members_of_research')->middleware('auth', 'admin');
// add partner research
Route::get('/research/input/add_partner_to_research/{id}', [researchController::class, 'add_partner_to_research_view'])->name('research.add_partner_to_research_view');
Route::post('/research/input/add_partner_to_research', [researchController::class, 'add_partner_to_research'])->name('research.add_partner_to_research');
Route::delete('/research/input/{research_id}/{partner_id}', [researchController::class, 'delete_partner_from_research'])->name('research.delete_partner_from_research');
Route::get('/research/input/{id}/partners', [researchController::class, 'find_partners_of_research'])->name('research.find_partners_of_research');
// excel
Route::get('/research/export', [researchController::class, 'researchexport'])->name('research.export')->middleware('auth', 'admin');
Route::post('/research/import', [researchController::class, 'researchimport'])->name('research.import')->middleware('auth', 'admin');

// PAPER
Route::get('/paper', [paperController::class, 'index'])->name('paper.index');
// Route::get('/paper/{id}', [paperController::class, 'show'])->name('paper.show');
Route::get('/paper/input', [paperController::class, 'index_admin'])->name('paper.index_admin');
Route::get('/paper/input/add', [paperController::class, 'create'])->name('paper.create');
Route::post('/paper/input/add', [paperController::class, 'store'])->name('paper.store');
Route::put('/paper/input/edit/{id}', [paperController::class, 'update'])->name('paper.update');
Route::delete('/paper/input/delete/{id}', [paperController::class, 'destroy'])->name('paper.destroy');

Route::post('/paper/add_member_to_paper', [paperController::class, 'add_member_to_paper'])->name('paper.add_member_to_paper');
Route::delete('/paper/{paper_id}/{member_id}', [paperController::class, 'delete_member_from_paper'])->name('paper.delete_member_from_paper');
Route::get('/paper/{id}/members', [paperController::class, 'find_members_of_paper'])->name('paper.find_members_of_paper');
Route::post('/paper/add_partner_to_paper', [paperController::class, 'add_partner_to_paper'])->name('paper.add_partner_to_paper');
Route::delete('/paper/{paper_id}/{partner_id}', [paperController::class, 'delete_partner_from_paper'])->name('paper.delete_partner_from_paper');
Route::get('/paper/{id}/partners', [paperController::class, 'find_partners_of_paper'])->name('paper.find_partners_of_paper');
Route::get('/paper/export', [paperController::class, 'paperexport'])->name('paper.export');
Route::post('/paper/import', [paperController::class, 'paperimport'])->name('paper.import');
