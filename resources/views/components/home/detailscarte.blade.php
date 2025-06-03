{{-- resources/views/components/home/detailscarte.blade.php --}}


<style>
   
    .image-gallery {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .thumbnail-img {
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    
    .thumbnail-img:hover {
        transform: scale(1.05);
        opacity: 0.8;
    }
    
    .thumbnail-img.active {
        border: 3px solid #0d6efd;
    }
    
    .price-badge {
        font-size: 1.75rem;
        font-weight: 700;
    }
    
    .rating-stars {
        color: #ffc107;
    }
    
    .contact-modal .modal-content {
        border-radius: 15px;
    }
    
    .seller-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: bold;
    }
    
    .review-user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }
    
    .image-not-found {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .alert-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        min-width: 300px;
    }
    
    .product-card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .product-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    /* Custom scrollbar for reviews */
    .reviews-scroll-container {
        scrollbar-width: thin;
        scrollbar-color: #0d6efd #f8f9fa;
    }
    
    .reviews-scroll-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .reviews-scroll-container::-webkit-scrollbar-track {
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .reviews-scroll-container::-webkit-scrollbar-thumb {
        background: #0d6efd;
        border-radius: 10px;
    }
    
    .reviews-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #0a58ca;
    }
</style>

@props(['userAds','ads','isFavorite','add'])

<!-- Alert Messages -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-toast" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show alert-toast" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container my-4">
    @foreach ($ads as $ad)
    <div class="row">
        <!-- Image Gallery Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm image-gallery">
                <div class="card-body p-0">
                    @if($ad->images->count() > 0)
                        <!-- Main Image -->
                        <img id="mainImage" src="{{ asset('storage/' . $ad->images->first()->url) }}" 
                             alt="Main product image" class="img-fluid w-100" style="height: 400px; object-fit: cover;">
                        
                        <!-- Thumbnails -->
                        @if($ad->images->count() > 1)
                        <div class="p-3">
                            <div class="row g-2">
                                @foreach($ad->images->take(4) as $index => $image)
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $image->url) }}" 
                                         alt="Thumbnail {{ $index + 1 }}" 
                                         class="img-fluid thumbnail-img {{ $index === 0 ? 'active' : '' }}"
                                         onclick="changeMainImage(this)"
                                         style="height: 80px; object-fit: cover; width: 100%;">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @else
                        <!-- No Image Available -->
                        <div class="image-not-found">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <h5>Image non disponible</h5>
                            <p class="text-muted">Aucune image n'a été téléchargée pour cette annonce</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h1 class="card-title h3 mb-3">{{ $ad->titre }}</h1>
                    
                    <!-- Rating Section -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating-stars me-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($ad->average_rating))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $ad->average_rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-primary fw-bold">{{ number_format($ad->average_rating, 1) }}</span>
                        <span class="text-muted ms-1">({{ $ad->reviews_count }} avis)</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <span class="badge bg-success price-badge">{{ number_format($ad->prix, 2) }} DH</span>
                    </div>

                    <!-- Location Info -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <span>{{ $ad->ville->region }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-home text-primary me-2"></i>
                            <span>{{ $ad->ville->nom }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-info me-2"></i>
                            <span>Publié le {{ $ad->date_publication->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $ad->description }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2">
                        <!-- Contact Button -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-phone me-2"></i>Contacter
                        </button>

                        <!-- Favorite Button -->
                        @if(session()->has('user_id'))
                            @if($isFavorite)
                                <form action="{{ route('favorites.remove', $ad->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-heart me-2"></i>Favoris
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('favorites.add', $ad->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="far fa-heart me-2"></i>Favoris
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('form') }}" class="btn btn-outline-danger">
                                <i class="far fa-heart me-2"></i>Favoris
                            </a>
                        @endif

                        <!-- Review Button -->
                        @if(session()->has('user_id') && $ad->id_utilisateur != session('user_id'))
                            <a href="{{ route('reviews.create', $ad->id) }}" class="btn btn-warning">
                                <i class="fas fa-star me-2"></i>Laisser un avis
                            </a>
                        @endif

                        <!-- Report Button -->
                        @if(session()->has('user_id'))
                            <a href="{{ route('annonces.report', $ad->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-flag me-2"></i>Signaler
                            </a>
                        @else
                            <a href="{{ route('form') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-flag me-2"></i>Signaler
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seller Info Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="seller-avatar me-3">
                            {{ substr($ad->utilisateur->nom, 0, 1) }}
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $ad->utilisateur->nom }}</h5>
                            <p class="text-muted mb-0">Membre depuis {{ $ad->utilisateur->created_at->format('F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Avis et commentaires</h4>
                        @if(session()->has('user_id') && $ad->id_utilisateur != session('user_id'))
                            <a href="{{ route('reviews.create', $ad->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Écrire un avis
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($ad->reviews_count > 0)
                        <!-- Rating Summary -->
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="display-4 fw-bold">{{ number_format($ad->average_rating, 1) }}</div>
                                <div class="rating-stars fs-4 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($ad->average_rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $ad->average_rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="text-muted">{{ $ad->reviews_count }} avis</div>
                            </div>
                            <div class="col-md-8">
                                <!-- Rating Breakdown -->
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $count = $ad->reviews->where('rating', $i)->count();
                                        $percentage = $ad->reviews_count > 0 ? ($count / $ad->reviews_count) * 100 : 0;
                                    @endphp
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2">{{ $i }} <i class="fas fa-star rating-stars"></i></span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-muted small">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Individual Reviews -->
                        <hr>
                        <h5 class="mb-3">Commentaires</h5>
                        <div class="reviews-scroll-container" style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                            @foreach($ad->reviews->where('statut', 'approuve')->sortByDesc('created_at') as $review)
                                <div class="d-flex mb-4 p-3 bg-light rounded">
                                    <div class="review-user-avatar me-3">
                                        {{ substr($review->utilisateur->nom, 0, 1) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $review->utilisateur->nom }}</h6>
                                                <div class="rating-stars small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        @if($review->comment)
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($ad->reviews_count > 0)
                            <div class="text-center mt-3">
                                <small class="text-muted">Affichage de tous les {{ $ad->reviews_count }} avis</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun avis pour le moment</h5>
                            <p class="text-muted">Soyez le premier à laisser un avis sur cette annonce</p>
                            @if(session()->has('user_id') && $ad->id_utilisateur != session('user_id'))
                                <a href="{{ route('reviews.create', $ad->id) }}" class="btn btn-warning">
                                    <i class="fas fa-star me-2"></i>Laisser le premier avis
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Other Ads from Same Seller -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <x-home.scrollingcarte :ads="$userAds" :add="$add" :title="'Autres annonces du même vendeur'"/>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content contact-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Attention !
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-warning mb-3">
                        <strong>Important :</strong> Il ne faut jamais envoyer de l'argent à l'avance au vendeur.
                    </div>
                    <p class="mb-3">Contacter le vendeur pour négocier</p>
                    <div class="d-grid">
                        <a href="tel:{{ $ad->utilisateur->telephon }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>{{ $ad->utilisateur->telephon }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


<script>
    // Image gallery functionality
    function changeMainImage(thumbnail) {
        document.getElementById('mainImage').src = thumbnail.src;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-img').forEach(img => {
            img.classList.remove('active');
        });
        thumbnail.classList.add('active');
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-toast');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>