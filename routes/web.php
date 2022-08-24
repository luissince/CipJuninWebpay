<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IdentifyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CourseController;

Route::get('/', [AdminController::class, 'index'])->name('index');

Route::get('/login', [SessionController::class, 'index'])->name('login.index');
Route::get('/logout', [SessionController::class, 'logout'])->name('login.logout');
Route::post('/login', [SessionController::class, 'valid'])->name('login.valid');

Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
Route::post('/register/valid', [RegisterController::class, 'valid'])->name('register.valid');
Route::post('/register/save', [RegisterController::class, 'save'])->name('register.save');

Route::get('/information', [InformationController::class, 'index'])->name('information.index');

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
Route::post('/voucher/certhabilidadall', [VoucherController::class, 'certhabilidadall'])->name('voucher.certhabilidadall');
// Route::post('/voucher/certobraall', [VoucherController::class, 'invoice'])->name('voucher.certobraall');
// Route::post('/voucher/certproyectoall', [VoucherController::class, 'invoice'])->name('voucher.certproyectoall');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
Route::post('/jobs/alljobs', [JobsController::class, 'alljobs'])->name('jobs.alljobs');
Route::get('/jobs/dataid', [JobsController::class, 'dataid'])->name('jobs.dataid');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/data', [SearchController::class, 'data'])->name('search.data');

Route::get('/course', [CourseController::class, 'index'])->name('course.index');
Route::post('/course/allcourses', [CourseController::class, 'allcourses'])->name('course.allcourses');
Route::get('/course/dataid', [CourseController::class, 'dataid'])->name('course.dataid');
Route::post('/course/addinscription', [CourseController::class, 'addinscription'])->name('course.addinscription');

Route::get('/course/mycourses', [CourseController::class, 'mycourses'])->name('course.mycourses');
Route::post('/course/allmycourses', [CourseController::class, 'allmycourses'])->name('course.allmycourses');
