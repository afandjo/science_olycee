<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ChapterController; // admin upload



Route::get('/', function () {
    return view('welcome');
});



use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Inscription
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('inscription');
Route::post('/inscription', [AuthController::class, 'register'])->name('register');

// Connexion
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('connexion');
Route::post('/connexion', [AuthController::class, 'login'])->name('login');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


use App\Http\Controllers\AdminController;

// Formulaire de connexion admin
Route::get('/admin/connexion', [AdminController::class, 'showLogin'])->name('admin.connexion');

// Traitement de la connexion admin
Route::post('/admin/connexion', [AdminController::class, 'login'])->name('admin.login');

// Page admin (protégée)
Route::get('/admin', [AdminController::class, 'index'])->middleware(['web','is_admin'])->name('admin.home');


// Supprimer un utilisateur
Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

// Modifier un utilisateur (afficher le formulaire)
Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');

// Mettre à jour un utilisateur
Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');


// Déconnexion admin
Route::post('/admin/deconnexion', [AdminController::class, 'logout'])->name('admin.logout');


// Page des cours/chapitres (publique) — reliée au contrôleur pour charger les données
Route::get('/home', [AuthController::class, 'page'])->name('auth.page');


// Paiement + chapitres
Route::middleware('auth')->group(function(){
    Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement');
    Route::post('/paiement', [PaiementController::class, 'store'])->name('paiement.store');
    Route::get('/attente', [PaiementController::class, 'attente'])->name('attente');

    // show chapter page (only if user has a payment approved)
    Route::get('/chapitre/{id}', [ChapterController::class, 'show'])->name('chapitre.show');
});


Route::middleware(['web','is_admin'])->group(function(){
    Route::get('/admin/paiements', function(){
        $paiements = \App\Models\Paiement::with('user','chapter')->get();
        return view('admin.paiements', compact('paiements'));
    })->name('admin.paiements');

    Route::post('/admin/paiements/{id}/approuver', [PaiementController::class, 'approuver'])->name('admin.paiements.approuver');
    Route::post('/admin/paiements/{id}/rejeter', [PaiementController::class, 'rejeter'])->name('admin.paiements.rejeter');
    Route::post('/admin/paiements/{id}/comment', [PaiementController::class, 'updateComment'])->name('admin.paiements.comment');

    // upload video for a chapter
    Route::post('/admin/chapters/{id}/upload-video', [ChapterController::class, 'uploadVideo'])->name('admin.chapters.uploadVideo');
});

Route::middleware(['web','is_admin'])->prefix('admin')->group(function () {
    // Paiements validés pour un chapitre donné
    Route::get('/paiements/valides/{chapitre}', [PaiementController::class, 'valides'])
        ->name('paiements.valides');

    Route::get('/paiements/attente', [PaiementController::class, 'attente'])
        ->name('paiements.attente');

    // Liste des utilisateurs (dashboard -> sidebar)
    Route::get('/utilisateurs', [AdminController::class, 'users'])->name('admin.utilisateurs');

    // Chapitres CRUD (actions depuis l'onglet du dashboard)
    Route::post('/chapitres', [ChapterController::class, 'adminStore'])->name('admin.chapitres.store');
    Route::put('/chapitres/{id}', [ChapterController::class, 'adminUpdate'])->name('admin.chapitres.update');
    Route::delete('/chapitres/{id}', [ChapterController::class, 'adminDestroy'])->name('admin.chapitres.destroy');
});