<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IdentifyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VoucherController;

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

Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
Route::post('/service/cuotas', [ServiceController::class, 'cuotas'])->name('service.cuotas');
Route::post('/service/certificado', [ServiceController::class, 'certificado'])->name('service.certificado');
Route::post('/service/allComprobantes', [ServiceController::class, 'allComprobantes'])->name('service.allComprobantes');
Route::post('/service/savePay', [ServiceController::class, 'savePay'])->name('service.savePay');

Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher.index');
Route::get('/voucher/invoice', [VoucherController::class, 'invoice'])->name('voucher.invoice');
Route::get('/voucher/certhabilidad', [VoucherController::class, 'certhabilidad'])->name('voucher.certhabilidad');
Route::get('/voucher/certobra', [VoucherController::class, 'certobra'])->name('voucher.certobra');
Route::get('/voucher/certproyecto', [VoucherController::class, 'certproyecto'])->name('voucher.certproyecto');
Route::post('/voucher/invoiceall', [VoucherController::class, 'invoiceall'])->name('voucher.invoiceall');
Route::post('/voucher/certhabilidadall', [VoucherController::class, 'invoice'])->name('voucher.certhabilidadall');
Route::post('/voucher/certobraall', [VoucherController::class, 'invoice'])->name('voucher.certobraall');
Route::post('/voucher/certproyectoall', [VoucherController::class, 'invoice'])->name('voucher.certproyectoall');
