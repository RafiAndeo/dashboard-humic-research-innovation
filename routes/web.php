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
Route::post('/hki', [HKIController::class, 'store']);
Route::put('/hki/{id}', [HKIController::class, 'update']);
Route::delete('/hki/{id}', [HKIController::class, 'destroy']);

Route::get('/member', [MemberController::class, 'index']);
Route::post('/member', [MemberController::class, 'store']);
Route::put('/member/{id}', [MemberController::class, 'update']);
Route::delete('/member/{id}', [MemberController::class, 'destroy']);

Route::get('/research', [researchController::class, 'index']);
Route::post('/research', [researchController::class, 'store']);
Route::put('/research/{id}', [researchController::class, 'update']);
Route::delete('/research/{id}', [researchController::class, 'destroy']);

Route::get('/paper', [paperController::class, 'index']);
Route::post('/paper', [paperController::class, 'store']);
Route::put('/paper/{id}', [paperController::class, 'update']);
Route::delete('/paper/{id}', [paperController::class, 'destroy']);

Route::get('/partner', [PartnerController::class, 'index']);
Route::post('/partner', [PartnerController::class, 'store']);
Route::put('/partner/{id}', [PartnerController::class, 'update']);
Route::delete('/partner/{id}', [PartnerController::class, 'destroy']);