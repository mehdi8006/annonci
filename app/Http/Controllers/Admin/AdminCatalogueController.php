<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Ville;
use Illuminate\Http\Request;

class AdminCatalogueController extends Controller
{
    /**
     * Display the catalog management index page.
     */
    public function index()
    {
        // Get categories with their announcement count
        $categories = Categorie::withCount('annonces')
            ->orderBy('nom')
            ->get();

        // Get cities with their announcement count
        $villes = Ville::withCount('annonces')
            ->orderBy('nom')
            ->get();

        return view('admin.catalogues.index', compact('categories', 'villes'));
    }

    /**
     * Show category details with subcategories.
     */
    public function showCategory($id)
    {
        $categorie = Categorie::with('sousCategories')->findOrFail($id);
        return view('admin.catalogues.category-details', compact('categorie'));
    }

    /**
     * Show the form to create a new category.
     */
    public function createCategory()
    {
        return view('admin.catalogues.create-category');
    }

    /**
     * Store a newly created category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);

        Categorie::create($request->all());

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Show the form to edit a category.
     */
    public function editCategory($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('admin.catalogues.edit-category', compact('categorie'));
    }

    /**
     * Update the specified category.
     */
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:categories,nom,'.$id,
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->all());

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Delete the specified category.
     */
    public function destroyCategory($id)
    {
        $categorie = Categorie::findOrFail($id);
        
        // Check if category has announcements
        if ($categorie->annonces()->count() > 0) {
            return redirect()->route('admin.catalogues.index')
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des annonces.');
        }
        
        // Delete related subcategories first
        $categorie->sousCategories()->delete();
        
        // Delete the category
        $categorie->delete();

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * Show the form to create a new subcategory.
     */
    public function createSubcategory($categoryId)
    {
        $categorie = Categorie::findOrFail($categoryId);
        return view('admin.catalogues.create-subcategory', compact('categorie'));
    }

    /**
     * Store a newly created subcategory.
     */
    public function storeSubcategory(Request $request, $categoryId)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::findOrFail($categoryId);
        
        $sousCategorie = new SousCategorie();
        $sousCategorie->nom = $request->nom;
        $sousCategorie->description = $request->description;
        $sousCategorie->id_categorie = $categorie->id;
        $sousCategorie->save();

        return redirect()->route('admin.categories.show', $categorie->id)
            ->with('success', 'Sous-catégorie créée avec succès.');
    }

    /**
     * Show the form to edit a subcategory.
     */
    public function editSubcategory($id)
    {
        $sousCategorie = SousCategorie::with('categorie')->findOrFail($id);
        return view('admin.catalogues.edit-subcategory', compact('sousCategorie'));
    }

    /**
     * Update the specified subcategory.
     */
    public function updateSubcategory(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $sousCategorie = SousCategorie::findOrFail($id);
        $sousCategorie->update($request->all());

        return redirect()->route('admin.categories.show', $sousCategorie->id_categorie)
            ->with('success', 'Sous-catégorie mise à jour avec succès.');
    }

    /**
     * Delete the specified subcategory.
     */
    public function destroySubcategory($id)
    {
        $sousCategorie = SousCategorie::findOrFail($id);
        $categoryId = $sousCategorie->id_categorie;
        
        // Check if subcategory has announcements
        if ($sousCategorie->annonces()->count() > 0) {
            return redirect()->route('admin.categories.show', $categoryId)
                ->with('error', 'Impossible de supprimer cette sous-catégorie car elle contient des annonces.');
        }
        
        $sousCategorie->delete();

        return redirect()->route('admin.categories.show', $categoryId)
            ->with('success', 'Sous-catégorie supprimée avec succès.');
    }

    /**
     * Show city details.
     */
    public function showCity($id)
    {
        $ville = Ville::findOrFail($id);
        return view('admin.catalogues.city-details', compact('ville'));
    }

    /**
     * Show the form to create a new city.
     */
    public function createCity()
    {
        return view('admin.catalogues.create-city');
    }

    /**
     * Store a newly created city.
     */
    public function storeCity(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:villes',
            'region' => 'nullable|string|max:100',
        ]);

        Ville::create($request->all());

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Ville créée avec succès.');
    }

    /**
     * Show the form to edit a city.
     */
    public function editCity($id)
    {
        $ville = Ville::findOrFail($id);
        return view('admin.catalogues.edit-city', compact('ville'));
    }

    /**
     * Update the specified city.
     */
    public function updateCity(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom,'.$id,
            'region' => 'nullable|string|max:100',
        ]);

        $ville = Ville::findOrFail($id);
        $ville->update($request->all());

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Ville mise à jour avec succès.');
    }

    /**
     * Delete the specified city.
     */
    public function destroyCity($id)
    {
        $ville = Ville::findOrFail($id);
        
        // Check if city has announcements
        if ($ville->annonces()->count() > 0) {
            return redirect()->route('admin.catalogues.index')
                ->with('error', 'Impossible de supprimer cette ville car elle contient des annonces.');
        }
        
        $ville->delete();

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Ville supprimée avec succès.');
    }
}
