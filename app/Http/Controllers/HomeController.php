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
            ->with(['images', 'utilisateur', 'ville'])
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

        // Envoyer les données à la vue
        return view('home', compact('recentAds', 'categoryAds'));
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
                ->take(10)
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
        
        return view('detail', compact('isFavorite','userAds','detailsAds'));
    }

    /**
     * Ajouter une annonce aux favoris
     */
    public function addToFavorites($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::has('user_id')) {
            return redirect()->route('form')->with('error', 'Veuillez vous connecter pour ajouter des favoris');
        }

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
     */
    public function removeFromFavorites($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::has('user_id')) {
            return redirect()->route('form')->with('error', 'Veuillez vous connecter pour gérer vos favoris');
        }

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
     */
    public function showFavorites()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::has('user_id')) {
            return redirect()->route('form')->with('error', 'Veuillez vous connecter pour voir vos favoris');
        }

        $userId = Session::get('user_id');
        
        // Récupérer tous les favoris de l'utilisateur avec les détails des annonces
        $favorites = Favorite::where('id_utilisateur', $userId)
            ->with(['annonce.images', 'annonce.utilisateur', 'annonce.ville'])
            ->get();

        return view('favorites', compact('favorites'));
    }
}