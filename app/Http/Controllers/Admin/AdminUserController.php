<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users
     */
    public function index(Request $request)
    {
        $query = Utilisateur::query();
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephon', 'like', "%{$search}%")
                  ->orWhere('ville', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type_utilisateur', $request->type);
        }
        
        // Apply sorting - Default to recent first (newest to oldest)
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $users = $query->paginate(15);
        
        // Calculate user statistics
        $stats = [
            'total' => Utilisateur::count(),
            'active' => Utilisateur::where('statut', 'valide')->count(),
            'pending' => Utilisateur::where('statut', 'en_attente')->count(),
            'inactive' => Utilisateur::where('statut', 'supprime')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }
    
    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = Utilisateur::findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user status and type
     */
    public function updateStatusAndType(Request $request, $id)
    {
        $user = Utilisateur::findOrFail($id);
        
        // Validate request
        $request->validate([
            'statut' => 'required|in:valide,en_attente,supprime',
            'type_utilisateur' => 'required|in:admin,normal',
        ]);
        
        // Update user
        $user->statut = $request->statut;
        $user->type_utilisateur = $request->type_utilisateur;
        $user->save();
        
        return redirect()->back()->with('success', 'Utilisateur mis à jour avec succès.');
    }
    
    /**
     * Approve a user
     */
    public function approve($id)
    {
        $user = Utilisateur::findOrFail($id);
        $user->statut = 'valide';
        $user->save();
        
        return redirect()->back()->with('success', 'Utilisateur approuvé avec succès.');
    }
    
    /**
     * Activate all pending users
     */
    public function activateAllPending()
    {
        $pendingCount = Utilisateur::where('statut', 'en_attente')->count();
        
        if ($pendingCount > 0) {
            Utilisateur::where('statut', 'en_attente')->update(['statut' => 'valide']);
            return redirect()->back()->with('success', "$pendingCount utilisateur(s) en attente ont été activés avec succès.");
        }
        
        return redirect()->back()->with('info', 'Aucun utilisateur en attente trouvé.');
    }
    
    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = Utilisateur::findOrFail($id);
        
        // Instead of deleting, mark the user as 'supprime'
        $user->statut = 'supprime';
        $user->save();
        
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}