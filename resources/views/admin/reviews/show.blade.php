@extends('admin.layouts.app')

@section('title', 'Détails de l\'avis')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with back button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de l'avis #{{ $review->id }}</h1>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Review Details Card -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-star me-2"></i>Informations sur l'avis
                    </h5>
                    <span class="badge 
                        @if($review->statut === 'approuve') bg-success
                        @elseif($review->statut === 'en_attente') bg-warning text-dark
                        @else bg-danger @endif px-3 py-2">
                        {{ str_replace('_', ' ', ucfirst($review->statut)) }}
                    </span>
                </div>
                
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rating-stars me-2" style="font-size: 1.2rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-muted">Note: {{ $review->rating }}/5</span>
                        </div>
                        
                        <div class="alert alert-light">
                            <div class="fw-bold mb-1">Commentaire:</div>
                            <p class="mb-0">{{ $review->comment ?: 'Aucun commentaire' }}</p>
                        </div>
                        
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Créé le {{ $review->created_at->format('d/m/Y à H:i') }}</span>
                            <span>Dernière mise à jour: {{ $review->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Buttons for moderation -->
                    <div class="d-flex justify-content-between">
                        <div>
                            @if($review->statut !== 'approuve')
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success me-2">
                                        <i class="fas fa-check-circle me-1"></i> Approuver cet avis
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div>
                            @if($review->statut !== 'rejete')
                                <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-ban me-1"></i> Rejeter cet avis
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User & Annonce Info -->
        <div class="col-lg-4">
            <!-- User Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-user me-2"></i>Informations sur l'utilisateur
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle bg-primary text-white me-3">
                            {{ strtoupper(substr($review->utilisateur->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $review->utilisateur->nom ?? 'Utilisateur inconnu' }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-envelope me-1"></i> {{ $review->utilisateur->email ?? 'Email non disponible' }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="small text-muted">Téléphone</div>
                                <div>{{ $review->utilisateur->telephon ?? 'Non disponible' }}</div>
                            </div>
                            
                            <div class="col-6">
                                <div class="small text-muted">Ville</div>
                                <div>{{ $review->utilisateur->ville ?? 'Non disponible' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <div class="small text-muted">Total d'avis par cet utilisateur</div>
                        <div class="fw-bold">{{ $review->utilisateur->reviews->count() ?? '0' }} avis</div>
                    </div>
                    
                    <a href="{{ route('admin.users.show', $review->utilisateur->id) }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-user me-1"></i> Voir le profil complet
                    </a>
                </div>
            </div>
            
            <!-- Annonce Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-ad me-2"></i>Informations sur l'annonce
                    </h5>
                </div>
                
                <div class="position-relative">
                    @if($review->annonce->images->where('principale', true)->first())
                        <img src="{{ asset('storage/' .$review->annonce->images->where('principale', true)->first()->url) }}" 
                            class="w-100" alt="{{ $review->annonce->titre }}" style="height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="fas fa-image fa-3x text-secondary"></i>
                        </div>
                    @endif
                </div>
                
                <div class="card-body">
                    <h6 class="mb-2">{{ $review->annonce->titre ?? 'Annonce inconnue' }}</h6>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary px-2 py-1">
                            {{ number_format($review->annonce->prix ?? 0, 0, ',', ' ') }} DH
                        </span>
                    </div>
                    
                    <div class="small text-truncate mb-3" style="max-height: 60px; overflow: hidden;">
                        {{ Str::limit($review->annonce->description ?? 'Description non disponible', 100) }}
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i> 
                            {{ $review->annonce->ville->nom ?? 'Ville non disponible' }}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i> 
                            {{ $review->annonce->ville->nom ?? 'Ville non disponible' }}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-calendar-alt me-1"></i> 
                            {{ $review->annonce->created_at ? $review->annonce->created_at->format('d/m/Y') : 'Date non disponible' }}
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="small text-muted">
                            <i class="fas fa-tag me-1"></i> 
                            {{ $review->annonce->categorie->nom ?? 'Catégorie non disponible' }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="rating-stars me-1">
                                @php
                                    $avgRating = $review->annonce ? $review->annonce->getAverageRatingAttribute() : 0;
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
                            <span class="small text-muted">
                                ({{ $review->annonce ? $review->annonce->getReviewsCountAttribute() : 0 }})
                            </span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <a href="{{ route('admin.annonces.show', $review->annonce->id) }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-eye me-1"></i> Voir l'annonce complète
                    </a>
                </div>
            </div>
        </div>
        
        <!-- AI Analysis Card -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-robot me-2"></i>Analyse automatique
                    </h5>
                </div>
                
                <div class="card-body">
                    <p class="mb-3">Voici une analyse automatique du contenu de cet avis pour vous aider à prendre une décision de modération.</p>
                    
                    <div class="row g-4">
                        <!-- Sentiment Analysis -->
                        <div class="col-lg-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="mb-3"><i class="fas fa-smile-beam me-2 text-primary"></i>Sentiment</h6>
                                    
                                    @php
                                        // Simple sentiment analysis based on rating
                                        $sentiment = 'Neutre';
                                        $sentimentColor = 'bg-secondary';
                                        $sentimentWidth = '50%';
                                        
                                        if ($review->rating >= 4) {
                                            $sentiment = 'Positif';
                                            $sentimentColor = 'bg-success';
                                            $sentimentWidth = '85%';
                                        } elseif ($review->rating <= 2) {
                                            $sentiment = 'Négatif';
                                            $sentimentColor = 'bg-danger';
                                            $sentimentWidth = '25%';
                                        } elseif ($review->rating == 3) {
                                            $sentiment = 'Neutre';
                                            $sentimentColor = 'bg-warning';
                                            $sentimentWidth = '50%';
                                        }
                                    @endphp
                                    
                                    <div class="mb-2">{{ $sentiment }}</div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar {{ $sentimentColor }}" role="progressbar" style="width: {{ $sentimentWidth }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content Quality -->
                        <div class="col-lg-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Qualité du contenu</h6>
                                    
                                    @php
                                        // Simple content quality metrics
                                        $comment = $review->comment ?? '';
                                        $wordCount = str_word_count($comment);
                                        
                                        $quality = 'Faible';
                                        $qualityColor = 'bg-danger';
                                        $qualityWidth = '25%';
                                        
                                        if ($wordCount > 30) {
                                            $quality = 'Excellente';
                                            $qualityColor = 'bg-success';
                                            $qualityWidth = '90%';
                                        } elseif ($wordCount > 15) {
                                            $quality = 'Bonne';
                                            $qualityColor = 'bg-info';
                                            $qualityWidth = '70%';
                                        } elseif ($wordCount > 5) {
                                            $quality = 'Moyenne';
                                            $qualityColor = 'bg-warning';
                                            $qualityWidth = '50%';
                                        }
                                    @endphp
                                    
                                    <div class="mb-2">{{ $quality }} ({{ $wordCount }} mots)</div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar {{ $qualityColor }}" role="progressbar" style="width: {{ $qualityWidth }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recommendation -->
                        <div class="col-lg-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="mb-3"><i class="fas fa-lightbulb me-2 text-primary"></i>Recommandation</h6>
                                    
                                    @php
                                        // Simple recommendation based on rating and content
                                        $recommendation = 'À examiner';
                                        $recommendationColor = 'text-warning';
                                        $recommendationIcon = 'fas fa-search';
                                        
                                        if ($review->rating >= 3 && $wordCount > 5) {
                                            $recommendation = 'Approuver';
                                            $recommendationColor = 'text-success';
                                            $recommendationIcon = 'fas fa-check-circle';
                                        } elseif ($review->rating <= 2 && $wordCount < 5) {
                                            $recommendation = 'Examiner attentivement';
                                            $recommendationColor = 'text-danger';
                                            $recommendationIcon = 'fas fa-exclamation-triangle';
                                        }
                                    @endphp
                                    
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $recommendationIcon }} {{ $recommendationColor }} fa-2x me-2"></i>
                                        <div class="{{ $recommendationColor }} fw-bold">{{ $recommendation }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="text-muted mb-0">Cette analyse est générée automatiquement à titre indicatif. La décision finale de modération reste à votre discrétion.</p>
                    </div>
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
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
    }
    
    /* Card Styles */
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Rating Stars */
    .rating-stars {
        font-size: 0.8rem;
        white-space: nowrap;
    }
</style>
@endsection