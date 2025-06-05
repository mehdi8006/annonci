<div class="container-fluid">
    <form id="searchForm" action="{{ route('search.advanced') }}" method="GET">
        <!-- Main Search Bar -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <!-- Search Input -->
                    <div class="col-12 col-md-4">
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" name="keywords" class="form-control ps-5" 
                                   placeholder="Rechercher des annonces..." 
                                   value="{{ $searchParams['keywords'] ?? '' }}">
                        </div>
                    </div>
                    
                    <!-- Location Select -->
                    <div class="col-12 col-md-3">
                        <div class="position-relative">
                            <i class="fa-solid fa-location-dot position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="z-index: 10;"></i>
                            <select name="ville" class="form-select ps-5">
                                <option value="">Toutes les villes</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}" {{ (isset($searchParams['ville']) && $searchParams['ville'] == $ville->id) ? 'selected' : '' }}>
                                        {{ $ville->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Advanced Filter Button -->
                    <div class="col-12 col-md-2">
                        <button type="button" class="btn btn-outline-warning w-100" id="toggleFiltersBtn">
                            <i class="fa-solid fa-sliders me-2"></i>
                            Filtres
                        </button>
                    </div>
                    
                    <!-- Search Button -->
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filter Panel -->
        <div id="advancedFilterPanel" class="card border-0 shadow-sm mb-4 {{ isset($searchParams['advanced']) && $searchParams['advanced'] == '1' ? '' : 'd-none' }}">
            <div class="card-body">
                <input type="hidden" name="advanced" value="{{ $searchParams['advanced'] ?? '' }}" id="advancedInput">
                <input type="hidden" name="sort" value="{{ $searchParams['sort'] ?? '' }}" id="sortInput">
                
                <div class="row g-3">
                    <!-- Category -->
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-medium text-muted">Catégorie</label>
                        <select name="categorie" class="form-select" id="categorieSelect" onchange="this.form.submit()">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ (isset($searchParams['categorie']) && $searchParams['categorie'] == $categorie->id) ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Subcategory -->
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-medium text-muted">Sous-catégorie</label>
                        <select name="sous_categorie" class="form-select" id="sousCategorieSelect">
                            <option value="">Toutes les sous-catégories</option>
                            @if(isset($sousCategories) && count($sousCategories) > 0)
                                @foreach($sousCategories as $sousCat)
                                    <option value="{{ $sousCat->id }}" {{ (isset($searchParams['sous_categorie']) && $searchParams['sous_categorie'] == $sousCat->id) ? 'selected' : '' }}>
                                        {{ $sousCat->nom }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-medium text-muted">Prix (DH)</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" name="prix_min" class="form-control" 
                                   placeholder="Min" min="0" value="{{ $searchParams['prix_min'] ?? '' }}">
                            <span class="text-muted fw-bold">à</span>
                            <input type="number" name="prix_max" class="form-control" 
                                   placeholder="Max" min="0" value="{{ $searchParams['prix_max'] ?? '' }}">
                        </div>
                    </div>
                </div>

                <!-- Filter Action Buttons -->
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-check me-2"></i>Appliquer
                    </button>
                    <a href="{{ route('search.advanced') }}" class="btn btn-outline-secondary" id="resetBtn">
                        <i class="fa-solid fa-rotate-right me-2"></i>Réinitialiser
                    </a>
                </div>
            </div>
        </div>

        <!-- Sort Buttons -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="submit" name="sort" value="recent" 
                    class="btn btn-sm {{ (isset($searchParams['sort']) && $searchParams['sort'] == 'recent') ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="fa-solid fa-clock me-1"></i>Plus récent
            </button>
            <button type="submit" name="sort" value="cher" 
                    class="btn btn-sm {{ (isset($searchParams['sort']) && $searchParams['sort'] == 'cher') ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="fa-solid fa-arrow-up-wide-short me-1"></i>Plus cher
            </button>
            <button type="submit" name="sort" value="moins_cher" 
                    class="btn btn-sm {{ (isset($searchParams['sort']) && $searchParams['sort'] == 'moins_cher') ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="fa-solid fa-arrow-down-wide-short me-1"></i>Moins cher
            </button>
        </div>
    </form>
</div>

<style>
/* Custom focus styles for form elements */
.form-control:focus,
.form-select:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
}

/* Ensure icons are properly positioned */
.position-relative .fa-solid {
    pointer-events: none;
}

/* Smooth transition for advanced panel */
#advancedFilterPanel {
    transition: all 0.3s ease;
}

/* Card shadow customization */
.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

/* Button hover effects */
.btn-outline-warning:hover {
    background-color: #f59e0b;
    border-color: #f59e0b;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        justify-content: center;
    }
    
    .btn-sm {
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle advanced filters
    const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
    const advancedFilterPanel = document.getElementById('advancedFilterPanel');
    const advancedInput = document.getElementById('advancedInput');
    
    if (toggleFiltersBtn && advancedFilterPanel && advancedInput) {
        toggleFiltersBtn.addEventListener('click', function() {
            // Toggle visibility
            if (advancedFilterPanel.classList.contains('d-none')) {
                advancedFilterPanel.classList.remove('d-none');
                advancedInput.value = '1';
                toggleFiltersBtn.innerHTML = '<i class="fa-solid fa-sliders me-2"></i>Masquer';
            } else {
                advancedFilterPanel.classList.add('d-none');
                advancedInput.value = '';
                toggleFiltersBtn.innerHTML = '<i class="fa-solid fa-sliders me-2"></i>Filtres';
            }
        });
    }
    
    // Set initial button text based on panel state
    if (advancedFilterPanel && !advancedFilterPanel.classList.contains('d-none')) {
        toggleFiltersBtn.innerHTML = '<i class="fa-solid fa-sliders me-2"></i>Masquer';
    }
});
</script>