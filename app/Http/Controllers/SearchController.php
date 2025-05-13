<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Ville;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Process search from navigation bar
     */
    public function processNavSearch(Request $request)
    {
        $searchTerm = $request->input('search_term');
        
        // If search term is empty, redirect back
        if (!$searchTerm) {
            return redirect()->back();
        }
        
        $annonces = Annonce::where('titre', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->where('statut', 'validee')
            ->with(['utilisateur', 'ville', 'categorie', 'sousCategorie', 'images'])
            ->paginate(8);
            
        // Get categories and cities for filter component
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('search.results', compact('annonces', 'categories', 'villes', 'searchTerm'));
    }
    
    /**
     * Process advanced search with filters
     */
    public function advancedSearch(Request $request)
    {
        // Get all filter parameters
        $keywords = $request->input('keywords');
        $villeId = $request->input('ville');
        $categorieId = $request->input('categorie');
        $sousCategorieId = $request->input('sous_categorie');
        $prixMin = $request->input('prix_min');
        $prixMax = $request->input('prix_max');
        $sort = $request->input('sort');
        
        // Start query
        $query = Annonce::query();
        
        // Apply filters
        if ($keywords) {
            $query->where(function($q) use ($keywords) {
                $q->where('titre', 'like', "%{$keywords}%")
                  ->orWhere('description', 'like', "%{$keywords}%");
            });
        }
        
        if ($villeId) {
            $query->where('id_ville', $villeId);
        }
        
        if ($categorieId) {
            $query->where('id_categorie', $categorieId);
        }
        
        if ($sousCategorieId) {
            $query->where('id_sous_categorie', $sousCategorieId);
        }
        
        if ($prixMin) {
            $query->where('prix', '>=', $prixMin);
        }
        
        if ($prixMax) {
            $query->where('prix', '<=', $prixMax);
        }
        
        // Only show validated announcements
        $query->where('statut', 'validee');
        
        // Apply sorting
        if ($sort) {
            switch ($sort) {
                case 'recent':
                    $query->orderBy('date_publication', 'desc');
                    break;
                case 'cher':
                    $query->orderBy('prix', 'desc');
                    break;
                case 'moins_cher':
                    $query->orderBy('prix', 'asc');
                    break;
                default:
                    $query->orderBy('date_publication', 'desc');
            }
        } else {
            // Default sort by most recent
            $query->orderBy('date_publication', 'desc');
        }
        
        // Get related data
        $query->with(['utilisateur', 'ville', 'categorie', 'sousCategorie', 'images']);
        
        // Paginate results
        $annonces = $query->paginate(8);
        
        // Get categories and cities for filter component
        $categories = Categorie::all();
        $villes = Ville::all();
        
        // Get sous-categories if categorie is selected
        $sousCategories = [];
        if ($categorieId) {
            $sousCategories = SousCategorie::where('id_categorie', $categorieId)->get();
        }
        
        // Pass all search parameters back to the view to maintain filter state
        $searchParams = $request->all();
        
        return view('search.results', compact(
            'annonces', 
            'categories', 
            'villes', 
            'sousCategories',
            'searchParams'
        ));
    }
}