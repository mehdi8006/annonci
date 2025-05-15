<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;

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

// Admin Routes
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
    
    // Annonce Management
    Route::get('/annonces', [App\Http\Controllers\AdminController::class, 'annonces'])->name('admin.annonces');
    Route::get('/annonces/{id}', [App\Http\Controllers\AdminController::class, 'showAnnonce'])->name('admin.annonces.show');
    Route::get('/annonces/{id}/edit', [App\Http\Controllers\AdminController::class, 'editAnnonce'])->name('admin.annonces.edit');
    Route::post('/annonces/{id}', [App\Http\Controllers\AdminController::class, 'updateAnnonce'])->name('admin.annonces.update');
    Route::delete('/annonces/{id}', [App\Http\Controllers\AdminController::class, 'deleteAnnonce'])->name('admin.annonces.delete');
    
    // Category Management
    Route::get('/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [App\Http\Controllers\AdminController::class, 'createCategorie'])->name('admin.categories.create');
    Route::post('/categories', [App\Http\Controllers\AdminController::class, 'storeCategorie'])->name('admin.categories.store');
    Route::get('/categories/{id}/edit', [App\Http\Controllers\AdminController::class, 'editCategorie'])->name('admin.categories.edit');
    Route::post('/categories/{id}', [App\Http\Controllers\AdminController::class, 'updateCategorie'])->name('admin.categories.update');
    
    // Subcategory Management
    Route::get('/sous-categories/{categorieId?}', [App\Http\Controllers\AdminController::class, 'sousCategories'])->name('admin.sous_categories');
    Route::get('/sous-categories/create', [App\Http\Controllers\AdminController::class, 'createSousCategorie'])->name('admin.sous_categories.create');
    Route::post('/sous-categories', [App\Http\Controllers\AdminController::class, 'storeSousCategorie'])->name('admin.sous_categories.store');
    Route::get('/sous-categories/{id}/edit', [App\Http\Controllers\AdminController::class, 'editSousCategorie'])->name('admin.sous_categories.edit');
    Route::post('/sous-categories/{id}', [App\Http\Controllers\AdminController::class, 'updateSousCategorie'])->name('admin.sous_categories.update');
    
    // City Management
    Route::get('/villes', [App\Http\Controllers\AdminController::class, 'villes'])->name('admin.villes');
    Route::get('/villes/create', [App\Http\Controllers\AdminController::class, 'createVille'])->name('admin.villes.create');
    Route::post('/villes', [App\Http\Controllers\AdminController::class, 'storeVille'])->name('admin.villes.store');
    Route::get('/villes/{id}/edit', [App\Http\Controllers\AdminController::class, 'editVille'])->name('admin.villes.edit');
    Route::post('/villes/{id}', [App\Http\Controllers\AdminController::class, 'updateVille'])->name('admin.villes.update');
    
    // Image Management
    Route::get('/images/{annonceId?}', [App\Http\Controllers\AdminController::class, 'images'])->name('admin.images');
    Route::post('/images/{id}/set-main', [App\Http\Controllers\AdminController::class, 'setMainImage'])->name('admin.images.set-main');
    Route::delete('/images/{id}', [App\Http\Controllers\AdminController::class, 'deleteImage'])->name('admin.images.delete');
    
    // Statistics
    Route::get('/statistics', [App\Http\Controllers\AdminController::class, 'statistics'])->name('admin.statistics');
});


// AJAX route for getting subcategories by category ID
Route::get('/admin/get-sous-categories/{categorieId}', function($categorieId) {
    $sousCategories = App\Models\SousCategorie::where('id_categorie', $categorieId)->get();
    return response()->json($sousCategories);
});

// AJAX route for getting subcategories by category ID
Route::get('/admin/get-sous-categories/{categorieId}', [App\Http\Controllers\AdminController::class, 'getSousCategories'])->name('admin.get-sous-categories');


