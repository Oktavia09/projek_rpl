<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LoginController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/Register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/Register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/Login', [LoginController::class, 'create'])->name('login.create');
Route::post('/Login', [LoginController::class, 'store'])->name('login.store');
 Route::post('/logout', [SiswaController::class, 'logout'])->name('logout');

Route::get('/Dashboard', [DashboardController::class,'index'])->name('dashboard.index');



Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::post('/store', [SiswaController::class, 'store'])->name('store');

});


Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])
    ->name('guru.dashboard')
    ->middleware(['auth', 'role:guru']);
