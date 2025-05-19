<?php

namespace App\Http\Controllers\Admin;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends AdminController
{
    /**
     * Display a listing of the users
     */
    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $query = Utilisateur::query();
        
        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephon', 'like', "%{$search}%")
                  ->orWhere('ville', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter
        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }
        
        // Apply type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type_utilisateur', $request->type);
        }
        
        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $users = $query->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $user = Utilisateur::findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update the specified user in storage
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $user = Utilisateur::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:utilisateurs,email,' . $id,
            'telephon' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'statut' => 'required|in:en_attente,valide,supprime',
            'type_utilisateur' => 'required|in:admin,normal',
            'password' => 'nullable|min:8',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->telephon = $request->telephon;
        $user->ville = $request->ville;
        $user->statut = $request->statut;
        $user->type_utilisateur = $request->type_utilisateur;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }
    
    /**
     * Remove the specified user from storage (soft delete)
     */
    public function destroy($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $user = Utilisateur::findOrFail($id);
        
        // Don't allow deleting the last admin
        if ($user->type_utilisateur === 'admin') {
            $adminCount = Utilisateur::where('type_utilisateur', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Impossible de supprimer le dernier administrateur.');
            }
        }
        
        // Instead of deleting, mark as deleted
        $user->statut = 'supprime';
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
    
    /**
     * Approve a pending user
     */
    public function approve($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $user = Utilisateur::findOrFail($id);
        
        if ($user->statut !== 'en_attente') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cet utilisateur n\'est pas en attente d\'approbation.');
        }
        
        $user->statut = 'valide';
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur approuvé avec succès.');
    }
}