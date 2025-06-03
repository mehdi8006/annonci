{{-- resources/views/components/home/detailscartem.blade.php --}}

@props(['ads'])

<div class="container my-4">
    @foreach ($ads as $ad)
    <div class="card shadow-sm">
        <div class="row g-0">
            <!-- Image Gallery Section -->
            <div class="col-lg-6">
                <div class="p-4">
                    <!-- Main Image -->
                    <div class="mb-3">
                        @if($ad->images->count() > 0)
                            @foreach($ad->images as $image)
                                @if($image->principale == 1)
                                    <img src="{{ asset('storage/' . $image->url) }}" 
                                         alt="Main product image" 
                                         class="img-fluid rounded main-image w-100" 
                                         style="height: 400px; object-fit: cover;">
                                @endif
                            @endforeach
                        @else
                            <!-- No Image Available -->
                            <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded" 
                                 style="height: 400px;">
                                <svg width="60" height="60" class="text-muted mb-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21.9 21.9l-8.49-8.49-9.93-9.93-2.83-2.83L.65.65 2.07 2.07l3.13 3.13L5 5.5v2l-3 6.01V16h2.01L8 13l.01-.01 1.7 1.7-.71.71L7.83 17h10.35l2.63 2.63 1.41-1.41-1.41-1.41L21.9 21.9zM2.5 5.5l3.54 3.54L3 13.01l-1 2v-2l1.41-2.83L2.5 5.5zM7 2h10v2h-7.59l-2-2H7zm7 10.5c0-.78.67-1.45 1.45-1.45s1.45.67 1.45 1.45-.67 1.45-1.45 1.45-1.45-.67-1.45-1.45zm6 3.5h-1.59l-3-3 .59-.59 4 4V16zm-1.03-7.59l-9.47-2.35L17 2.53v5.88z"/>
                                </svg>
                                <p class="text-muted fw-medium">Image Not Available</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    @if($ad->images->count() > 1)
                    <div class="d-flex gap-2 overflow-auto">
                        @foreach($ad->images->take(4) as $index => $image)
                            <img src="{{ asset('storage/' . $image->url) }}" 
                                 alt="Thumbnail {{ $index + 1 }}" 
                                 class="thumbnail border rounded {{ $index === 0 ? 'border-primary' : 'border-secondary' }}" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                 onclick="changeMainImage(this)">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Product Info Section -->
            <div class="col-lg-6">
                <div class="p-4">
                    <h1 class="h2 fw-bold text-dark mb-3">{{ $ad->titre }}</h1>
                    
                    <div class="h3 text-danger fw-bold mb-4">{{ number_format($ad->prix, 0, ',', ' ') }} DH</div>
                    
                    <!-- Location & Date Info -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <span class="text-muted">{{ $ad->ville->region }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-home text-secondary me-2"></i>
                            <span class="text-muted">{{ $ad->ville->nom }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-secondary me-2"></i>
                            <span class="text-muted">Publié le {{ $ad->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h3 class="h5 fw-semibold mb-3">Description</h3>
                        <p class="text-dark lh-lg">{{ $ad->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Seller Info Section -->
        <div class="card-footer bg-light">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                     style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                    {{ substr($ad->utilisateur->nom, 0, 1) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold h6 mb-1">{{ $ad->utilisateur->nom }}</div>
                    <small class="text-muted">Membre depuis {{ $ad->utilisateur->created_at->format('M Y') }}</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="d-flex gap-3 justify-content-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-danger d-flex align-items-center px-4">
            <i class="fas fa-arrow-left me-2"></i>
            Retour
        </a>
        <a href="{{ route('member.annonces.edit', $ad->id) }}" class="btn btn-outline-primary d-flex align-items-center px-4">
            <i class="fas fa-edit me-2"></i>
            Modifier l'annonce
        </a>
    </div>
    @endforeach
</div>

<script>
// Image gallery functionality
function changeMainImage(thumbnail) {
    // Update main image
    const mainImage = document.querySelector('.main-image');
    if (mainImage) {
        mainImage.src = thumbnail.src;
    }
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(function(t) {
        t.classList.remove('border-primary');
        t.classList.add('border-secondary');
    });
    thumbnail.classList.remove('border-secondary');
    thumbnail.classList.add('border-primary');
}
</script>