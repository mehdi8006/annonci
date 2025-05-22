@extends('admin.layouts.app')

@section('title', 'Gestion des avis')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des avis</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-1"></i> Filtrer
            </button>
            <form action="{{ route('admin.reviews.autoReview') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="fas fa-robot me-1"></i> Modération automatique
                </button>
            </form>
            <form action="{{ route('admin.reviews.deleteAllRejected') }}" method="POST" class="d-inline" 
      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer tous les avis rejetés ? Cette action est irréversible.')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger shadow-sm">
        <i class="fas fa-trash me-1"></i> Supprimer tous les rejetés
    </button>
</form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Filtrer les avis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.reviews.index') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label for="search" class="form-label">Recherche</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Commentaire, utilisateur, annonce..." value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select id="statut" name="statut" class="form-select">
                                    <option value="">Tous</option>
                                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="rejete" {{ request('statut') === 'rejete' ? 'selected' : '' }}>Rejeté</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rating" class="form-label">Note</label>
                                <select id="rating" name="rating" class="form-select">
                                    <option value="">Toutes les notes</option>
                                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 étoile</option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 étoiles</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 étoiles</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 étoiles</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 étoiles</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary me-2">Réinitialiser</a>
                            <button type="submit" class="btn btn-primary">Appliquer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('search') || request('statut') || request('rating'))
        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4">
            <div>
                <i class="fas fa-filter me-2 text-primary"></i> 
                <strong>Filtres: </strong>
                @if(request('search'))<span class="badge bg-primary me-2">Recherche: {{ request('search') }}</span>@endif
                @if(request('statut'))<span class="badge bg-primary me-2">Statut: {{ request('statut') }}</span>@endif
                @if(request('rating'))<span class="badge bg-primary me-2">Note: {{ request('rating') }} étoile(s)</span>@endif
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times me-1"></i> Effacer
            </a>
        </div>
    @endif

    <!-- Reviews Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="small text-muted">En attente</div>
                        <div class="fs-5 fw-bold">{{ \App\Models\Review::where('statut', 'en_attente')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Approuvés</div>
                        <div class="fs-5 fw-bold">{{ \App\Models\Review::where('statut', 'approuve')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-danger text-white me-3">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Rejetés</div>
                        <div class="fs-5 fw-bold">{{ \App\Models\Review::where('statut', 'rejete')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Note moyenne</div>
                        <div class="fs-5 fw-bold">
                            @php
                                $avgRating = \App\Models\Review::avg('rating') ?: 0;
                            @endphp
                            {{ number_format($avgRating, 1) }}
                            <small class="text-muted">/5</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" width="5%">ID</th>
                            <th width="15%">Utilisateur</th>
                            <th width="20%">Annonce</th>
                            <th width="10%" class="text-center">Note</th>
                            <th width="30%">Commentaire</th>
                            <th width="10%" class="text-center">Statut</th>
                            <th width="10%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $review->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            {{ strtoupper(substr($review->utilisateur->nom ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>{{ $review->utilisateur->nom ?? 'Utilisateur inconnu' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.annonces.show', $review->annonce->id) }}" class="text-decoration-none">
                                        {{ Str::limit($review->annonce->titre ?? 'Annonce inconnue', 30) }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;">
                                        {{ Str::limit($review->comment, 80) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge 
                                        @if($review->statut === 'approuve') bg-success
                                        @elseif($review->statut === 'en_attente') bg-warning text-dark
                                        @else bg-danger @endif px-2 py-1">
                                        {{ str_replace('_', ' ', ucfirst($review->statut)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li>
                                                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                                            <i class="fas fa-check-circle me-2 text-success"></i> Approuver
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                                            <i class="fas fa-ban me-2 text-danger"></i> Rejeter
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon mb-3">
                                            <i class="fas fa-star fa-3x text-muted"></i>
                                        </div>
                                        <h5>Aucun avis à modérer</h5>
                                        <p class="text-muted">Il n'y a actuellement aucun avis en attente ou rejeté.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@section('css')
<style>
    /* Avatar and Icon Styles */
    .avatar-xs {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    /* Card Styles */
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    /* Table Styles */
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
    
    /* Empty State */
    .empty-state {
        padding: 2rem;
    }
    
    .empty-icon {
        opacity: 0.3;
    }
    
    /* Rating Stars */
    .rating-stars {
        font-size: 0.8rem;
        line-height: 1;
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
</style>
@endsection