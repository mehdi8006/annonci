@extends('admin.layouts.app')

@section('title', 'Détails de l\'annonce')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with back button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de l'annonce</h1>
        <a href="{{ route('admin.annonces.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- Annonce Info Card -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <!-- Annonce Header -->
                <div class="card-header bg-primary text-white py-3 position-relative">
                    <h5 class="mb-0">Informations sur l'annonce</h5>
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge 
                            @if($annonce->statut === 'validee') bg-success
                            @elseif($annonce->statut === 'en_attente') bg-warning text-dark
                            @else bg-danger @endif px-3 py-2">
                            @if($annonce->statut === 'validee')
                                <i class="fas fa-check-circle me-1"></i> Validée
                            @elseif($annonce->statut === 'en_attente')
                                <i class="fas fa-clock me-1"></i> En attente
                            @else
                                <i class="fas fa-ban me-1"></i> Supprimée
                            @endif
                        </span>
                    </div>
                </div>
                
                <!-- Annonce Image -->
                <div class="position-relative">
                    @if($annonce->images->where('principale', true)->first())
                        <img src="{{ asset('storage/' .$annonce->images->where('principale', true)->first()->url) }}" 
                            class="w-100" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-secondary"></i>
                        </div>
                    @endif
                    
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge bg-dark px-3 py-2">
                            <i class="fas fa-camera me-1"></i> {{ $annonce->images->count() }} images
                        </span>
                    </div>
                </div>
                
                <!-- Annonce Details -->
                <div class="card-body pt-4">
                    <h4 class="mb-3">{{ $annonce->titre }}</h4>
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="badge bg-primary px-3 py-2 fs-6">
                            {{ number_format($annonce->prix, 0, ',', ' ') }} DH
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="rating-stars me-2">
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
                            <span class="text-muted">
                                ({{ $annonce->reviews->count() }})
                            </span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Annonce Information -->
                    <div class="mb-4">
                        <h6 class="mb-3 text-uppercase fw-bold text-muted fs-sm">Détails</h6>
                        
                        <div class="row g-3 mb-2">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Catégorie</div>
                                        <div>{{ $annonce->categorie->nom }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Sous-catégorie</div>
                                        <div>{{ $annonce->sousCategorie->nom ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Ville</div>
                                        <div>{{ $annonce->ville->nom }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Date</div>
                                        <div>{{ $annonce->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- User Information -->
                    <div>
                        <h6 class="mb-3 text-uppercase fw-bold text-muted fs-sm">Vendeur</h6>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle bg-primary text-white me-3">
                                {{ strtoupper(substr($annonce->utilisateur->nom, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $annonce->utilisateur->nom }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-phone me-1"></i> {{ $annonce->utilisateur->telephon }}
                                </small>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.users.show', $annonce->utilisateur->id) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-user me-1"></i> Voir le profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description & Reports & Reviews -->
        <div class="col-xl-8 col-lg-7">
            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-file-alt me-2"></i>Description
                    </h5>
                </div>
                
                <div class="card-body">
                    <p class="mb-0">{{ $annonce->description }}</p>
                </div>
            </div>

            <!-- Actions de traitement (if there are reports) -->
            @if($annonce->reports->count() > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-info">
                        <i class="fas fa-cogs me-2"></i>Actions de traitement
                    </h5>
                </div>
                
                <div class="card-body">
                    <p class="text-muted mb-3">Cette annonce a {{ $annonce->reports->count() }} signalement(s). Choisissez une action :</p>
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#processKeepModal">
                            <i class="fas fa-check-circle me-1"></i> Traiter et conserver
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#processDeleteModal">
                            <i class="fas fa-trash-alt me-1"></i> Traiter et supprimer
                        </button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Reports -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger">
                        <i class="fas fa-flag me-2"></i>Signalements
                    </h5>
                    <span class="badge bg-danger">{{ $annonce->reports->count() }}</span>
                </div>
                
                <div class="card-body p-0">
                    @if($annonce->reports->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Utilisateur</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($annonce->reports as $report)
                                        <tr>
                                            <td class="ps-3 fw-medium">{{ $report->id }}</td>
                                            <td>
                                                @if($report->utilisateur)
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-xs bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                            {{ strtoupper(substr($report->utilisateur->nom, 0, 1)) }}
                                                        </div>
                                                        <div>{{ $report->utilisateur->nom }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Utilisateur anonyme</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($report->type === 'fraude') bg-danger
                                                    @elseif($report->type === 'contenu_inapproprie') bg-warning text-dark
                                                    @elseif($report->type === 'produit_interdit') bg-dark
                                                    @elseif($report->type === 'doublon') bg-info
                                                    @elseif($report->type === 'mauvaise_categorie') bg-secondary
                                                    @else bg-primary @endif">
                                                    {{ str_replace('_', ' ', ucfirst($report->type)) }}
                                                </span>
                                            </td>
                                            <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($report->statut === 'traitee') bg-success
                                                    @elseif($report->statut === 'en_attente') bg-warning text-dark
                                                    @else bg-secondary @endif">
                                                    {{ str_replace('_', ' ', ucfirst($report->statut)) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state p-5 text-center">
                            <div class="empty-icon mb-3">
                                <i class="fas fa-flag fa-3x text-muted"></i>
                            </div>
                            <h5>Aucun signalement</h5>
                            <p class="text-muted">Cette annonce n'a pas encore été signalée.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning">
                        <i class="fas fa-star me-2"></i>Avis
                    </h5>
                    <div class="d-flex align-items-center">
                        <div class="rating-stars me-2">
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
                        <span class="badge bg-warning text-dark">{{ $annonce->reviews->count() }}</span>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($annonce->reviews->count() > 0)
                        <div class="p-4">
                            @foreach($annonce->reviews as $review)
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-circle-sm bg-primary text-white">
                                            {{ strtoupper(substr($review->utilisateur->nom, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0">{{ $review->utilisateur->nom }}</h6>
                                            <span class="badge 
                                                @if($review->statut === 'approuve') bg-success
                                                @elseif($review->statut === 'en_attente') bg-warning text-dark
                                                @else bg-danger @endif">
                                                {{ str_replace('_', ' ', ucfirst($review->statut)) }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rating-stars me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-muted small">{{ $review->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                </div>
                                
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state p-5 text-center">
                            <div class="empty-icon mb-3">
                                <i class="fas fa-star fa-3x text-muted"></i>
                            </div>
                            <h5>Aucun avis</h5>
                            <p class="text-muted">Cette annonce n'a pas encore reçu d'avis.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Process and Keep Modal -->
    <div class="modal fade" id="processKeepModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Traiter et conserver</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Cette action va :</p>
                    <ul>
                        <li>Marquer tous les signalements comme traités</li>
                        <li>Conserver l'annonce et la marquer comme validée</li>
                    </ul>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ $annonce->reports->count() }} signalement(s) seront marqués comme traités.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('admin.annonces.processAndKeep', $annonce->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Confirmer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Process and Delete Modal -->
    <div class="modal fade" id="processDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Traiter et supprimer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Cette action va :</p>
                    <ul>
                        <li>Marquer tous les signalements comme traités</li>
                        <li>Supprimer l'annonce définitivement</li>
                    </ul>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Cette action est irréversible.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('admin.annonces.processAndDelete', $annonce->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Confirmer la suppression
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
<style>
    /* Avatar and Icon Styles */
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
    }
    
    .avatar-circle-sm {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    
    .avatar-xs {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
    
    .icon-circle {
        width: 32px;
        height: 32px;
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
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
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
        padding: 3rem;
    }
    
    .empty-icon {
        opacity: 0.3;
    }
    
    /* Rating Stars */
    .rating-stars {
        font-size: 0.8rem;
    }
    
    /* Small Font Size */
    .fs-sm {
        font-size: 0.875rem;
    }
    
    /* Background Color for Card Header */
    .bg-primary {
        background-color: #0d6efd !important;
    }
    
    /* Image Gallery */
    .gallery-item {
        position: relative;
        height: 150px;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .gallery-item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .gallery-item:hover .gallery-item-overlay {
        opacity: 1;
    }
</style>
@endsection