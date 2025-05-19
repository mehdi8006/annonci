<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Categorie;
use Illuminate\Http\Request;

class AdminAnnonceController extends Controller
{
    /**
     * Display a listing of the annonces
     */
    public function index(Request $request)
    {
        $query = Annonce::with(['categorie', 'sousCategorie', 'utilisateur', 'ville', 'images', 'reports', 'reviews']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        // Apply category filter
        if ($request->filled('categorie')) {
            $query->where('id_categorie', $request->categorie);
        }
        
        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $annonces = $query->paginate(15);
        $categories = Categorie::all();
        
        return view('admin.annonces.index', compact('annonces', 'categories'));
    }
    
    /**
     * Display the specified annonce
     */
    public function show($id)
    {
        $annonce = Annonce::with([
            'categorie', 
            'sousCategorie', 
            'utilisateur', 
            'ville', 
            'images', 
            'reports.utilisateur', 
            'reviews.utilisateur'
        ])->findOrFail($id);
        
        return view('admin.annonces.show', compact('annonce'));
    }

    /**
     * Update annonce status
     */
    public function updateStatus(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        // Validate request
        $request->validate([
            'statut' => 'required|in:validee,en_attente,supprimee',
        ]);
        
        // Update annonce
        $annonce->statut = $request->statut;
        $annonce->save();
        
        return redirect()->back()->with('success', 'Statut de l\'annonce mis à jour avec succès.');
    }
    
    /**
     * Approve an annonce
     */
    public function approve($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->statut = 'validee';
        $annonce->save();
        
        return redirect()->back()->with('success', 'Annonce approuvée avec succès.');
    }
    
    /**
     * Remove the specified annonce
     */
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        
        // Instead of deleting, mark the annonce as 'supprimee'
        $annonce->statut = 'supprimee';
        $annonce->save();
        
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce supprimée avec succès.');
    }
}