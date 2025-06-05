<?php

namespace App\Providers;

use App\Services\OpenRouterService;
use Illuminate\Support\ServiceProvider;
use App\Models\Categorie;
use App\Models\Ville;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register OpenRouter Service as singleton
        $this->app->singleton(OpenRouterService::class, function ($app) {
            return new OpenRouterService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap 5 for pagination views
        Paginator::useBootstrapFive();

        // Share villes and categories with all views
        View::composer('*', function ($view) {
            $villes = Ville::orderBy('nom')->get();
            $categories = Categorie::with('sousCategories')->orderBy('nom')->get();
            
            $view->with('navVilles', $villes);
            $view->with('navCategories', $categories);
        });
    }
}
