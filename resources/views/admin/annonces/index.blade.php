<!-- resources/views/admin/users/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
    <div class="admin-header">
        <h1>Gestion des utilisateurs</h1>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="search" class="admin-form-label">Recherche</label>
                        <input type="text" id="search" name="search" class="admin-form-input" placeholder="Nom, email, téléphone..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="statut" class="admin-form-label">Statut</label>
                        <select id="statut" name="statut" class="admin-form-select">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>Actif</option>
                            <option value="supprime" {{ request('statut') === 'supprime' ? 'selected' : '' }}>Supprimé</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="type" class="admin-form-label">Type</label>
                        <select id="type" name="type" class="admin-form-select">
                            <option value="">Tous les types</option>
                            <option value="normal" {{ request('type') === 'normal' ? 'selected' : '' }}>Utilisateur normal</option>
                            <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label">&nbsp;</label>
                        <button type="submit" class="admin-button w-100">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Ville</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nom }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->telephon }}</td>
                            <td>{{ $user->ville }}</td>
                            <td>
                                @if($user->type_utilisateur === 'admin')
                                    <span class="admin-badge admin-badge-primary">Admin</span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">Utilisateur</span>
                                @endif
                            </td>
                            <td>
                                @if($user->statut === 'valide')
                                    <span class="admin-badge admin-badge-success">Actif</span>
                                @elseif($user->statut === 'en_attente')
                                    <span class="admin-badge admin-badge-warning">En attente</span>
                                @else
                                    <span class="admin-badge admin-badge-danger">Supprimé</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="admin-button" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                    
                                    @if($user->statut === 'en_attente')
                                        <button type="submit" name="statut" value="valide" class="admin-button admin-button-success" title="Activer l'utilisateur">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @elseif($user->statut === 'valide')
                                        <button type="submit" name="statut" value="supprime" class="admin-button admin-button-danger" title="Désactiver l'utilisateur">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @elseif($user->statut === 'supprime')
                                        <button type="submit" name="statut" value="valide" class="admin-button admin-button-success" title="Réactiver l'utilisateur">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('css')
<style>
    .w-100 {
        width: 100%;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        justify-content: center;
    }
    
    .page-item {
        margin: 0 5px;
    }
    
    .page-link {
        display: block;
        padding: 0.5rem 0.75rem;
        line-height: 1.25;
        color: #3b82f6;
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
        text-decoration: none;
    }
    
    .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #a0aec0;
        pointer-events: none;
        cursor: auto;
    }
</style>
@endsection