<!-- resources/views/admin/reviews/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Détails de l\'avis')

@section('content')
    <div class="admin-header">
        <h1>Détails de l'avis</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.reviews.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Informations sur l'avis</h2>
                    <span class="admin-badge 
                        @if($review->statut === 'approuve') admin-badge-success
                        @elseif($review->statut === 'en_attente') admin-badge-warning
                        @else admin-badge-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $review->statut)) }}
                    </span>
                </div>
                
                <div class="admin-review-details">
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">ID</div>
                        <div class="col-md-9 admin-detail-value">{{ $review->id }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Note</div>
                        <div class="col-md-9 admin-detail-value">
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Utilisateur</div>
                        <div class="col-md-9 admin-detail-value">
                            {{ $review->utilisateur->nom }} ({{ $review->utilisateur->email }})
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Date de publication</div>
                        <div class="col-md-9 admin-detail-value">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Commentaire</div>
                        <div class="col-md-9 admin-detail-value">
                            {{ $review->comment ?? 'Aucun commentaire fourni' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Annonce concernée</h2>
                    <span class="admin-badge 
                        @if($review->annonce->statut === 'validee') admin-badge-success
                        @elseif($review->annonce->statut === 'en_attente') admin-badge-warning
                        @else admin-badge-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $review->annonce->statut)) }}
                    </span>
                </div>
                
                <div class="admin-review-annonce">
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Titre</div>
                        <div class="col-md-9 admin-detail-value">{{ $review->annonce->titre }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Prix</div>
                        <div class="col-md-9 admin-detail-value">{{ number_format($review->annonce->prix, 2, ',', ' ') }} DH</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Vendeur</div>
                        <div class="col-md-9 admin-detail-value">{{ $review->annonce->utilisateur->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Catégorie</div>
                        <div class="col-md-9 admin-detail-value">{{ $review->annonce->categorie->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Ville</div>
                        <div class="col-md-9 admin-detail-value">{{ $review->annonce->ville->nom }}</div>
                    </div>
                    
                    @if($review->annonce->images->count() > 0)
                        <div class="row mb-3">
                            <div class="col-md-3 admin-detail-label">Images</div>
                            <div class="col-md-9 admin-detail-value">
                                <div class="review-annonce-images">
                                    @foreach($review->annonce->images as $image)
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="Image de l'annonce" class="review-annonce-image">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a href="{{ route('admin.annonces.show', $review->annonce->id) }}" class="admin-button">
                                <i class="fas fa-eye"></i> Voir l'annonce complète
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Actions</h2>
                </div>
                
                @if($review->statut === 'en_attente')
                    <div class="admin-review-actions">
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="admin-button admin-button-success w-100" onclick="return confirm('Êtes-vous sûr de vouloir approuver cet avis ?')">
                                <i class="fas fa-check"></i> Approuver l'avis
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="admin-button admin-button-danger w-100" onclick="return confirm('Êtes-vous sûr de vouloir rejeter cet avis ?')">
                                <i class="fas fa-times"></i> Rejeter l'avis
                            </button>
                        </form>
                    </div>
                @else
                    <div class="review-already-handled">
                        <div class="review-status-icon">
                            @if($review->statut === 'approuve')
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                        </div>
                        <div class="review-status-message">
                            @if($review->statut === 'approuve')
                                Cet avis a déjà été approuvé.
                            @else
                                Cet avis a été rejeté.
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Utilisateur</h2>
                </div>
                
                <div class="admin-user-details">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr($review->utilisateur->nom, 0, 1)) }}
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Nom</div>
                        <div class="admin-detail-value">{{ $review->utilisateur->nom }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Email</div>
                        <div class="admin-detail-value">{{ $review->utilisateur->email }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Statut</div>
                        <div class="admin-detail-value">
                            @if($review->utilisateur->statut === 'valide')
                                <span class="admin-badge admin-badge-success">Actif</span>
                            @elseif($review->utilisateur->statut === 'en_attente')
                                <span class="admin-badge admin-badge-warning">En attente</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Supprimé</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.users.edit', $review->utilisateur->id) }}" class="admin-button w-100">
                            <i class="fas fa-user-edit"></i> Voir profil utilisateur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    
    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-9 {
        flex: 0 0 75%;
        max-width: 75%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .mb-3 {
        margin-bottom: 1rem;
    }
    
    .mt-3 {
        margin-top: 1rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .w-100 {
        width: 100%;
    }
    
    .admin-detail-label {
        font-weight: 600;
        color: #6b7280;
    }
    
    .admin-detail-value {
        color: #1f2937;
    }
    
    .rating-stars {
        color: #f59e0b;
        font-size: 16px;
    }
    
    .review-annonce-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .review-annonce-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .review-already-handled {
        padding: 20px;
        text-align: center;
    }
    
    .review-status-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }
    
    .review-status-icon .fa-check-circle {
        color: #10b981;
    }
    
    .review-status-icon .fa-times-circle {
        color: #ef4444;
    }
    
    .review-status-message {
        color: #6b7280;
        font-size: 16px;
    }
    
    .admin-user-details {
        padding: 15px 0;
    }
    
    .admin-user-avatar {
        width: 80px;
        height: 80px;
        background-color: #3b82f6;
        color: white;
        font-size: 32px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px;
    }
    
    .admin-detail-row {
        display: flex;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .admin-detail-row:last-child {
        border-bottom: none;
    }
    
    .admin-detail-row .admin-detail-label {
        flex: 1;
    }
    
    .admin-detail-row .admin-detail-value {
        flex: 2;
    }
</style>
@endsection