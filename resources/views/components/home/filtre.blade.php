<style>
    .search-container {
        max-width: 1200px;
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
        margin-top: 15px;
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
    }
</style>

<div class="search-container">
    <form method="GET" action="{{ route('category', ['category' => request()->category ?? '']) }}">
        <!-- Barre de recherche principale -->
        <div class="search-bar-container">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="keywords" class="search-input" placeholder="Rechercher des annonces..." value="{{ request('keywords') }}">
            </div>
            
            <div class="location-select-group">
                <i class="fa-solid fa-location-dot location-icon"></i>
                <select name="ville" class="location-select">
                    <option value="">Toutes les villes</option>
                    <option value="casablanca" {{ request('ville') == 'casablanca' ? 'selected' : '' }}>Casablanca</option>
                    <option value="rabat" {{ request('ville') == 'rabat' ? 'selected' : '' }}>Rabat</option>
                    <option value="marrakech" {{ request('ville') == 'marrakech' ? 'selected' : '' }}>Marrakech</option>
                    <option value="fes" {{ request('ville') == 'fes' ? 'selected' : '' }}>Fès</option>
                    <option value="agadir" {{ request('ville') == 'agadir' ? 'selected' : '' }}>Agadir</option>
                    <option value="tanger" {{ request('ville') == 'tanger' ? 'selected' : '' }}>Tanger</option>
                    <option value="meknes" {{ request('ville') == 'meknes' ? 'selected' : '' }}>Meknès</option>
                    <option value="oujda" {{ request('ville') == 'oujda' ? 'selected' : '' }}>Oujda</option>
                    <option value="kenitra" {{ request('ville') == 'kenitra' ? 'selected' : '' }}>Kénitra</option>
                    <option value="tetouan" {{ request('ville') == 'tetouan' ? 'selected' : '' }}>Tétouan</option>
                    <option value="safi" {{ request('ville') == 'safi' ? 'selected' : '' }}>Safi</option>
                    <option value="elhoceima" {{ request('ville') == 'elhoceima' ? 'selected' : '' }}>El Hoceima</option>
                    <option value="nador" {{ request('ville') == 'nador' ? 'selected' : '' }}>Nador</option>
                    <option value="settat" {{ request('ville') == 'settat' ? 'selected' : '' }}>Settat</option>
                    <option value="jadida" {{ request('ville') == 'jadida' ? 'selected' : '' }}>El Jadida</option>
                    <option value="ouarzazate" {{ request('ville') == 'ouarzazate' ? 'selected' : '' }}>Ouarzazate</option>
                    <option value="dakhla" {{ request('ville') == 'dakhla' ? 'selected' : '' }}>Dakhla</option>
                    <option value="laayoune" {{ request('ville') == 'laayoune' ? 'selected' : '' }}>Laâyoune</option>
                </select>
            </div>
            
            <button type="button" class="btn-advanced-filter" onclick="toggleAdvancedFilter()">
                <i class="fa-solid fa-sliders"></i>
                Filtres avancés
            </button>
            
            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                Rechercher
            </button>
        </div>

        <!-- Panneau de filtres avancés (caché par défaut) -->
        <div id="advancedFilterPanel" class="advanced-filter-panel">
            <div class="advanced-filter-grid">
                <!-- Catégorie -->
                <div class="filter-group">
                    <label class="filter-label">Catégorie</label>
                    <select name="categorie" class="filter-select">
                        <option value="">Toutes les catégories</option>
                        <option value="immobilier" {{ request('categorie') == 'immobilier' ? 'selected' : '' }}>Immobilier</option>
                        <option value="vehicules" {{ request('categorie') == 'vehicules' ? 'selected' : '' }}>Véhicules</option>
                        <option value="electronique" {{ request('categorie') == 'electronique' ? 'selected' : '' }}>Électronique</option>
                        <option value="maison" {{ request('categorie') == 'maison' ? 'selected' : '' }}>Maison</option>
                        <option value="vetements" {{ request('categorie') == 'vetements' ? 'selected' : '' }}>Vêtements</option>
                        <option value="animaux" {{ request('categorie') == 'animaux' ? 'selected' : '' }}>Animaux</option>
                        <option value="sport" {{ request('categorie') == 'sport' ? 'selected' : '' }}>Sport</option>
                        <option value="autres" {{ request('categorie') == 'autres' ? 'selected' : '' }}>Autres</option>
                    </select>
                </div>

                <!-- Prix -->
                <div class="filter-group">
                    <label class="filter-label">Prix (DH)</label>
                    <div class="price-range">
                        <input type="number" name="prix_min" class="filter-input" placeholder="Min" min="0" value="{{ request('prix_min') }}">
                        <span class="price-separator">à</span>
                        <input type="number" name="prix_max" class="filter-input" placeholder="Max" min="0" value="{{ request('prix_max') }}">
                    </div>
                </div>

                <!-- Type de vente -->
                <div class="filter-group">
                    <label class="filter-label">Type de vente</label>
                    <select name="type_vente" class="filter-select">
                        <option value="">Tous les types</option>
                        <option value="offre" {{ request('type_vente') == 'offre' ? 'selected' : '' }}>Offres</option>
                        <option value="demande" {{ request('type_vente') == 'demande' ? 'selected' : '' }}>Demandes</option>
                    </select>
                </div>
            </div>

            <div class="filter-buttons">
                <button type="submit" class="btn-apply">
                    <i class="fa-solid fa-check"></i> Appliquer
                </button>
                <button type="button" class="btn-reset" onclick="resetFilters()">
                    <i class="fa-solid fa-rotate-right"></i> Réinitialiser
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function toggleAdvancedFilter() {
    const panel = document.getElementById('advancedFilterPanel');
    panel.classList.toggle('show');
}

function resetFilters() {
    // Réinitialiser tous les champs du formulaire
    document.querySelectorAll('.search-container form input, .search-container form select').forEach(element => {
        element.value = '';
    });
    
    // Soumettre le formulaire
    document.querySelector('.search-container form').submit();
}
</script>