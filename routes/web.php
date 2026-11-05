<?php

use App\Http\Controllers\Admin\ComponentController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SponsorOfferController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/* -------------------------------------------------------------------------
| Routes publiques
|------------------------------------------------------------------------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/programme', [PageController::class, 'program'])->name('program');
Route::get('/exposants', [PageController::class, 'exhibitors'])->name('exhibitors');
Route::get('/galerie', [PageController::class, 'gallery'])->name('gallery');
Route::get('/partenaires', [PageController::class, 'partners'])->name('partners');
Route::permanentRedirect('/sponsoring', '/partenaires#sponsoring')->name('sponsoring');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/inscription', [RegistrationController::class, 'create'])->name('registrations.create');
Route::post('/inscription', [RegistrationController::class, 'store'])->middleware('throttle:5,10')->name('registrations.store');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,10')->name('contact.store');

/* -------------------------------------------------------------------------
| Authentification
|------------------------------------------------------------------------- */
Route::get('/login', [LoginController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware(['guest', 'throttle:5,1']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/* -------------------------------------------------------------------------
| Espace administration
|------------------------------------------------------------------------- */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('composantes', ComponentController::class)
        ->parameters(['composantes' => 'component'])
        ->except(['show']);

    Route::resource('agenda', ScheduleController::class)
        ->parameters(['agenda' => 'schedule'])
        ->except(['show']);

    Route::resource('partenaires', PartnerController::class)
        ->parameters(['partenaires' => 'partner'])
        ->except(['show']);

    Route::resource('sponsoring', SponsorOfferController::class)
        ->parameters(['sponsoring' => 'offer'])
        ->except(['show']);

    Route::resource('galerie', GalleryController::class)
        ->parameters(['galerie' => 'gallery'])
        ->except(['show']);

    Route::get('inscriptions/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');
    Route::post('inscriptions/{registration}/statut', [AdminRegistrationController::class, 'updateStatus'])->name('inscriptions.status');
    Route::resource('inscriptions', AdminRegistrationController::class)
        ->parameters(['inscriptions' => 'registration'])
        ->only(['index', 'show', 'destroy']);

    Route::post('messages/{message}/lu', [ContactMessageController::class, 'toggleRead'])->name('messages.toggleRead');
    Route::resource('messages', ContactMessageController::class)
        ->parameters(['messages' => 'message'])
        ->only(['index', 'show', 'destroy']);

    Route::get('parametres', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('parametres', [SettingController::class, 'update'])->name('settings.update');
});
