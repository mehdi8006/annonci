<?php

namespace App\Http\Controllers\Admin;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminAnnonceController extends AdminController
{
    /**
     * Display a listing of the announcements
     */
    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $query = Annonce::with(['utilisateur', 'categorie', 'ville', 'sousCategorie']);
        
        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter
        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }
        
        // Apply category filter
        if ($request->has('categorie') && $request->categorie != '') {
            $query->where('id_categorie', $request->categorie);
        }
        
        // Apply price range filter
        if ($request->has('prix_min') && $request->prix_min != '') {
            $query->where('prix', '>=', $request->prix_min);
        }
        
        if ($request->has('prix_max') && $request->prix_max != '') {
            $query->where('prix', '<=', $request->prix_max);
        }
        
        // Apply date range filter
        if ($request->has('date_debut') && $request->date_debut != '') {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && $request->date_fin != '') {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $annonces = $query->paginate(15);
        
        // Get all categories and cities for the filters
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('admin.annonces.index', compact('annonces', 'categories', 'villes'));
    }
    
    /**
     * Show details of an announcement
     */
    public function show($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $annonce = Annonce::with([
            'utilisateur', 
            'categorie', 
            'sousCategorie', 
            'ville', 
            'images',
            'reports'
        ])->findOrFail($id);
        
        return view('admin.annonces.show', compact('annonce'));
    }
    
    /**
     * Show the form for editing the specified annonce
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $annonce = Annonce::with(['images'])->findOrFail($id);
        $categories = Categorie::all();
        $sousCategories = SousCategorie::all();
        $villes = Ville::all();
        
        return view('admin.annonces.edit', compact('annonce', 'categories', 'sousCategories', 'villes'));
    }
    
    /**
     * Update the specified annonce in storage
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $annonce = Annonce::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'statut' => 'required|in:en_attente,validee,supprimee',
            'id_categorie' => 'required|exists:categories,id',
            'id_sous_categorie' => 'nullable|exists:sous_categories,id',
            'id_ville' => 'required|exists:villes,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->prix = $request->prix;
        $annonce->statut = $request->statut;
        $annonce->id_categorie = $request->id_categorie;
        $annonce->id_sous_categorie = $request->id_sous_categorie;
        $annonce->id_ville = $request->id_ville;
        $annonce->save();
        
        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce mise à jour avec succès.');
    }
    
    /**
     * Mark the announcement as deleted
     */
    public function destroy($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $annonce = Annonce::findOrFail($id);
        $annonce->statut = 'supprimee';
        $annonce->save();
        
        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
    
    /**
     * Approve a pending announcement
     */
    public function approve($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $annonce = Annonce::findOrFail($id);
        
        if ($annonce->statut !== 'en_attente') {
            return redirect()->route('admin.annonces.index')
                ->with('error', 'Cette annonce n\'est pas en attente d\'approbation.');
        }
        
        $annonce->statut = 'validee';
        $annonce->save();
        
        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce approuvée avec succès.');
    }
}