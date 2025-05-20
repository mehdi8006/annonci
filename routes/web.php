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

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
       // Users
    Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
    Route::put('/users/{id}/status-type', [App\Http\Controllers\Admin\AdminUserController::class, 'updateStatusAndType'])->name('users.updateStatusAndType');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/approve', [App\Http\Controllers\Admin\AdminUserController::class, 'approve'])->name('users.approve');
    
  // Annonces
    Route::get('/annonces', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/{id}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'show'])->name('annonces.show');
    Route::get('/annonces/{id}/edit', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{id}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'update'])->name('annonces.update');
    Route::put('/annonces/{id}/status', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'updateStatus'])->name('annonces.updateStatus');
    Route::delete('/annonces/{id}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'destroy'])->name('annonces.destroy');
    Route::post('/annonces/{id}/approve', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'approve'])->name('annonces.approve');
    // Catalogue management
Route::get('/catalogues', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'index'])->name('catalogues.index');

// Categories routes
Route::get('/categories/create', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'createCategory'])->name('categories.create');
Route::post('/categories', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'storeCategory'])->name('categories.store');
Route::get('/categories/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'showCategory'])->name('categories.show');
Route::get('/categories/{id}/edit', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'editCategory'])->name('categories.edit');
Route::put('/categories/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'updateCategory'])->name('categories.update');
Route::delete('/categories/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'destroyCategory'])->name('categories.destroy');

// Subcategories routes
Route::get('/categories/{id}/subcategories/create', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'createSubcategory'])->name('subcategories.create');
Route::post('/categories/{id}/subcategories', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'storeSubcategory'])->name('subcategories.store');
Route::get('/subcategories/{id}/edit', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'editSubcategory'])->name('subcategories.edit');
Route::put('/subcategories/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'updateSubcategory'])->name('subcategories.update');
Route::delete('/subcategories/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'destroySubcategory'])->name('subcategories.destroy');

// Cities routes
Route::get('/cities/create', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'createCity'])->name('cities.create');
Route::post('/cities', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'storeCity'])->name('cities.store');
Route::get('/cities/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'showCity'])->name('cities.show');
Route::get('/cities/{id}/edit', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'editCity'])->name('cities.edit');
Route::put('/cities/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'updateCity'])->name('cities.update');
Route::delete('/cities/{id}', [App\Http\Controllers\Admin\AdminCatalogueController::class, 'destroyCity'])->name('cities.destroy');
    
   
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}', [App\Http\Controllers\Admin\AdminReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{id}/handle', [App\Http\Controllers\Admin\AdminReportController::class, 'markAsHandled'])->name('reports.handle');
    
    // Reviews
    Route::get('/reviews', [App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{id}', [App\Http\Controllers\Admin\AdminReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{id}/approve', [App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [App\Http\Controllers\Admin\AdminReviewController::class, 'reject'])->name('reviews.reject');
});