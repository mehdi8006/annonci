@extends('admin.layouts.app')

@section('title', 'Gestion des signalements')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Liste des signalements</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-1"></i> Filtrer
            </button>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Filtrer les signalements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.reports.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select id="statut" name="statut" class="form-select">
                                    <option value="">Tous les statuts</option>
                                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="traitee" {{ request('statut') === 'traitee' ? 'selected' : '' }}>Traité</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select id="type" name="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    <option value="fraude" {{ request('type') === 'fraude' ? 'selected' : '' }}>Fraude</option>
                                    <option value="contenu_inapproprie" {{ request('type') === 'contenu_inapproprie' ? 'selected' : '' }}>Contenu inapproprié</option>
                                    <option value="produit_interdit" {{ request('type') === 'produit_interdit' ? 'selected' : '' }}>Produit interdit</option>
                                    <option value="doublon" {{ request('type') === 'doublon' ? 'selected' : '' }}>Doublon</option>
                                    <option value="mauvaise_categorie" {{ request('type') === 'mauvaise_categorie' ? 'selected' : '' }}>Mauvaise catégorie</option>
                                    <option value="autre" {{ request('type') === 'autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary me-2">Réinitialiser</a>
                            <button type="submit" class="btn btn-primary hover-lift">Appliquer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('statut') || request('type'))
        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4 fade-in">
            <div>
                <i class="fas fa-filter me-2 text-primary"></i> 
                <strong>Filtres: </strong>
                @if(request('statut'))<span class="badge bg-primary me-2 pulse">Statut: {{ request('statut') }}</span>@endif
                @if(request('type'))<span class="badge bg-primary me-2 pulse">Type: {{ str_replace('_', ' ', request('type')) }}</span>@endif
            </div>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary hover-lift">
                <i class="fas fa-times me-1"></i> Effacer
            </a>
        </div>
    @endif

    <!-- Statistics Cards -->
    @if($groupedReports->count() > 0)
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <div class="stats-icon stats-danger mb-3">
                            <i class="fas fa-flag"></i>
                        </div>
                        <h4 class="mb-0">{{ $groupedReports->count() }}</h4>
                        <small class="text-muted">Annonces signalées</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <div class="stats-icon stats-warning mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="mb-0">{{ $groupedReports->sum('reports_count') }}</h4>
                        <small class="text-muted">Total signalements</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <div class="stats-icon stats-info mb-3">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4 class="mb-0">{{ number_format($groupedReports->avg('reports_count'), 1) }}</h4>
                        <small class="text-muted">Moyenne par annonce</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <div class="stats-icon stats-primary mb-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="mb-0">{{ $groupedReports->where('reports.0.statut', 'en_attente')->count() }}</h4>
                        <small class="text-muted">En attente</small>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Reports Table -->
    <div class="card border-0 shadow-sm mb-4 fade-in">
        <div class="card-body p-0">
            @if($groupedReports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3" width="8%">ID Annonce</th>
                                <th width="40%">Annonce</th>
                                <th width="15%" class="text-center">Signalements</th>
                                <th width="15%" class="text-center">Types</th>
                                <th width="22%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedReports as $group)
                                <tr class="hover-row">
                                    <td class="ps-3 fw-medium">{{ $group['annonce']->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                @if($group['annonce']->images->where('principale', true)->first())
                                                    <img src="{{ asset($group['annonce']->images->where('principale', true)->first()->url) }}" 
                                                        class="rounded hover-zoom" alt="{{ $group['annonce']->titre }}" 
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-secondary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ Str::limit($group['annonce']->titre, 35) }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>{{ $group['annonce']->utilisateur->nom }}
                                                    <span class="ms-2">
                                                        <i class="fas fa-calendar me-1"></i>{{ $group['annonce']->created_at->format('d/m/Y') }}
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger fs-6 pulse-badge">
                                            {{ $group['reports_count'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center flex-wrap gap-1">
                                            @foreach($group['reports']->groupBy('type') as $type => $typeReports)
                                                @php
                                                    $colors = [
                                                        'fraude' => 'danger',
                                                        'contenu_inapproprie' => 'warning',
                                                        'produit_interdit' => 'dark',
                                                        'doublon' => 'info',
                                                        'mauvaise_categorie' => 'secondary',
                                                        'autre' => 'primary'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $colors[$type] ?? 'primary' }} small hover-badge" 
                                                      title="{{ $typeReports->count() }} signalement(s) pour {{ str_replace('_', ' ', $type) }}">
                                                    {{ $typeReports->count() }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.reports.show', $group['annonce']->id) }}" 
                                               class="btn btn-sm btn-primary hover-lift">
                                                <i class="fas fa-eye me-1"></i> Détails
                                            </a>
                                            
                                            @if($group['reports']->where('statut', 'en_attente')->count() > 0)
                                                <div class="btn-group">
                                                    <form action="{{ route('admin.reports.processAll', $group['annonce']->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="keep">
                                                        <button type="submit" class="btn btn-sm btn-success hover-lift" 
                                                                onclick="return confirm('Traiter tous les signalements et garder l\'annonce ?')">
                                                            <i class="fas fa-check me-1"></i> Garder
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('admin.reports.processAll', $group['annonce']->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="delete">
                                                        <button type="submit" class="btn btn-sm btn-danger hover-lift" 
                                                                onclick="return confirm('Traiter tous les signalements et supprimer l\'annonce ?')">
                                                            <i class="fas fa-trash me-1"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="badge bg-success">Traité</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state p-5 text-center fade-in">
                    <div class="empty-icon mb-3">
                        <i class="fas fa-flag fa-3x text-muted"></i>
                    </div>
                    <h5>Aucun signalement</h5>
                    <p class="text-muted">
                        @if(request()->has('statut') || request()->has('type'))
                            Aucun signalement ne correspond aux filtres sélectionnés.
                        @else
                            Il n'y a actuellement aucun signalement en attente.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Hover and Animation Effects */
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .hover-row:hover {
        background-color: rgba(0,0,0,0.02);
        transition: background-color 0.2s ease;
    }
    
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    
    .hover-zoom:hover {
        transform: scale(1.1);
    }
    
    .hover-badge {
        transition: all 0.2s ease;
    }
    
    .hover-badge:hover {
        transform: scale(1.1);
    }
    
    /* Pulse Animation */
    .pulse {
        animation: pulse 2s infinite;
    }
    
    .pulse-badge {
        animation: pulseBadge 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
        }
    }
    
    @keyframes pulseBadge {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }
    
    /* Fade In Animation */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Stats Icons */
    .stats-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        color: white;
        font-size: 24px;
        margin: 0 auto;
    }
    
    .stats-primary { background-color: var(--primary); }
    .stats-success { background-color: var(--success); }
    .stats-warning { background-color: var(--warning); }
    .stats-danger { background-color: var(--danger); }
    .stats-info { background-color: var(--info); }
    
    /* Empty State */
    .empty-state {
        padding: 3rem;
    }
    
    .empty-icon {
        opacity: 0.3;
    }
    
    /* Button Group Spacing */
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection