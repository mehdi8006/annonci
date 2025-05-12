<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Categorie;
use App\Models\Ville;
use Illuminate\Support\Facades\View; // This import is missing

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::composer('*', function ($view) {
            $villes = Ville::orderBy('nom')->get();
            $categories = Categorie::with('sousCategories')->orderBy('nom')->get();
            
            $view->with('navVilles', $villes);
            $view->with('navCategories', $categories);
        });
        //
    }
}