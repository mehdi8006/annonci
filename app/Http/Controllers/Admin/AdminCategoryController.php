<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categorie;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCategoryController extends AdminController
{
    /**
     * Display a listing of the categories and sub-categories
     */
    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $categories = Categorie::with('sousCategories')->get();
        
        return view('admin.categories.index', compact('categories'));
    }
    
    /**
     * Show the form for creating a new category
     */
    public function createCategory()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        return view('admin.categories.create');
    }
    
    /**
     * Store a newly created category in storage
     */
    public function storeCategory(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        Categorie::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }
    
    /**
     * Show the form for editing the specified category
     */
    public function editCategory($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $category = Categorie::findOrFail($id);
        
        return view('admin.categories.edit', compact('category'));
    }
    
    /**
     * Update the specified category in storage
     */
    public function updateCategory(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $category = Categorie::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100|unique:categories,nom,' . $id,
            'description' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $category->nom = $request->nom;
        $category->description = $request->description;
        $category->save();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }
    
    /**
     * Remove the specified category from storage
     */
    public function destroyCategory($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $category = Categorie::findOrFail($id);
        
        // Check if category has any annonces
        if ($category->annonces()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des annonces.');
        }
        
        // Delete all subcategories first
        $category->sousCategories()->delete();
        
        // Then delete the category
        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
    
    /**
     * Show the form for creating a new subcategory
     */
    public function createSubcategory()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $categories = Categorie::all();
        
        return view('admin.categories.create_subcategory', compact('categories'));
    }
    
    /**
     * Store a newly created subcategory in storage
     */
    public function storeSubcategory(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
            'id_categorie' => 'required|exists:categories,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        SousCategorie::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'id_categorie' => $request->id_categorie,
        ]);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Sous-catégorie créée avec succès.');
    }
    
    /**
     * Show the form for editing the specified subcategory
     */
    public function editSubcategory($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $subcategory = SousCategorie::findOrFail($id);
        $categories = Categorie::all();
        
        return view('admin.categories.edit_subcategory', compact('subcategory', 'categories'));
    }
    
    /**
     * Update the specified subcategory in storage
     */
    public function updateSubcategory(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $subcategory = SousCategorie::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
            'id_categorie' => 'required|exists:categories,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $subcategory->nom = $request->nom;
        $subcategory->description = $request->description;
        $subcategory->id_categorie = $request->id_categorie;
        $subcategory->save();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Sous-catégorie mise à jour avec succès.');
    }
    
    /**
     * Remove the specified subcategory from storage
     */
    public function destroySubcategory($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $subcategory = SousCategorie::findOrFail($id);
        
        // Check if subcategory has any annonces
        if ($subcategory->annonces()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Impossible de supprimer une sous-catégorie contenant des annonces.');
        }
        
        $subcategory->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Sous-catégorie supprimée avec succès.');
    }
}