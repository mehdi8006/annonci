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