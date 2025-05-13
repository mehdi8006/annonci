<div class="search-container">
    <form id="searchForm" action="{{ route('search.advanced') }}" method="GET">
        <!-- Barre de recherche principale -->
        <div class="search-bar-container">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="keywords" class="search-input" placeholder="Rechercher des annonces..." value="{{ $searchParams['keywords'] ?? '' }}">
            </div>
            
            <div class="location-select-group">
                <i class="fa-solid fa-location-dot location-icon"></i>
                <select name="ville" class="location-select">
                    <option value="">Toutes les villes</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}" {{ (isset($searchParams['ville']) && $searchParams['ville'] == $ville->id) ? 'selected' : '' }}>
                            {{ $ville->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="button" class="btn-advanced-filter" id="toggleFiltersBtn">
                <i class="fa-solid fa-sliders"></i>
                Filtres avancés
            </button>
            
            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                Rechercher
            </button>
        </div>

        <!-- Panneau de filtres avancés -->
        <div id="advancedFilterPanel" class="advanced-filter-panel {{ isset($searchParams['advanced']) && $searchParams['advanced'] == '1' ? 'show' : '' }}">
            <input type="hidden" name="advanced" value="{{ $searchParams['advanced'] ?? '' }}" id="advancedInput">
            <input type="hidden" name="sort" value="{{ $searchParams['sort'] ?? '' }}" id="sortInput">
            
            <div class="advanced-filter-grid">
                <!-- Catégorie -->
                <div class="filter-group">
                    <label class="filter-label">Catégorie</label>
                    <select name="categorie" class="filter-select" id="categorieSelect" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ (isset($searchParams['categorie']) && $searchParams['categorie'] == $categorie->id) ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sous-catégorie -->
                <div class="filter-group">
                    <label class="filter-label">Sous-catégorie</label>
                    <select name="sous_categorie" class="filter-select" id="sousCategorieSelect">
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

                <!-- Prix -->
                <div class="filter-group">
                    <label class="filter-label">Prix (DH)</label>
                    <div class="price-range">
                        <input type="number" name="prix_min" class="filter-input" placeholder="Min" min="0" value="{{ $searchParams['prix_min'] ?? '' }}">
                        <span class="price-separator">à</span>
                        <input type="number" name="prix_max" class="filter-input" placeholder="Max" min="0" value="{{ $searchParams['prix_max'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="filter-buttons">
                <button type="submit" class="btn-apply">
                    <i class="fa-solid fa-check"></i> Appliquer
                </button>
                <a href="{{ route('search.advanced') }}" class="btn-reset" id="resetBtn">
                    <i class="fa-solid fa-rotate-right"></i> Réinitialiser
                </a>
            </div>
        </div>

        <!-- Boutons de tri -->
        <div class="sort-buttons">
            <button type="submit" name="sort" value="recent" class="btn-sort {{ (isset($searchParams['sort']) && $searchParams['sort'] == 'recent') ? 'active' : '' }}">
                <i class="fa-solid fa-clock"></i> Plus récent
            </button>
            <button type="submit" name="sort" value="cher" class="btn-sort {{ (isset($searchParams['sort']) && $searchParams['sort'] == 'cher') ? 'active' : '' }}">
                <i class="fa-solid fa-arrow-up-wide-short"></i> Plus cher
            </button>
            <button type="submit" name="sort" value="moins_cher" class="btn-sort {{ (isset($searchParams['sort']) && $searchParams['sort'] == 'moins_cher') ? 'active' : '' }}">
                <i class="fa-solid fa-arrow-down-wide-short"></i> Moins cher
            </button>
        </div>
    </form>
</div>

<style>
    .search-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .search-bar-container {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input-group {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 15px;
        transition: border-color 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #ea580c;
        box-shadow: 0 0 0 2px rgba(234, 88, 12, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
    }

    .location-select-group {
        min-width: 200px;
        position: relative;
    }

    .location-select {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 15px;
        background-color: white;
        cursor: pointer;
        appearance: none;
        transition: border-color 0.3s;
    }

    .location-select:focus {
        outline: none;
        border-color: #ea580c;
        box-shadow: 0 0 0 2px rgba(234, 88, 12, 0.1);
    }

    .location-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
    }

    .btn-advanced-filter {
        background-color: #ea580c;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s;
    }

    .btn-advanced-filter:hover {
        background-color: #d9480f;
    }

    .btn-search {
        background-color: #2563eb;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s;
    }

    .btn-search:hover {
        background-color: #1d4ed8;
    }

    .advanced-filter-panel {
        display: none;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        animation: slideDown 0.3s ease-out;
    }

    .advanced-filter-panel.show {
        display: block;
    }

    .advanced-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-size: 14px;
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
    }

    .filter-select, .filter-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: #ea580c;
        box-shadow: 0 0 0 2px rgba(234, 88, 12, 0.1);
    }

    .price-range {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .price-separator {
        color: #999;
        font-weight: bold;
    }

    .filter-buttons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-apply {
        background-color: #ea580c;
        color: white;
        padding: 10px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-reset {
        background-color: transparent;
        color: #666;
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Styles pour les boutons de tri */
    .sort-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        padding: 0 10px;
        flex-wrap: wrap;
    }

    .btn-sort {
        background-color: #f3f4f6;
        color: #4b5563;
        padding: 8px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-sort:hover {
        background-color: #e5e7eb;
    }

    .btn-sort.active {
        background-color: #dbeafe;
        color: #2563eb;
        border-color: #93c5fd;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .search-bar-container {
            flex-direction: column;
        }
        
        .search-input-group, .location-select-group {
            width: 100%;
        }

        .sort-buttons {
            justify-content: center;
        }
    }
</style>

<script>
// JavaScript pour le styling uniquement
document.addEventListener('DOMContentLoaded', function() {
    // Toggle des filtres avancés
    const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
    const advancedFilterPanel = document.getElementById('advancedFilterPanel');
    const advancedInput = document.getElementById('advancedInput');
    
    if (toggleFiltersBtn && advancedFilterPanel && advancedInput) {
        toggleFiltersBtn.addEventListener('click', function() {
            advancedFilterPanel.classList.toggle('show');
            
            // Mettre à jour le champ caché
            if (advancedFilterPanel.classList.contains('show')) {
                advancedInput.value = '1';
            } else {
                advancedInput.value = '';
            }
        });
    }
});
</script>