@extends('admin.layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with back button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de l'utilisateur</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- User Info Card -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <!-- User Header -->
                <div class="card-header bg-primary text-white py-3 position-relative">
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge 
                            @if($user->statut === 'valide') bg-success
                            @elseif($user->statut === 'en_attente') bg-warning text-dark
                            @else bg-danger @endif px-3 py-2">
                            @if($user->statut === 'valide')
                                <i class="fas fa-check-circle me-1"></i> Actif
                            @elseif($user->statut === 'en_attente')
                                <i class="fas fa-clock me-1"></i> En attente
                            @else
                                <i class="fas fa-ban me-1"></i> Inactif
                            @endif
                        </span>
                    </div>
                </div>
                
                <!-- User Profile -->
                <div class="card-body text-center pt-4">
                    <div class="avatar-circle bg-primary text-white mx-auto mb-3">
                        {{ strtoupper(substr($user->nom, 0, 1)) }}
                    </div>
                    
                    <h4 class="mb-1">{{ $user->nom }}</h4>
                    
                    <span class="badge 
                        @if($user->type_utilisateur === 'admin') bg-primary
                        @else bg-secondary @endif mb-3">
                        @if($user->type_utilisateur === 'admin')
                            <i class="fas fa-user-shield me-1"></i> Administrateur
                        @else
                            <i class="fas fa-user me-1"></i> Utilisateur
                        @endif
                    </span>
                    
                    <p class="text-muted mb-4">
                        <i class="fas fa-calendar-alt me-1"></i> Membre depuis {{ $user->created_at->format('d/m/Y') }}
                    </p>
                    
                    <hr>
                    
                    <!-- Contact Information -->
                    <div class="text-start">
                        <h6 class="mb-3 text-uppercase fw-bold text-muted fs-sm">Coordonnées</h6>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-light text-primary me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Email</div>
                                    <div>{{ $user->email }}</div>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-light text-primary me-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Téléphone</div>
                                    <div>{{ $user->telephon }}</div>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-light text-primary me-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Ville</div>
                                    <div>{{ $user->ville }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Annonces List -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-list me-2"></i>Annonces publiées
                    </h5>
                    <span class="badge bg-primary">{{ $user->annonces->count() }}</span>
                </div>
                
                <div class="card-body p-0">
                    @if($user->annonces->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Titre</th>
                                        <th>Catégorie</th>
                                        <th>Reports</th>
                                        <th>Reviews</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->annonces as $annonce)
                                        <tr>
                                            <td class="ps-3 fw-medium">{{ $annonce->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-0">{{ Str::limit($annonce->titre, 30) }}</h6>
                                                        <div class="small text-muted">
                                                            <span class="me-2">{{ number_format($annonce->prix, 0, ',', ' ') }} DH</span>
                                                            <span class="badge 
                                                                @if($annonce->statut === 'validee') bg-success
                                                                @elseif($annonce->statut === 'en_attente') bg-warning text-dark
                                                                @else bg-danger @endif">
                                                                {{ $annonce->statut }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $annonce->categorie->nom ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $annonce->sousCategorie->nom ?? '' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger text-white">
                                                    {{ $annonce->reports->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-info text-white me-2">
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
                                                        <span class="text-muted small">Aucun avis</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state p-5 text-center">
                            <div class="empty-icon mb-3">
                                <i class="fas fa-store-alt-slash fa-3x text-muted"></i>
                            </div>
                            <h5>Aucune annonce trouvée</h5>
                            <p class="text-muted">Cet utilisateur n'a pas encore publié d'annonces.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Avatar and Icon Styles */
    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 32px;
    }
    
    .icon-circle {
        width: 36px;
        height: 36px;
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
</style>
@endsection