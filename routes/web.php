<?php

use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/pendaftaran/{applicant:registration_number}', [PublicController::class, 'show'])->name('registrations.show');
Route::get('/cek-status', [PublicController::class, 'statusForm'])->name('registrations.status.form');
Route::post('/cek-status', [PublicController::class, 'status'])->name('registrations.status');
Route::get('/pengumuman', [PublicController::class, 'announcement'])->name('announcement');
Route::get('/profil-sekolah', [PublicController::class, 'profile'])->name('school.profile');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/registrasi-akun', [AuthController::class, 'showRegister'])->name('account.register');
Route::post('/registrasi-akun', [AuthController::class, 'register'])->name('account.store');

Route::middleware('auth')->group(function (): void {
    Route::get('/daftar', [PublicController::class, 'create'])->name('registrations.create');
    Route::post('/daftar', [PublicController::class, 'store'])->name('registrations.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/pendaftar/export', [ApplicantController::class, 'export'])->name('applicants.export');
        Route::get('/pendaftar', [ApplicantController::class, 'index'])->name('applicants.index');
        Route::get('/pendaftar/{applicant}', [ApplicantController::class, 'show'])->name('applicants.show');
        Route::patch('/pendaftar/{applicant}/verifikasi', [ApplicantController::class, 'updateVerification'])->name('applicants.verification');
        Route::patch('/pendaftar/{applicant}/seleksi', [ApplicantController::class, 'updateSelection'])->name('applicants.selection');
        Route::get('/pendaftar/{applicant}/berkas/{document}', [ApplicantController::class, 'download'])
            ->whereIn('document', ['akta', 'kk', 'foto'])
            ->name('applicants.documents');
        Route::get('/pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
        Route::patch('/pengaturan', [SettingController::class, 'update'])->name('settings.update');
        Route::get('/profil-sekolah', [SchoolProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profil-sekolah', [SchoolProfileController::class, 'update'])->name('profile.update');
    });
