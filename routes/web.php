<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AdminController;


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
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
