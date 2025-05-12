<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Utilisateur;
use App\Models\Ville;
use App\Models\Favorite;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Check if user is authenticated
     */
    private function checkAuth()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('form')->withErrors(['auth' => 'Vous devez être connecté pour accéder à cette page.']);
        }
        return null;
    }

    /**
     * Show member dashboard
     */
    public function dashboard()
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        
        // Get statistics for dashboard
        $totalAnnonces = Annonce::where('id_utilisateur', $userId)->count();
        $annoncesEnAttente = Annonce::where('id_utilisateur', $userId)->where('statut', 'en_attente')->count();
        $annoncesValidees = Annonce::where('id_utilisateur', $userId)->where('statut', 'validee')->count();
        $annoncesSupprimees = Annonce::where('id_utilisateur', $userId)->where('statut', 'supprimee')->count();
        $totalFavoris = Favorite::where('id_utilisateur', $userId)->count();
        
        // Recent announcements
        $recentAnnonces = Annonce::where('id_utilisateur', $userId)
            ->with(['images', 'categorie', 'ville'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $activePage = 'dashboard';
        
        return view('member.dashboard', compact(
            'totalAnnonces', 
            'annoncesEnAttente', 
            'annoncesValidees', 
            'annoncesSupprimees',
            'totalFavoris',
            'recentAnnonces',
            'activePage'
        ));
    }

    /**
     * Show user's announcements
     */
    public function mesAnnonces()
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        
        $annonces = Annonce::where('id_utilisateur', $userId)
            ->with(['images', 'categorie', 'ville'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $activePage = 'annonces';
        
        return view('member.mesannonces', compact('annonces', 'activePage'));
    }

    /**
     * Show create announcement form
     */
    public function createAnnonce()
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $categories = Categorie::all();
        $sousCategories = SousCategorie::all();
        $villes = Ville::all();
        $activePage = 'ajouter';
        
        return view('member.ajouterannonce', compact('categories', 'sousCategories', 'villes', 'activePage'));
    }

    /**
     * Store new announcement
     */
    public function storeAnnonce(Request $request)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'id_ville' => 'required|exists:villes,id',
            'id_categorie' => 'required|exists:categories,id',
            'id_sous_categorie' => 'nullable|exists:sous_categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create announcement
        $annonce = new Annonce();
        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->prix = $request->prix;
        $annonce->id_utilisateur = session('user_id');
        $annonce->id_ville = $request->id_ville;
        $annonce->id_categorie = $request->id_categorie;
        $annonce->id_sous_categorie = $request->id_sous_categorie;
        $annonce->statut = 'en_attente';
        $annonce->save();

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $imagePath = $imageFile->store('annonces', 'public');
                
                $image = new Image();
                $image->id_annonce = $annonce->id;
                $image->url = $imagePath;
                $image->principale = ($index === 0); // First image is primary
                $image->save();
            }
        }

        return redirect()->route('member.annonces')->with('success', 'Annonce créée avec succès!');
    }

    /**
     * Show edit form for announcement
     */
    public function editAnnonce($id)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $annonce = Annonce::where('id', $id)
            ->where('id_utilisateur', session('user_id'))
            ->with('images')
            ->first();

        if (!$annonce) {
            return redirect()->route('member.annonces')->withErrors(['annonce' => 'Annonce non trouvée']);
        }

        $categories = Categorie::all();
        $sousCategories = SousCategorie::all();
        $villes = Ville::all();
        $activePage = 'annonces';

        return view('member.editannonce', compact('annonce', 'categories', 'sousCategories', 'villes', 'activePage'));
    }

    /**
     * Update announcement
     */
    public function updateAnnonce(Request $request, $id)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $annonce = Annonce::where('id', $id)
            ->where('id_utilisateur', session('user_id'))
            ->first();

        if (!$annonce) {
            return redirect()->route('member.annonces')->withErrors(['annonce' => 'Annonce non trouvée']);
        }

        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'id_ville' => 'required|exists:villes,id',
            'id_categorie' => 'required|exists:categories,id',
            'id_sous_categorie' => 'nullable|exists:sous_categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->prix = $request->prix;
        $annonce->id_ville = $request->id_ville;
        $annonce->id_categorie = $request->id_categorie;
        $annonce->id_sous_categorie = $request->id_sous_categorie;
        $annonce->save();

        return redirect()->route('member.annonces')->with('success', 'Annonce modifiée avec succès!');
    }

    /**
     * Delete announcement
     */
    public function deleteAnnonce($id)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $annonce = Annonce::where('id', $id)
            ->where('id_utilisateur', session('user_id'))
            ->first();

        if (!$annonce) {
            return redirect()->route('member.annonces')->withErrors(['annonce' => 'Annonce non trouvée']);
        }

        // Delete associated images
        foreach ($annonce->images as $image) {
            \Storage::disk('public')->delete($image->url);
            $image->delete();
        }

        $annonce->delete();

        return redirect()->route('member.annonces')->with('success', 'Annonce supprimée avec succès!');
    }

    /**
     * Show user's favorites
     */
    public function mesFavoris()
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        
        $favoris = Favorite::where('id_utilisateur', $userId)
            ->with(['annonce' => function($query) {
                $query->with(['images', 'categorie', 'ville']);
            }])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $activePage = 'favoris';
        
        return view('member.mesfavoris', compact('favoris', 'activePage'));
    }

    /**
     * Add to favorites
     */
    public function addFavorite($id)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        
        // Check if already in favorites
        $existing = Favorite::where('id_utilisateur', $userId)
            ->where('id_annonce', $id)
            ->first();
            
        if ($existing) {
            return redirect()->back()->withErrors(['favorite' => 'Cette annonce est déjà dans vos favoris']);
        }

        $favorite = new Favorite();
        $favorite->id_utilisateur = $userId;
        $favorite->id_annonce = $id;
        $favorite->save();

        return redirect()->back()->with('success', 'Annonce ajoutée aux favoris');
    }

    /**
     * Remove from favorites
     */
    public function removeFavorite($id)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $favorite = Favorite::where('id_utilisateur', session('user_id'))
            ->where('id_annonce', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return redirect()->back()->with('success', 'Annonce retirée des favoris');
    }

    /**
     * Show settings page
     */
    public function parametres()
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        $user = Utilisateur::find($userId);
        
        if (!$user) {
            return redirect()->route('form')->withErrors(['user' => 'Utilisateur non trouvé']);
        }
        
        $activePage = 'parametres';
        
        return view('member.parametres', compact('user', 'activePage'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        $user = Utilisateur::find($userId);

        if (!$user) {
            return redirect()->route('member.parametres')->withErrors(['user' => 'Utilisateur non trouvé']);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'telephon' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->nom = $request->nom;
        $user->telephon = $request->telephon;
        $user->ville = $request->ville;
        $user->save();

        // Update session data
        session(['user_name' => $user->nom]);

        return redirect()->route('member.parametres')->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        if ($authCheck = $this->checkAuth()) return $authCheck;

        $userId = session('user_id');
        $user = Utilisateur::find($userId);

        if (!$user) {
            return redirect()->route('member.parametres')->withErrors(['user' => 'Utilisateur non trouvé']);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('member.parametres')->with('success', 'Mot de passe mis à jour avec succès');
    }
}