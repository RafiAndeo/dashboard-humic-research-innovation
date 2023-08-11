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
Route::get('/hki/export', [HKIController::class, 'hkiexport'])->name('hki.export');
Route::get('/hki/import', [HKIController::class, 'hkiimport'])->name('hki.import');

Route::get('/member', [MemberController::class, 'index'])->name('member.index');
Route::get('/member/{id}', [MemberController::class, 'show'])->name('member.show');
Route::post('/member', [MemberController::class, 'store'])->name('member.store');
Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
Route::post('/login', [MemberController::class, 'login']);

Route::get('/research', [researchController::class, 'index'])->name('research.index');
Route::get('/research/{id}', [researchController::class, 'show'])->name('research.show');
Route::post('/research', [researchController::class, 'store'])->name('research.store');
Route::put('/research/{id}', [researchController::class, 'update'])->name('research.update');
Route::delete('/research/{id}', [researchController::class, 'destroy'])->name('research.destroy');
Route::post('/research/add_member_to_research', [researchController::class, 'add_member_to_research'])->name('research.add_member_to_research');
Route::delete('/research/{research_id}/{member_id}', [researchController::class, 'delete_member_from_research'])->name('research.delete_member_from_research');
Route::get('/research/{id}/members', [researchController::class, 'find_members_of_research'])->name('research.find_members_of_research');

Route::get('/paper', [paperController::class, 'index'])->name('paper.index');
Route::get('/paper/{id}', [paperController::class, 'show'])->name('paper.show');
Route::post('/paper', [paperController::class, 'store'])->name('paper.store');
Route::put('/paper/{id}', [paperController::class, 'update'])->name('paper.update');
Route::delete('/paper/{id}', [paperController::class, 'destroy'])->name('paper.destroy');
Route::post('/paper/add_member_to_paper', [paperController::class, 'add_member_to_paper'])->name('paper.add_member_to_paper');
Route::delete('/paper/{paper_id}/{member_id}', [paperController::class, 'delete_member_from_paper'])->name('paper.delete_member_from_paper');
Route::get('/paper/{id}/members', [paperController::class, 'find_members_of_paper'])->name('paper.find_members_of_paper');
