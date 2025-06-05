@extends('layouts.masterhome')

@section('main')

<div class="container-fluid custom-padding-top px-3 px-md-4 pb-4" >
    <!-- Search Filters -->
    @include('search.filters', [
        'categories' => $categories,
        'villes' => $villes,
        'sousCategories' => $sousCategories ?? [],
        'searchParams' => $searchParams ?? []
    ])
    
    <!-- Search Results Count -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body py-3">
                    <h2 class="h4 mb-2 fw-bold text-dark">
                        <i class="fa-solid fa-search me-2 text-primary"></i>
                        {{ $annonces->total() }} annonce(s) trouvée(s)
                    </h2>
                    @if(isset($searchTerm))
                        <p class="mb-0 text-muted">
                            <i class="fa-solid fa-quote-left me-1"></i>
                            Résultats pour : <span class="fw-medium text-dark">"{{ $searchTerm }}"</span>
                        </p>
                    @elseif(isset($categoryName))
                        <p class="mb-0 text-muted">
                            <i class="fa-solid fa-tag me-1"></i>
                            Annonces dans la catégorie : <span class="fw-medium text-dark">"{{ $categoryName }}"</span>
                        </p>
                    @elseif(isset($cityName))
                        <p class="mb-0 text-muted">
                            <i class="fa-solid fa-location-dot me-1"></i>
                            Annonces à : <span class="fw-medium text-dark">"{{ $cityName }}"</span>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row">
        <div class="col-12">
            @if($annonces->count() > 0)
                @include('search.resultscard', ['annonces' => $annonces])
            @else
                <!-- No Results Found -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fa-solid fa-search-minus text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="h5 text-muted mb-3">Aucune annonce trouvée</h3>
                        <p class="text-muted mb-4">
                            Essayez avec d'autres critères de recherche ou consultez toutes les annonces disponibles.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                            <a href="{{ route('search.advanced') }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-rotate-right me-2"></i>
                                Nouvelle recherche
                            </a>
                            <a href="{{ route('homeshow') }}" class="btn btn-primary">
                                <i class="fa-solid fa-home me-2"></i>
                                Voir toutes les annonces
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($annonces->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <nav aria-label="Pagination des résultats">
                    {{ $annonces->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
/* Custom padding top */
.custom-padding-top {
    padding-top: 80px !important;
}

/* Custom pagination styling to match Bootstrap theme */
.pagination .page-link {
    color: #6c757d;
    border-color: #dee2e6;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    color: #495057;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.pagination .page-item.disabled .page-link {
    color: #adb5bd;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Custom focus styles */
.pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Enhanced card hover for better UX */
.card {
    transition: all 0.3s ease;
}

/* Results count card styling */
.bg-light {
    background-color: #f8f9fa !important;
}

/* No results icon animation */
.fa-search-minus {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .custom-padding-top {
        padding-top: 60px !important; /* Slightly less padding on mobile */
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .h4 {
        font-size: 1.1rem !important;
    }
}

/* Button styling consistency */
.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}
</style>
@endsection