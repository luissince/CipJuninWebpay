<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IdentifyController;

Route::get('/', function (Request $request) {
    if ($request->session()->has('LoginSession')) {
        return view('admin.admin');
    } else {
        return view('welcome');
    }
})->name('index');

Route::get('/login', [SessionController::class, 'index'])->name('login.index');
Route::get('/logout', [SessionController::class, 'logout'])->name('login.logout');
Route::post('/login', [SessionController::class, 'valid'])->name('login.valid');

Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
Route::get('/register/data', [RegisterController::class, 'data'])->name('register.data');
Route::post('/register/valid', [RegisterController::class, 'valid'])->name('register.valid');
Route::post('/register/save', [RegisterController::class, 'savePassword'])->name('register.password');

Route::get('/identify', [IdentifyController::class, 'index'])->name('identify.index');
Route::post('/identify/valid', [IdentifyController::class, 'valid'])->name('identify.valid');
Route::post('/identify/code', [IdentifyController::class, 'code'])->name('identify.code');
Route::post('/identify/save', [IdentifyController::class, 'save'])->name('identify.save');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
