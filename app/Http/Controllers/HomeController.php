<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Favorite;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homeshow(){
        // Annonces récentes
        $recentAds = Annonce::where('statut','validee')
            ->orderBy('date_publication', 'desc')
            ->with(['images', 'utilisateur', 'ville','categorie'])
            ->take(10)
            ->get();

        // 4 catégories aléatoires
        $randCategories = Categorie::inRandomOrder()->take(4)->get();

        // Annonces par catégorie
        $categoryAds = [];
        foreach ($randCategories as $category) {
            $ads = Annonce::where('statut','validee')
                ->where('id_categorie', $category->id)
                ->with(['images', 'utilisateur', 'ville', 'categorie'])
                ->take(10)
                ->get();

            $categoryAds[$category->id] = [
                'category' => $category,
                'ads' => $ads
            ];
        }
        $add='1';
        // Envoyer les données à la vue
        return view('home', compact('recentAds', 'add','categoryAds'));
    }

    public function detailshow($id){
        $detailsAds = Annonce::where('statut','validee')
            ->where('id', $id)
            ->with(['images','categorie','utilisateur','ville','souscategorie'])
            ->get();
            
        foreach($detailsAds as $ad){
            $userAds = Annonce::where('statut','validee')
                ->where('id_utilisateur', $ad->id_utilisateur)
                ->with(['images','utilisateur','ville',])
                ->get();   
        }
        
        $isFavorite = false;
        // Check if user is logged in using session
        if (Session::has('user_id')) {
            $userId = Session::get('user_id');
            $isFavorite = Favorite::where('id_utilisateur', $userId)
                ->where('id_annonce', $id)
                ->exists();
        }
        $page='show';
        $add='0';
        return view('detail', compact('isFavorite','add','userAds','detailsAds','page'));
    }
    
    public function detailmember($id){
        $detailsAds = Annonce::where('id', $id)
            ->with(['images','categorie','ville','souscategorie'])
            ->get();
            
        $isFavorite = false;
        // Check if user is logged in using session
        if (Session::has('user_id')) {
            $userId = Session::get('user_id');
            $isFavorite = Favorite::where('id_utilisateur', $userId)
                ->where('id_annonce', $id)
                ->exists();
        }
        $page='member';
        
        return view('detail', compact('isFavorite','detailsAds','page'));
    }

    /**
     * Ajouter une annonce aux favoris
     * Note: This method is now protected by middleware, so we know user is authenticated
     */
    public function addToFavorites($id)
    {
        $userId = Session::get('user_id');
        
        // Vérifier si l'annonce existe
        $annonce = Annonce::find($id);
        if (!$annonce) {
            return back()->with('error', 'Annonce non trouvée');
        }

        // Vérifier si l'annonce est déjà dans les favoris
        $existingFavorite = Favorite::where('id_utilisateur', $userId)
            ->where('id_annonce', $id)
            ->first();

        if ($existingFavorite) {
            return back()->with('info', 'Cette annonce est déjà dans vos favoris');
        }

        // Ajouter aux favoris
        Favorite::create([
            'id_utilisateur' => $userId,
            'id_annonce' => $id
        ]);

        return back()->with('success', 'Annonce ajoutée aux favoris');
    }

    /**
     * Supprimer une annonce des favoris
     * Note: This method is now protected by middleware, so we know user is authenticated
     */
    public function removeFromFavorites($id)
    {
        $userId = Session::get('user_id');
        
        // Trouver et supprimer le favori
        $favorite = Favorite::where('id_utilisateur', $userId)
            ->where('id_annonce', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Annonce retirée des favoris');
        }

        return back()->with('info', 'Cette annonce n\'est pas dans vos favoris');
    }
    
    /**
     * Afficher tous les favoris de l'utilisateur connecté
     * Note: This method is now protected by middleware, so we know user is authenticated
     */
    public function showFavorites()
    {
        $userId = Session::get('user_id');
        
        // Récupérer tous les favoris de l'utilisateur avec les détails des annonces
        $favorites = Favorite::where('id_utilisateur', $userId)
            ->with(['annonce.images', 'annonce.utilisateur', 'annonce.ville'])
            ->get();

        return view('favorites', compact('favorites'));
    }
}