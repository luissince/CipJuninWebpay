<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IdentifyController;

Route::get('/', [AdminController::class, 'index'])->name('index');

Route::get('/login', [SessionController::class, 'index'])->name('login.index');
Route::get('/logout', [SessionController::class, 'logout'])->name('login.logout');
Route::post('/login', [SessionController::class, 'valid'])->name('login.valid');

Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
Route::post('/register/valid', [RegisterController::class, 'valid'])->name('register.valid');
Route::post('/register/save', [RegisterController::class, 'save'])->name('register.save');

Route::get('/identify', [IdentifyController::class, 'index'])->name('identify.index');
Route::post('/identify/valid', [IdentifyController::class, 'valid'])->name('identify.valid');
Route::post('/identify/code', [IdentifyController::class, 'code'])->name('identify.code');
Route::post('/identify/save', [IdentifyController::class, 'save'])->name('identify.save');
