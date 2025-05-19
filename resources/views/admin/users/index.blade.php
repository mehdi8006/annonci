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
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="admin-button">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($user->statut === 'en_attente')
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="admin-button admin-button-success" onclick="return confirm('Êtes-vous sûr de vouloir approuver cet utilisateur ?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($user->statut !== 'supprime')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-button admin-button-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
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