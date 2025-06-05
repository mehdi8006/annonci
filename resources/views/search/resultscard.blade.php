<div class="container-fluid px-3 px-md-4 py-4">
    <div class="row g-3 g-md-4">
        @foreach($annonces as $annonce)
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('details',['id' =>$annonce->id]) }}" class="text-decoration-none">
                <div class="card h-100 border-0 product-card">
                    <!-- Card Header with User Info -->
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center">
                            @php
                                $firstName = strtoupper(substr($annonce->utilisateur->nom, 0, 1));
                                $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9'];
                                $colorIndex = ord($firstName) % count($colors);
                                $bgColor = $colors[$colorIndex];
                                $textColor = '#FFFFFF';
                            @endphp
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 user-avatar" 
                                 style="width: 40px; height: 40px; background-color: {{ $bgColor }}; color: {{ $textColor }};">
                                <span class="fw-bold user-initial">{{ $firstName }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold text-dark user-name-text">{{ $annonce->utilisateur->nom }}</h6>
                                <small class="text-muted d-flex align-items-center mt-1 date-text">
                                    <i class="fa-solid fa-clock me-1 icon-small"></i>
                                    {{ $annonce->date_publication->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="position-relative overflow-hidden" style="height: 200px; border-radius: 10px;">
                        @foreach($annonce->images as $image)
                            @if($image->principale == 1)
                                <img src="{{ asset('storage/' . $image->url) }}" 
                                     alt="Image principale" 
                                     class="w-100 h-100 object-fit-cover">
                                @break
                            @endif
                        @endforeach
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Location -->
                        <div class="d-flex align-items-center text-muted mb-2">
                            <i class="fa-solid fa-location-dot me-2 icon-small"></i>
                            <small class="location-text">{{ $annonce->sousCategorie ? $annonce->sousCategorie->nom : $annonce->categorie->nom }} dans {{ $annonce->ville->nom }}</small>
                        </div>
                        
                        <!-- Product Title -->
                        <h5 class="card-title fw-bold text-dark mb-3 lh-base product-title-text">
                            {{ Str::limit($annonce->titre, 35) }}
                        </h5>
                        
                        <!-- Price -->
                        <div class="d-flex align-items-baseline mb-3">
                            <span class="h5 fw-bold text-warning mb-0 price-text">{{ number_format($annonce->prix, 0, ',', ' ') }}</span>
                            <span class="ms-1 text-dark fw-medium currency-text">DH</span>
                        </div>

                        <!-- Categories -->
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark border d-flex align-items-center badge-text">
                                <i class="fa-solid fa-tag me-1 icon-small"></i>
                                {{ $annonce->categorie->nom }}
                            </span>
                            @if($annonce->sousCategorie)
                                <span class="badge bg-light text-dark border d-flex align-items-center badge-text">
                                    <i class="fa-solid fa-tag me-1 icon-small"></i>
                                    {{ $annonce->sousCategorie->nom }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
/* User Avatar Styles */
.user-avatar {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.user-initial {
    font-size: 0.9rem;
    line-height: 1;
}

/* Text size reduction by 15% (multiply by 0.85) */
.user-name-text {
    font-size: 0.85rem !important; /* h6 default ~1rem, reduced to 0.85rem */
}

.date-text {
    font-size: 0.723rem !important; /* small default ~0.85rem, reduced to ~0.723rem */
}

.location-text {
    font-size: 0.723rem !important; /* small default ~0.85rem, reduced to ~0.723rem */
}

.product-title-text {
    font-size: 0.85rem !important; /* Originally 1rem, reduced to 0.85rem */
}

.price-text {
    font-size: 1.02rem !important; /* h5 default ~1.2rem, reduced to ~1.02rem */
}

.currency-text {
    font-size: 0.85rem !important; /* Regular text, reduced by 15% */
}

.badge-text {
    font-size: 0.638rem !important; /* Originally 0.75rem, reduced to ~0.638rem */
    padding: 0.34rem 0.68rem; /* Adjust padding proportionally */
}

.icon-small {
    font-size: 0.638rem !important; /* Originally 0.75rem, reduced to ~0.638rem */
}

.product-card {
    transition: all 0.3s ease;
    border-radius: 0.75rem !important;
}

.product-card:hover .card-title {
    color: #f97316 !important;
}

/* Remove link default styles */
a.text-decoration-none:hover {
    text-decoration: none !important;
}

/* Ensure images cover the container properly */
.object-fit-cover {
    object-fit: cover;
}

/* Custom badge styling */
.badge {
    font-weight: 500;
    border-radius: 1rem;
}

/* Enhanced card header */
.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.05) !important;
}

/* Price styling enhancement */
.text-warning {
    color: #f59e0b !important;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .card-header {
        padding: 0.75rem 1rem !important;
    }
    
    /* Even smaller text on mobile for better fit */
    .user-name-text {
        font-size: 0.8rem !important;
    }
    
    .product-title-text {
        font-size: 0.8rem !important;
    }
    
    .price-text {
        font-size: 0.95rem !important;
    }
    
    /* Adjust avatar size on mobile */
    .user-avatar {
        width: 35px !important;
        height: 35px !important;
    }
    
    .user-initial {
        font-size: 0.8rem !important;
    }
}

/* Additional color variations for more users */
@media (prefers-color-scheme: dark) {
    .user-avatar {
        box-shadow: 0 2px 4px rgba(255,255,255,0.1);
    }
    
    .user-avatar:hover {
        box-shadow: 0 4px 8px rgba(255,255,255,0.15);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any additional functionality here
    console.log('Product listing loaded with user avatar initials');
    
    // Optional: Add click animation to avatars
    const avatars = document.querySelectorAll('.user-avatar');
    avatars.forEach(avatar => {
        avatar.addEventListener('click', function(e) {
            e.preventDefault();
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            }, 150);
        });
    });
});
</script>