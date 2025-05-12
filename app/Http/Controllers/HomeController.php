<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\Categorie;


use Illuminate\Http\Request;

class HomeController extends Controller
{
  
    public function homeshow(){
    // Annonces récentes
    $recentAds = Annonce::orderBy('date_publication', 'desc')
        ->with(['images', 'utilisateur', 'ville'])
        ->take(10)
        ->get();

    // 4 catégories aléatoires
    $randCategories = Categorie::inRandomOrder()->take(4)->get();

    // Annonces par catégorie
    $categoryAds = [];
    foreach ($randCategories as $category) {
        $ads = Annonce::where('id_categorie', $category->id)
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
    $detailsAds = Annonce::where('id', $id)
    ->with(['images','categorie','utilisateur','ville','souscategorie'])
    ->get();
    foreach($detailsAds as $ad){
        $userAds = Annonce::where('id_utilisateur', $ad->id_utilisateur)
        ->with(['images','utilisateur','ville',])
        ->take(10)
        ->get();   
    }
    return view( 'detail',compact('userAds','detailsAds'));
}

    
    
}
