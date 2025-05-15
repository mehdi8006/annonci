<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Ville;
use App\Models\Image;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Check if user is admin
    private function checkAdmin()
    {
        // Check if user is logged in and is admin
        if (!session()->has('utilisateur') || session('utilisateur.type_utilisateur') !== 'admin') {
            return false;
        }
        return true;
    }

    // Dashboard
    public function dashboard()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        // Get statistics
        $totalUsers = Utilisateur::count();
        $totalAds = Annonce::count();
        $totalCategories = Categorie::count();
        $totalCities = Ville::count();
        
        // Recent ads
        $recentAds = Annonce::with(['utilisateur', 'categorie', 'ville'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        // Recent users
        $recentUsers = Utilisateur::orderBy('created_at', 'desc')
                                  ->take(5)
                                  ->get();
        
        // Ads per category
        $adsPerCategory = Categorie::withCount('annonces')
                                   ->orderBy('annonces_count', 'desc')
                                   ->get();
        
        // Ads per city
        $adsPerCity = Ville::withCount('annonces')
                           ->orderBy('annonces_count', 'desc')
                           ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalAds', 
            'totalCategories', 
            'totalCities', 
            'recentAds', 
            'recentUsers',
            'adsPerCategory',
            'adsPerCity'
        ));
    }

    // User Management
    public function users()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $users = Utilisateur::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function showUser($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $user = Utilisateur::findOrFail($id);
        $userAds = Annonce::where('id_utilisateur', $id)->get();
        $userFavorites = Favorite::where('id_utilisateur', $id)->with('annonce')->get();
        
        return view('admin.users.show', compact('user', 'userAds', 'userFavorites'));
    }

    public function editUser($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $user = Utilisateur::findOrFail($id);
        $cities = Ville::all();
        
        return view('admin.users.edit', compact('user', 'cities'));
    }

    public function updateUser(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:utilisateurs,email,'.$id,
            'telephon' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'type_utilisateur' => 'required|in:admin,normal',
            'statut' => 'required|in:en_attente,valide,supprime',
        ]);

        $user = Utilisateur::findOrFail($id);
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->telephon = $request->telephon;
        $user->ville = $request->ville;
        $user->type_utilisateur = $request->type_utilisateur;
        $user->statut = $request->statut;
        $user->save();

        return redirect()->route('admin.users.show', $id)->with('success', 'Utilisateur mis à jour avec succès');
    }

    

    public function showAnnonce($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $annonce = Annonce::with(['utilisateur', 'categorie', 'sousCategorie', 'ville', 'images'])
                        ->findOrFail($id);
                        
        return view('admin.annonces.show', compact('annonce'));
    }

    public function editAnnonce($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $annonce = Annonce::findOrFail($id);
        $categories = Categorie::all();
        $sousCategories = SousCategorie::where('id_categorie', $annonce->id_categorie)->get();
        $villes = Ville::all();
        $images = Image::where('id_annonce', $id)->get();
        
        return view('admin.annonces.edit', compact('annonce', 'categories', 'sousCategories', 'villes', 'images'));
    }

    public function updateAnnonce(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'id_categorie' => 'required|exists:categories,id',
            'id_sous_categorie' => 'nullable|exists:sous_categories,id',
            'id_ville' => 'required|exists:villes,id',
            'statut' => 'required|in:en_attente,validee,supprimee',
        ]);

        $annonce = Annonce::findOrFail($id);
        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->prix = $request->prix;
        $annonce->id_categorie = $request->id_categorie;
        $annonce->id_sous_categorie = $request->id_sous_categorie;
        $annonce->id_ville = $request->id_ville;
        $annonce->statut = $request->statut;
        $annonce->save();

        return redirect()->route('admin.annonces.show', $id)->with('success', 'Annonce mise à jour avec succès');
    }

    public function deleteAnnonce($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $annonce = Annonce::findOrFail($id);
        $annonce->statut = 'supprimee';
        $annonce->save();

        return redirect()->route('admin.annonces')->with('success', 'Annonce supprimée avec succès');
    }

    // Category Management
    public function categories()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $categories = Categorie::withCount('annonces')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategorie()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        return view('admin.categories.create');
    }

    public function storeCategorie(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        $categorie = new Categorie();
        $categorie->nom = $request->nom;
        $categorie->description = $request->description;
        $categorie->save();

        return redirect()->route('admin.categories')->with('success', 'Catégorie ajoutée avec succès');
    }

    public function editCategorie($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $categorie = Categorie::findOrFail($id);
        return view('admin.categories.edit', compact('categorie'));
    }

    public function updateCategorie(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100|unique:categories,nom,'.$id,
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->nom = $request->nom;
        $categorie->description = $request->description;
        $categorie->save();

        return redirect()->route('admin.categories')->with('success', 'Catégorie mise à jour avec succès');
    }

    // Subcategory Management
    public function sousCategories($categorieId = null)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $query = SousCategorie::with('categorie')->withCount('annonces');
        
        if ($categorieId) {
            $query->where('id_categorie', $categorieId);
        }
        
        $sousCategories = $query->get();
        $categories = Categorie::all();
        
        return view('admin.sous_categories.index', compact('sousCategories', 'categories', 'categorieId'));
    }

    public function createSousCategorie()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $categories = Categorie::all();
        return view('admin.sous_categories.create', compact('categories'));
    }

    public function storeSousCategorie(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100',
            'id_categorie' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $sousCategorie = new SousCategorie();
        $sousCategorie->nom = $request->nom;
        $sousCategorie->id_categorie = $request->id_categorie;
        $sousCategorie->description = $request->description;
        $sousCategorie->save();

        return redirect()->route('admin.sous_categories')->with('success', 'Sous-catégorie ajoutée avec succès');
    }

    public function editSousCategorie($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $sousCategorie = SousCategorie::findOrFail($id);
        $categories = Categorie::all();
        
        return view('admin.sous_categories.edit', compact('sousCategorie', 'categories'));
    }

    public function updateSousCategorie(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100',
            'id_categorie' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $sousCategorie = SousCategorie::findOrFail($id);
        $sousCategorie->nom = $request->nom;
        $sousCategorie->id_categorie = $request->id_categorie;
        $sousCategorie->description = $request->description;
        $sousCategorie->save();

        return redirect()->route('admin.sous_categories')->with('success', 'Sous-catégorie mise à jour avec succès');
    }

    // City Management
    public function villes()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $villes = Ville::withCount('annonces')->get();
        return view('admin.villes.index', compact('villes'));
    }

    public function createVille()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        return view('admin.villes.create');
    }

    public function storeVille(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom',
            'region' => 'nullable|string|max:100',
        ]);

        $ville = new Ville();
        $ville->nom = $request->nom;
        $ville->region = $request->region;
        $ville->save();

        return redirect()->route('admin.villes')->with('success', 'Ville ajoutée avec succès');
    }

    public function editVille($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $ville = Ville::findOrFail($id);
        return view('admin.villes.edit', compact('ville'));
    }

    public function updateVille(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom,'.$id,
            'region' => 'nullable|string|max:100',
        ]);

        $ville = Ville::findOrFail($id);
        $ville->nom = $request->nom;
        $ville->region = $request->region;
        $ville->save();

        return redirect()->route('admin.villes')->with('success', 'Ville mise à jour avec succès');
    }

    // Image Management
    public function images($annonceId = null)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $query = Image::with('annonce');
        
        if ($annonceId) {
            $query->where('id_annonce', $annonceId);
        }
        
        $images = $query->paginate(20);
        
        return view('admin.images.index', compact('images', 'annonceId'));
    }

    public function setMainImage($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $image = Image::findOrFail($id);
        $annonceId = $image->id_annonce;
        
        // Reset all images for this ad
        Image::where('id_annonce', $annonceId)->update(['principale' => false]);
        
        // Set this image as main
        $image->principale = true;
        $image->save();
        
        return redirect()->back()->with('success', 'Image principale définie avec succès');
    }

    public function deleteImage($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        $image = Image::findOrFail($id);
        
        // Check if this is the main image and if there are other images
        if ($image->principale) {
            $otherImage = Image::where('id_annonce', $image->id_annonce)
                              ->where('id', '!=', $id)
                              ->first();
                              
            if ($otherImage) {
                $otherImage->principale = true;
                $otherImage->save();
            }
        }
        
        // Delete the file if it exists
        $filePath = public_path($image->url);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        $image->delete();
        
        return redirect()->back()->with('success', 'Image supprimée avec succès');
    }

    // Reports and Statistics
    public function statistics()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('homeshow')->with('error', 'Accès refusé');
        }

        // Get monthly user registrations for the past year
        $userStats = DB::table('utilisateurs')
            ->select(DB::raw('YEAR(date_inscription) as year, MONTH(date_inscription) as month, COUNT(*) as count'))
            ->whereRaw('date_inscription >= DATE_SUB(NOW(), INTERVAL 12 MONTH)')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Get monthly ad postings for the past year
        $adStats = DB::table('annonces')
            ->select(DB::raw('YEAR(date_publication) as year, MONTH(date_publication) as month, COUNT(*) as count'))
            ->whereRaw('date_publication >= DATE_SUB(NOW(), INTERVAL 12 MONTH)')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Get popular categories
        $popularCategories = Categorie::withCount('annonces')
                                      ->orderBy('annonces_count', 'desc')
                                      ->take(10)
                                      ->get();
                                      
        // Get popular cities
        $popularCities = Ville::withCount('annonces')
                              ->orderBy('annonces_count', 'desc')
                              ->take(10)
                              ->get();
                              
        // Get price ranges
        $priceRanges = [
            '0-100' => Annonce::whereBetween('prix', [0, 100])->count(),
            '101-500' => Annonce::whereBetween('prix', [101, 500])->count(),
            '501-1000' => Annonce::whereBetween('prix', [501, 1000])->count(),
            '1001-5000' => Annonce::whereBetween('prix', [1001, 5000])->count(),
            '5001+' => Annonce::where('prix', '>', 5000)->count(),
        ];
        
        return view('admin.statistics', compact(
            'userStats', 
            'adStats', 
            'popularCategories', 
            'popularCities',
            'priceRanges'
        ));
    }
    
    // Add to the annonces method in the AdminController
public function annonces(Request $request)
{
    if (!$this->checkAdmin()) {
        return redirect()->route('homeshow')->with('error', 'Accès refusé');
    }

    $query = Annonce::with(['utilisateur', 'categorie', 'sousCategorie', 'ville', 'images']);
    
    // Apply filters
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('titre', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }
    
    if ($request->filled('categorie')) {
        $query->where('id_categorie', $request->categorie);
    }
    
    if ($request->filled('ville')) {
        $query->where('id_ville', $request->ville);
    }
    
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }
    
    $annonces = $query->orderBy('created_at', 'desc')->paginate(10);
    
    return view('admin.annonces.index', compact('annonces'));
}
// Add this to the AdminController
public function getSousCategories($categorieId)
{
    if (!$this->checkAdmin()) {
        return response()->json(['error' => 'Accès refusé'], 403);
    }
    
    $sousCategories = SousCategorie::where('id_categorie', $categorieId)->get();
    return response()->json($sousCategories);
}
}