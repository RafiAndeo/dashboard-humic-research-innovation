<?php

use App\Http\Controllers\HKIController;
use App\Http\Controllers\MemberController;
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
