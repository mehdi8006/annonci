<!-- resources/views/admin/annonces/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion des annonces')

@section('content')
    <div class="admin-header">
        <h1>Gestion des annonces</h1>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.annonces.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="search" class="admin-form-label">Recherche</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="search" name="search" class="admin-form-input" placeholder="Titre, description..." value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
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
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <div class="admin-form-group">
                        <label for="prix_min" class="admin-form-label">Prix min (DH)</label>
                        <input type="number" id="prix_min" name="prix_min" class="admin-form-input" placeholder="Min" value="{{ request('prix_min') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="admin-form-group">
                        <label for="prix_max" class="admin-form-label">Prix max (DH)</label>
                        <input type="number" id="prix_max" name="prix_max" class="admin-form-input" placeholder="Max" value="{{ request('prix_max') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="admin-form-group">
                        <label class="admin-form-label d-block">&nbsp;</label>
                        <button type="submit" class="admin-button w-100">
                            Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 70px;">ID</th>
                        <th>Annonce</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th class="text-center">Utilisateur</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annonces as $annonce)
                        <tr>
                            <td class="text-center">{{ $annonce->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="annonce-img-container me-2">
                                        @if($annonce->images->where('principale', true)->first())
                                            <img src="{{ asset('storage/' . $annonce->images->where('principale', true)->first()->url) }}" alt="Image principale" class="annonce-thumbnail">
                                        @elseif($annonce->images->first())
                                            <img src="{{ asset('storage/' . $annonce->images->first()->url) }}" alt="Image" class="annonce-thumbnail">
                                        @else
                                            <div class="annonce-no-img"><i class="fas fa-image"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="annonce-title">{{ $annonce->titre }}</div>
                                        <div class="annonce-location"><i class="fas fa-map-marker-alt"></i> {{ $annonce->ville->nom }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="annonce-category">{{ $annonce->categorie->nom }}</span>
                                @if($annonce->sousCategorie)
                                    <span class="annonce-subcategory">{{ $annonce->sousCategorie->nom }}</span>
                                @endif
                            </td>
                            <td><span class="annonce-price">{{ number_format($annonce->prix, 2, ',', ' ') }} DH</span></td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.show', $annonce->id_utilisateur) }}" class="annonce-user">
                                    {{ $annonce->utilisateur->nom }}
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="status-selector">
                                    <form action="{{ route('admin.annonces.updateStatus', $annonce->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <div class="btn-group status-buttons" role="group">
                                            <button type="submit" name="statut" value="validee" class="btn btn-sm {{ $annonce->statut === 'validee' ? 'btn-success active' : 'btn-outline-success' }}" title="Valider">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="submit" name="statut" value="en_attente" class="btn btn-sm {{ $annonce->statut === 'en_attente' ? 'btn-warning active' : 'btn-outline-warning' }}" title="En attente">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                            <button type="submit" name="statut" value="supprimee" class="btn btn-sm {{ $annonce->statut === 'supprimee' ? 'btn-danger active' : 'btn-outline-danger' }}" title="Supprimer">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td class="text-center">{{ $annonce->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="admin-button" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('details', $annonce->id) }}" target="_blank" class="admin-button admin-button-secondary" title="Voir sur le site">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
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
    /* General improvements */
    .w-100 {
        width: 100%;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .text-center {
        text-align: center;
    }
    
    .d-flex {
        display: flex;
    }
    
    .d-inline {
        display: inline;
    }
    
    .d-block {
        display: block;
    }
    
    .align-items-center {
        align-items: center;
    }
    
    .me-2 {
        margin-right: 0.5rem;
    }
    
    /* Annonce styles */
    .annonce-img-container {
        width: 50px;
        height: 50px;
        overflow: hidden;
        border-radius: 6px;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .annonce-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .annonce-no-img {
        color: #9ca3af;
        font-size: 20px;
    }
    
    .annonce-title {
        font-weight: 600;
        line-height: 1.2;
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .annonce-location {
        font-size: 12px;
        color: #6b7280;
    }
    
    .annonce-location i {
        font-size: 10px;
        margin-right: 3px;
    }
    
    .annonce-category {
        display: block;
        font-weight: 500;
    }
    
    .annonce-subcategory {
        display: block;
        font-size: 12px;
        color: #6b7280;
    }
    
    .annonce-price {
        font-weight: 600;
        color: #2563eb;
    }
    
    .annonce-user {
        color: #4b5563;
        text-decoration: none;
        font-weight: 500;
    }
    
    .annonce-user:hover {
        color: #2563eb;
        text-decoration: underline;
    }
    
    /* Status buttons */
    .status-selector {
        display: flex;
        justify-content: center;
    }
    
    .status-buttons .btn {
        padding: 0.25rem 0.5rem;
        border-radius: 0;
    }
    
    .status-buttons .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    
    .status-buttons .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    
    .status-buttons .btn.active {
        font-weight: 600;
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    
    .action-buttons .admin-button {
        padding: 5px 10px;
    }
    
    /* Pagination styles */
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
        transition: all 0.2s;
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
    
    .page-link:hover {
        background-color: #f3f4f6;
        border-color: #e2e8f0;
        color: #2563eb;
    }
    
    /* Filter improvements */
    .input-group {
        display: flex;
        position: relative;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6b7280;
        text-align: center;
        white-space: nowrap;
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        border-right: none;
        border-radius: 0.25rem 0 0 0.25rem;
    }
    
    .input-group .admin-form-input {
        border-radius: 0 0.25rem 0.25rem 0;
    }
    
    /* Responsive grid */
    .g-3 {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
        margin-top: calc(-1 * var(--bs-gutter-y));
        margin-right: calc(-.5 * var(--bs-gutter-x));
        margin-left: calc(-.5 * var(--bs-gutter-x));
    }
    
    .g-3 > * {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        margin-top: var(--bs-gutter-y);
    }
</style>
@endsection