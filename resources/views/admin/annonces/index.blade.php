@extends('admin.layouts.app')

@section('title', 'Gestion des annonces')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Liste des annonces</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-1"></i> Filtrer
            </button>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Filtrer les annonces</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.annonces.index') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label for="search" class="form-label">Recherche</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Titre, description..." value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select id="statut" name="statut" class="form-select">
                                    <option value="">Tous les statuts</option>
                                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="validee" {{ request('statut') === 'validee' ? 'selected' : '' }}>Validée</option>
                                    <option value="supprimee" {{ request('statut') === 'supprimee' ? 'selected' : '' }}>Supprimée</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="categorie" class="form-label">Catégorie</label>
                                <select id="categorie" name="categorie" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <a href="{{ route('admin.annonces.index') }}" class="btn btn-outline-secondary me-2">Réinitialiser</a>
                            <button type="submit" class="btn btn-primary">Appliquer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('search') || request('statut') || request('categorie'))
        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4">
            <div>
                <i class="fas fa-filter me-2 text-primary"></i> 
                <strong>Filtres: </strong>
                @if(request('search'))<span class="badge bg-primary me-2">Recherche: {{ request('search') }}</span>@endif
                @if(request('statut'))<span class="badge bg-primary me-2">Statut: {{ request('statut') }}</span>@endif
                @if(request('categorie'))
                    @php
                        $categorieNom = App\Models\Categorie::find(request('categorie'))->nom ?? '';
                    @endphp
                    <span class="badge bg-primary me-2">Catégorie: {{ $categorieNom }}</span>
                @endif
            </div>
            <a href="{{ route('admin.annonces.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times me-1"></i> Effacer
            </a>
        </div>
    @endif

    <!-- Annonces Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" width="5%">ID</th>
                            <th width="35%">Annonce</th>
                            <th width="15%">Statut</th>
                            <th width="10%" class="text-center">Reports</th>
                            <th width="15%" class="text-center">Reviews</th>
                            <th width="10%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($annonces as $annonce)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $annonce->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                       
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($annonce->titre, 40) }}</h6>
                                          
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle 
                                            @if($annonce->statut === 'validee') btn-light-success
                                            @elseif($annonce->statut === 'en_attente') btn-light-warning
                                            @else btn-light-danger @endif" 
                                            type="button" data-bs-toggle="dropdown">
                                            @if($annonce->statut === 'validee')
                                                <i class="fas fa-check-circle me-1"></i> Validée
                                            @elseif($annonce->statut === 'en_attente')
                                                <i class="fas fa-clock me-1"></i> En attente
                                            @else
                                                <i class="fas fa-ban me-1"></i> Supprimée
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu shadow-sm border-0">
                                            <li>
                                                <form action="{{ route('admin.annonces.updateStatus', $annonce->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="validee">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-check-circle me-2 text-success"></i> Valider
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.annonces.updateStatus', $annonce->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="en_attente">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-clock me-2 text-warning"></i> En attente
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.annonces.updateStatus', $annonce->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="supprimee">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-ban me-2 text-danger"></i> Supprimer
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">
                                        {{ $annonce->reports->count() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge bg-info me-2">
                                            {{ $annonce->reviews->count() }}
                                        </span>
                                        @if($annonce->reviews->count() > 0)
                                            <div class="rating-stars">
                                                @php
                                                    $avgRating = $annonce->getAverageRatingAttribute();
                                                @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $avgRating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @elseif($i - 0.5 <= $avgRating)
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        @else
                                            <span class="text-muted small">Aucun</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> Voir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $annonces->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@section('css')
<style>
    /* Light Button Variants */
    .btn-light-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: none;
    }
    
    .btn-light-secondary {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: none;
    }
    
    .btn-light-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: none;
    }
    
    .btn-light-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: none;
    }
    
    .btn-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: none;
    }
    
    /* Dropdown Styling */
    .dropdown-menu {
        padding: 0.5rem 0;
        border-radius: 0.375rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    /* Table Styling */
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.75rem 0.5rem;
    }
    
    /* Rating Stars */
    .rating-stars {
        font-size: 0.8rem;
        white-space: nowrap;
    }
</style>
@endsection