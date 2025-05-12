<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the annonces by category.
     *
     * @param  int  $categorie
     * @return \Illuminate\Http\Response
     */
    public function byCategorie($categorie)
    {
        $categorieObj = Categorie::findOrFail($categorie);
        
        $annonces = Annonce::where('id_categorie', $categorie)
            ->where('statut', 'validee')
            ->with(['utilisateur', 'ville', 'categorie', 'sousCategorie'])
            ->with(['images' => function($query) {
                $query->where('principale', true)
                      ->orWhere(function($q) {
                          $q->whereIn('id_annonce', function($subquery) {
                              $subquery->select('id_annonce')
                                  ->from('images')
                                  ->groupBy('id_annonce');
                          });
                      })
                      ->orderBy('principale', 'desc')
                      ->take(1);
            }])
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
        
        return view('search.results', [
            'annonces' => $annonces,
            'title' => 'Annonces dans la catégorie: ' . $categorieObj->nom,
            'type' => 'categorie',
            'currentFilter' => $categorieObj->nom,
            'categorieId' => $categorie
        ]);
    }

    /**
     * Display a listing of the annonces by city.
     *
     * @param  int  $ville
     * @return \Illuminate\Http\Response
     */
    public function byVille($ville)
    {
        $villeObj = Ville::findOrFail($ville);
        
        $annonces = Annonce::where('id_ville', $ville)
            ->where('statut', 'validee')
            ->with(['utilisateur', 'ville', 'categorie', 'sousCategorie'])
            ->with(['images' => function($query) {
                $query->where('principale', true)
                      ->orWhere(function($q) {
                          $q->whereIn('id_annonce', function($subquery) {
                              $subquery->select('id_annonce')
                                  ->from('images')
                                  ->groupBy('id_annonce');
                          });
                      })
                      ->orderBy('principale', 'desc')
                      ->take(1);
            }])
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
        
        return view('search.results', [
            'annonces' => $annonces,
            'title' => 'Annonces à ' . $villeObj->nom,
            'type' => 'ville',
            'currentFilter' => $villeObj->nom,
            'villeId' => $ville
        ]);
    }

    /**
     * Search annonces with search parameters
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = Annonce::where('statut', 'validee');
        
        // Keyword search (in title and description)
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keywords = $request->keyword;
            $query->where(function($q) use ($keywords) {
                $q->where('titre', 'like', '%' . $keywords . '%')
                  ->orWhere('description', 'like', '%' . $keywords . '%');
            });
        }
        
        // Category filter
        if ($request->has('categorie') && !empty($request->categorie)) {
            $query->where('id_categorie', $request->categorie);
        }
        
        // Subcategory filter
        if ($request->has('sous_categorie') && !empty($request->sous_categorie)) {
            $query->where('id_sous_categorie', $request->sous_categorie);
        }
        
        // City filter
        if ($request->has('ville') && !empty($request->ville)) {
            $query->where('id_ville', $request->ville);
        }
        
        // Price range filter
        if ($request->has('prix_min') && is_numeric($request->prix_min)) {
            $query->where('prix', '>=', $request->prix_min);
        }
        
        if ($request->has('prix_max') && is_numeric($request->prix_max)) {
            $query->where('prix', '<=', $request->prix_max);
        }
        
        // Sort options
        $sortBy = 'date_publication';
        $sortDir = 'desc';
        
        if ($request->has('tri')) {
            switch ($request->tri) {
                case 'date_asc':
                    $sortBy = 'date_publication';
                    $sortDir = 'asc';
                    break;
                case 'date_desc':
                    $sortBy = 'date_publication';
                    $sortDir = 'desc';
                    break;
                case 'prix_asc':
                    $sortBy = 'prix';
                    $sortDir = 'asc';
                    break;
                case 'prix_desc':
                    $sortBy = 'prix';
                    $sortDir = 'desc';
                    break;
            }
        }
        
        // Build query with relations and order
        $annonces = $query->with(['utilisateur', 'ville', 'categorie', 'sousCategorie'])
            ->with(['images' => function($query) {
                $query->where('principale', true)
                      ->orWhere(function($q) {
                          $q->whereIn('id_annonce', function($subquery) {
                              $subquery->select('id_annonce')
                                  ->from('images')
                                  ->groupBy('id_annonce');
                          });
                      })
                      ->orderBy('principale', 'desc')
                      ->take(1);
            }])
            ->orderBy($sortBy, $sortDir)
            ->paginate(12)
            ->appends($request->all());
        
        // Build page title
        $title = 'Résultats de recherche';
        if ($request->has('keyword') && !empty($request->keyword)) {
            $title .= ' pour "' . $request->keyword . '"';
        }
        
        // Get filter data for the advanced search form
        $categories = Categorie::orderBy('nom')->get();
        $villes = Ville::orderBy('nom')->get();
        
        // Get subcategories if a category is selected
        $sousCategories = [];
        if ($request->has('categorie') && !empty($request->categorie)) {
            $sousCategories = SousCategorie::where('id_categorie', $request->categorie)
                ->orderBy('nom')
                ->get();
        }
        
        return view('search.results', [
            'annonces' => $annonces,
            'title' => $title,
            'type' => 'search',
            'categories' => $categories,
            'villes' => $villes,
            'sousCategories' => $sousCategories,
            'filters' => $request->all()
        ]);
    }
    
    /**
     * Show the advanced search form.
     *
     * @return \Illuminate\Http\Response
     */
    public function advancedSearch()
    {
        $categories = Categorie::orderBy('nom')->get();
        $villes = Ville::orderBy('nom')->get();
        
        return view('search.advanced', [
            'categories' => $categories,
            'villes' => $villes
        ]);
    }
    
    /**
     * Get subcategories for a category (AJAX endpoint).
     *
     * @param  int  $categorieId
     * @return \Illuminate\Http\Response
     */
    public function getSubcategories($categorieId)
    {
        $sousCategories = SousCategorie::where('id_categorie', $categorieId)
            ->orderBy('nom')
            ->get();
            
        return response()->json($sousCategories);
    }
    
    /**
     * Process the search form from the navigation bar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processNavSearch(Request $request)
    {
        // Redirect to the search route with the keyword parameter
        return redirect()->route('search', ['keyword' => $request->search_term]);
    }
}