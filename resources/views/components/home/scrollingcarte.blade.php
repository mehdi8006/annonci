@props(['ads','title','add','cat'])

<style>
    /* Custom scrollbar hiding and smooth scroll */
    .horizontal-scroll {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .e{
        padding: 0px 70px ;
    }
    .horizontal-scroll::-webkit-scrollbar {
        display: none;
    }
    
    /* Custom hover effects */
    .property-card:hover .card-title {
        color: orange !important;
        transition: color 0.3s ease;
    }
    
    
    
    /* Custom styles for the "see more" card */
    .see-more-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px dashed #dee2e6;
        border-radius: 6px !important;
    }
    
    .plus-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    
    /* Image heights - 15% longer than width */
    .product-image {
        height: 230px;
    }
    
    @media (max-width: 1200px) {
        .product-image {
            height: 207px;
        }
    }
    
    @media (max-width: 768px) {
        .product-image {
            height: 184px;
        }
    }
    
    /* Card dimensions for 6 cards per row */
    .property-card {
        width: 200px;
        height: 350px;
        border-radius: 6px !important;
    }
    
    @media (max-width: 1200px) {
        .property-card {
            width: 180px;
            height: 325px;
        }
    }
    
    @media (max-width: 768px) {
        .property-card {
            width: 160px;
            height: 300px;
        }
    }
</style>
<div class="e">
<!-- Section Title -->
<div class="container-fluid px-3">
    <h4 class="fw-bold text-dark mb-4 mt-4">{{ $title }}</h4>
    
    <!-- Horizontal Scrolling Container -->
    <div class="horizontal-scroll pb-3">
        <div class="d-flex gap-3" style="width: max-content;">
            
            @foreach ($ads as $ad)
            <a href="{{ route('details',['id' => $ad->id]) }}" class="text-decoration-none">
                <div class="card property-card border-0 overflow-hidden">
                    
                    <!-- Product Image -->
                    <div class="position-relative product-image overflow-hidden" style="border-radius: 8px;">
                        @foreach($ad->images as $image)
                            @if($image->principale == 1)
                                <img src="{{ asset('storage/' . $image->url) }}" 
                                     alt="Image principale" 
                                     class="w-100 h-100" 
                                     style="object-fit: cover; object-position: center;">
                                @break
                            @endif
                        @endforeach
                    </div>
                    
                    <!-- Card Body with Product Details -->
                    <div class="card-body p-3">
                        <!-- Product Title -->
                        <h6 class="card-title fw-bold text-dark mb-2 lh-sm" style="font-size: 15px;">
                            {{ Str::limit($ad->titre, 35) }}
                        </h6>
                        
                        <!-- Price -->
                        <div class="mb-2">
                            <span class="h6 fw-bold text-dark mb-0 price-text">{{ number_format($ad->prix, 0, ',', ' ') }} DH</span>
                        </div>
                        
                        <!-- Location -->
                        <div class="text-muted mb-1" style="font-size: 13px;">
                            {{ $ad->ville->nom }} {{ substr($ad->ville->region, 0, 5) }}
                        </div>
                        
                        <!-- Timestamp -->
                        <div class="text-muted" style="font-size: 12px;">
                            {{ $ad->date_publication->locale('fr')->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            
            @if ($add != '0' && isset($cat))
            <!-- See More Ads Card -->
            <a href="{{ route('search.by.category', $cat->id) }}" class="text-decoration-none">
                <div class="card property-card see-more-card d-flex align-items-center justify-content-center border-0"> 
                    <div class="text-center">
                        <div class="plus-icon mx-auto">
                            <span class="h4 text-primary fw-bold mb-0">+</span>
                        </div>
                        <h6 class="fw-semibold text-dark mb-0">Voir plus</h6>
                        <small class="text-muted">d'annonces</small>
                    </div>
                </div>
            </a>
            @endif
            
        </div>
    </div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced smooth scrolling for better UX
    const scrollContainer = document.querySelector('.horizontal-scroll');
    
    if (scrollContainer) {
        // Optional: Add touch/swipe support for mobile
        let isDown = false;
        let startX;
        let scrollLeft;
        
        scrollContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - scrollContainer.offsetLeft;
            scrollLeft = scrollContainer.scrollLeft;
        });
        
        scrollContainer.addEventListener('mouseleave', () => {
            isDown = false;
        });
        
        scrollContainer.addEventListener('mouseup', () => {
            isDown = false;
        });
        
        scrollContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - scrollContainer.offsetLeft;
            const walk = (x - startX) * 2;
            scrollContainer.scrollLeft = scrollLeft - walk;
        });
    }
});
</script>