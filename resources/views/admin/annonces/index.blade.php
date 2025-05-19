<!-- resources/views/admin/annonces/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion des annonces')

@section('content')
    <div class="admin-header">
        <h1>Gestion des annonces</h1>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.annonces.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="search" class="admin-form-label">Recherche</label>
                        <input type="text" id="search" name="search" class="admin-form-input" placeholder="Titre, description..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="statut" class="admin-form-label">Statut</label>
                        <select id="statut" name="statut" class="admin-form-select">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="validee" {{ request('statut') === 'validee' ? 'selected' : '' }}>Validée</option>
                            <option value="supprimee" {{ request('statut') === 'supprimee' ? 'selected' : '' }}>Supprimée</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="categorie" class="admin-form-label">Catégorie</label>
                        <select id="categorie" name="categorie" class="admin-form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="prix_min" class="admin-form-label">Prix minimum (DH)</label>
                        <input type="number" id="prix_min" name="prix_min" class="admin-form-input" placeholder="Prix min" value="{{ request('prix_min') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="prix_max" class="admin-form-label">Prix maximum (DH)</label>
                        <input type="number" id="prix_max" name="prix_max" class="admin-form-input" placeholder="Prix max" value="{{ request('prix_max') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="date_debut" class="admin-form-label">Date début</label>
                        <input type="date" id="date_debut" name="date_debut" class="admin-form-input" value="{{ request('date_debut') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="date_fin" class="admin-form-label">Date fin</label>
                        <input type="date" id="date_fin" name="date_fin" class="admin-form-input" value="{{ request('date_fin') }}">
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="admin-button">
                    <i class="fas fa-search"></i> Filtrer
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Utilisateur</th>
                        <th>Ville</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annonces as $annonce)
                        <tr>
                            <td>{{ $annonce->id }}</td>
                            <td>{{ Str::limit($annonce->titre, 50) }}</td>
                            <td>{{ number_format($annonce->prix, 2, ',', ' ') }} DH</td>
                            <td>{{ $annonce->categorie->nom ?? 'N/A' }}</td>
                            <td>{{ $annonce->utilisateur->nom }}</td>
                            <td>{{ $annonce->ville->nom }}</td>
                            <td>
                                @if($annonce->statut === 'validee')
                                    <span class="admin-badge admin-badge-success">Validée</span>
                                @elseif($annonce->statut === 'en_attente')
                                    <span class="admin-badge admin-badge-warning">En attente</span>
                                @else
                                    <span class="admin-badge admin-badge-danger">Supprimée</span>
                                @endif
                            </td>
                            <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="admin-button">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('admin.annonces.edit', $annonce->id) }}" class="admin-button">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($annonce->statut === 'en_attente')
                                    <form action="{{ route('admin.annonces.approve', $annonce->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="admin-button admin-button-success" onclick="return confirm('Êtes-vous sûr de vouloir approuver cette annonce ?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($annonce->statut !== 'supprimee')
                                    <form action="{{ route('admin.annonces.destroy', $annonce->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-button admin-button-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
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
            {{ $annonces->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('css')
<style>
    .d-flex {
        display: flex;
    }
    
    .justify-content-end {
        justify-content: flex-end;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem;
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