<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/home',[HomeController::class ,'homeshow'])->name('homeshow');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/details/{id}', [HomeController::class, 'detailshow'])->name('details');
Route::get('member/details/{id}', [HomeController::class, 'detailmember'])->name('detailsm');

Route::post('/favorites/add/{id}', [HomeController::class, 'addToFavorites'])->name('favorites.add');
Route::delete('/favorites/remove/{id}', [HomeController::class, 'removeFromFavorites'])->name('favorites.remove');
Route::get('/favorites', [HomeController::class, 'showFavorites'])->name('favorites');


// Authentication Routes
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/reset-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password/update', [AuthController::class, 'resetPassword'])->name('password.update');


// Add these routes to your existing web.php file

// Member Dashboard Routes
Route::get('/member/dashboard', [App\Http\Controllers\MemberController::class, 'dashboard'])->name('member.dashboard');
Route::get('/member/annonces', [App\Http\Controllers\MemberController::class, 'mesAnnonces'])->name('member.annonces');
Route::get('/member/annonces/create', [App\Http\Controllers\MemberController::class, 'createAnnonce'])->name('member.annonces.create');
Route::post('/member/annonces/store', [App\Http\Controllers\MemberController::class, 'storeAnnonce'])->name('member.annonces.store');
Route::get('/member/annonces/{id}/edit', [App\Http\Controllers\MemberController::class, 'editAnnonce'])->name('member.annonces.edit');
Route::put('/member/annonces/{id}', [App\Http\Controllers\MemberController::class, 'updateAnnonce'])->name('member.annonces.update');
Route::delete('/member/annonces/{id}', [App\Http\Controllers\MemberController::class, 'deleteAnnonce'])->name('member.annonces.delete');
Route::get('/member/favoris', [App\Http\Controllers\MemberController::class, 'mesFavoris'])->name('member.favoris');
Route::get('/member/parametres', [App\Http\Controllers\MemberController::class, 'parametres'])->name('member.parametres');
Route::post('/member/parametres/update-profile', [App\Http\Controllers\MemberController::class, 'updateProfile'])->name('member.parametres.update-profile');
Route::post('/member/parametres/update-password', [App\Http\Controllers\MemberController::class, 'updatePassword'])->name('member.parametres.update-password');

// Favorite management routes
Route::post('/member/favoris/add/{id}', [App\Http\Controllers\MemberController::class, 'addFavorite'])->name('member.favoris.add');
Route::delete('/member/favoris/remove/{id}', [App\Http\Controllers\MemberController::class, 'removeFavorite'])->name('member.favoris.remove');

//nnnnnnnnnnnnaaaaaaaaaaaaaaaaaaaaaavvvvvvvvvvvvvvvvvvvvbbbbbaaaaaarrrrrrrrre

// Search Routes
Route::get('/search', [App\Http\Controllers\SearchController::class, 'advancedSearch'])->name('search.advanced');
Route::get('/search/nav', [App\Http\Controllers\SearchController::class, 'processNavSearch'])->name('process-nav-search');
Route::get('/search/category/{categoryId}', [SearchController::class, 'searchByCategory'])->name('search.by.category');
Route::get('/search/city/{cityId}', [SearchController::class, 'searchByCity'])->name('search.by.city');

// Report routes
Route::get('/annonces/{id}/report', [App\Http\Controllers\ReportController::class, 'showReportForm'])->name('annonces.report');
Route::post('/annonces/{id}/report', [App\Http\Controllers\ReportController::class, 'storeReport'])->name('annonces.report.store');
// Email Verification Route
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('email.verify');
// Add these routes to your existing web.php file

// Review Routes
Route::get('/annonces/{id}/reviews', [ReviewController::class, 'showAnnonceReviews'])->name('annonces.reviews');
Route::get('/annonces/{id}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/annonces/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Add these to your routes/web.php
