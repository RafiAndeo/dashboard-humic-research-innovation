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

Route::get('/hki', [HKIController::class, 'index']);
Route::get('/hki/{id}', [HKIController::class, 'show']);
Route::post('/hki', [HKIController::class, 'store']);
Route::put('/hki/{id}', [HKIController::class, 'update']);
Route::delete('/hki/{id}', [HKIController::class, 'destroy']);
Route::post('/hki/add_member_to_hki', [HKIController::class, 'add_member_to_hki']);
Route::delete('/hki/{hki_id}/{member_id}', [HKIController::class, 'delete_member_from_hki']);
Route::get('/hki/{id}/members', [HKIController::class, 'find_members_of_hki']);

Route::get('/member', [MemberController::class, 'index']);
Route::get('/member/{id}', [MemberController::class, 'show']);
Route::post('/member', [MemberController::class, 'store']);
Route::put('/member/{id}', [MemberController::class, 'update']);
Route::delete('/member/{id}', [MemberController::class, 'destroy']);

Route::get('/research', [researchController::class, 'index']);
Route::get('/research/{id}', [researchController::class, 'show']);
Route::post('/research', [researchController::class, 'store']);
Route::put('/research/{id}', [researchController::class, 'update']);
Route::delete('/research/{id}', [researchController::class, 'destroy']);
Route::post('/research/add_member_to_research', [researchController::class, 'add_member_to_research']);
Route::delete('/research/{research_id}/{member_id}', [researchController::class, 'delete_member_from_research']);
Route::get('/research/{id}/members', [researchController::class, 'find_members_of_research']);

Route::get('/paper', [paperController::class, 'index']);
Route::get('/paper/{id}', [paperController::class, 'show']);
Route::post('/paper', [paperController::class, 'store']);
Route::put('/paper/{id}', [paperController::class, 'update']);
Route::delete('/paper/{id}', [paperController::class, 'destroy']);
Route::post('/paper/add_member_to_paper', [paperController::class, 'add_member_to_paper']);
Route::delete('/paper/{paper_id}/{member_id}', [paperController::class, 'delete_member_from_paper']);
Route::get('/paper/{id}/members', [paperController::class, 'find_members_of_paper']);
