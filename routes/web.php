<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportController;
 

// ============================================================================
// PUBLIC ROUTES - No authentication required
// ============================================================================

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', [HomeController::class, 'homeshow'])->name('homeshow');

Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/details/{id}', [HomeController::class, 'detailshow'])->name('details');

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

// Email Verification Route
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('email.verify');

// Search Routes (Public)
Route::get('/search', [SearchController::class, 'advancedSearch'])->name('search.advanced');
Route::get('/search/nav', [SearchController::class, 'processNavSearch'])->name('process-nav-search');
Route::get('/search/category/{categoryId}', [SearchController::class, 'searchByCategory'])->name('search.by.category');
Route::get('/search/city/{cityId}', [SearchController::class, 'searchByCity'])->name('search.by.city');

// ============================================================================
// AUTHENTICATED USER ROUTES - Require authentication middleware
// ============================================================================
Route::middleware([\App\Http\Middleware\AuthMiddleware::class])->group(function () {
    // Protected detail view for authenticated users
    Route::get('member/details/{id}', [HomeController::class, 'detailmember'])->name('detailsm');
    
    // Favorites Routes
    Route::post('/favorites/add/{id}', [HomeController::class, 'addToFavorites'])->name('favorites.add');
    Route::delete('/favorites/remove/{id}', [HomeController::class, 'removeFromFavorites'])->name('favorites.remove');
    Route::get('/favorites', [HomeController::class, 'showFavorites'])->name('favorites');
    
    // Report Routes
    Route::get('/annonces/{id}/report', [ReportController::class, 'showReportForm'])->name('annonces.report');
    Route::post('/annonces/{id}/report', [ReportController::class, 'storeReport'])->name('annonces.report.store');
    
    // Review Routes
    Route::get('/annonces/{id}/reviews', [ReviewController::class, 'showAnnonceReviews'])->name('annonces.reviews');
    Route::get('/annonces/{id}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/annonces/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Member Dashboard Routes
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\MemberController::class, 'dashboard'])->name('dashboard');
        
        // Announcements Management
        Route::get('/annonces', [App\Http\Controllers\MemberController::class, 'mesAnnonces'])->name('annonces');
        Route::get('/annonces/create', [App\Http\Controllers\MemberController::class, 'createAnnonce'])->name('annonces.create');
        Route::post('/annonces/store', [App\Http\Controllers\MemberController::class, 'storeAnnonce'])->name('annonces.store');
        Route::get('/annonces/{id}/edit', [App\Http\Controllers\MemberController::class, 'editAnnonce'])->name('annonces.edit');
        Route::put('/annonces/{id}', [App\Http\Controllers\MemberController::class, 'updateAnnonce'])->name('annonces.update');
        Route::delete('/annonces/{id}', [App\Http\Controllers\MemberController::class, 'deleteAnnonce'])->name('annonces.delete');
        
        // Favorites Management
        Route::get('/favoris', [App\Http\Controllers\MemberController::class, 'mesFavoris'])->name('favoris');
        Route::post('/favoris/add/{id}', [App\Http\Controllers\MemberController::class, 'addFavorite'])->name('favoris.add');
        Route::delete('/favoris/remove/{id}', [App\Http\Controllers\MemberController::class, 'removeFavorite'])->name('favoris.remove');
        
        // User Settings
        Route::get('/parametres', [App\Http\Controllers\MemberController::class, 'parametres'])->name('parametres');
        Route::post('/parametres/update-profile', [App\Http\Controllers\MemberController::class, 'updateProfile'])->name('parametres.update-profile');
        Route::post('/parametres/update-password', [App\Http\Controllers\MemberController::class, 'updatePassword'])->name('parametres.update-password');
    });
});

// ============================================================================
// ADMIN ROUTES - Require admin middleware
// ============================================================================
Route::prefix('admin')->name('admin.')->middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [App\Http\Controllers\Admin\AdminDashboardController::class, 'getDashboardData'])->name('dashboard.data');
    
    // Quick Actions routes
    Route::post('/dashboard/approve-users', [App\Http\Controllers\Admin\AdminDashboardController::class, 'approveAllPendingUsers'])->name('dashboard.approveUsers');
    Route::post('/dashboard/approve-annonces', [App\Http\Controllers\Admin\AdminDashboardController::class, 'approveAllPendingAnnonces'])->name('dashboard.approveAnnonces');
    Route::post('/dashboard/auto-moderate', [App\Http\Controllers\Admin\AdminDashboardController::class, 'autoModerateReviews'])->name('dashboard.autoModerate');
        
    // Users Management
    Route::post('/users/activate-all-pending', [App\Http\Controllers\Admin\AdminUserController::class, 'activateAllPending'])->name('users.activateAllPending');
    Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
    Route::put('/users/{id}/status-type', [App\Http\Controllers\Admin\AdminUserController::class, 'updateStatusAndType'])->name('users.updateStatusAndType');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/approve', [App\Http\Controllers\Admin\AdminUserController::class, 'approve'])->name('users.approve');
    
    // Annonces Management
    Route::get('/annonces', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/{id}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'show'])->name('annonces.show');
    Route::get('/annonces/{id}/edit', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{id}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'update'])->name('annonces.update');
    Route::put('/annonces/{id}/status', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'updateStatus'])->name('annonces.updateStatus');
    Route::delete('/annonces/{id}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'destroy'])->name('annonces.destroy');
    Route::post('/annonces/{id}/approve', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'approve'])->name('annonces.approve');
     Route::post('/annonces/delete-expired', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'deleteExpiredAnnonces'])->name('annonces.deleteExpired');
    // Bulk and processing routes for annonces
    Route::post('/annonces/activate-all-pending', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'activateAllPending'])->name('annonces.activateAllPending');
    Route::post('/annonces/{id}/process-and-keep', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'processAndKeep'])->name('annonces.processAndKeep');
    Route::post('/annonces/{id}/process-and-delete', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'processAndDelete'])->name('annonces.processAndDelete');
    
    // Catalogue Management
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
    
    // Reviews Management
    Route::get('/reviews', [App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{id}', [App\Http\Controllers\Admin\AdminReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{id}/approve', [App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [App\Http\Controllers\Admin\AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('/reviews/auto-review', [App\Http\Controllers\Admin\AdminReviewController::class, 'autoReview'])->name('reviews.autoReview');
    Route::post('/reviews/ai-check', [App\Http\Controllers\Admin\AdminReviewController::class, 'aiCheckReviews'])->name('reviews.aiCheck');
    Route::delete('/reviews/delete-rejected', [App\Http\Controllers\Admin\AdminReviewController::class, 'deleteAllRejected'])->name('reviews.deleteAllRejected');
    Route::get('/reviews/stats', [App\Http\Controllers\Admin\AdminReviewController::class, 'getStats'])->name('reviews.stats');
// Statistics Management - ADD THESE ROUTES IN THE ADMIN GROUP
    Route::get('/statistics', [App\Http\Controllers\Admin\AdminStatisticController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/export', [App\Http\Controllers\Admin\AdminStatisticController::class, 'exportCsv'])->name('statistics.export');
    Route::get('/statistics/data', [App\Http\Controllers\Admin\AdminStatisticController::class, 'getData'])->name('statistics.data');

});