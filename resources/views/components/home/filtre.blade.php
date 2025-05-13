<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'Annonces</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</head>
<body>

<div class="search-container">
    <form id="searchForm">
        <!-- Barre de recherche principale -->
        <div class="search-bar-container">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="keywords" class="search-input" placeholder="Rechercher des annonces...">
            </div>
            
            <div class="location-select-group">
                <i class="fa-solid fa-location-dot location-icon"></i>
                <select name="ville" class="location-select">
                    <option value="">Toutes les villes</option>
                    <option value="casablanca">Casablanca</option>
                    <option value="rabat">Rabat</option>
                    <option value="marrakech">Marrakech</option>
                    <option value="fes">Fès</option>
                    <option value="agadir">Agadir</option>
                    <option value="tanger">Tanger</option>
                    <option value="meknes">Meknès</option>
                    <option value="oujda">Oujda</option>
                    <option value="kenitra">Kénitra</option>
                    <option value="tetouan">Tétouan</option>
                    <option value="safi">Safi</option>
                    <option value="elhoceima">El Hoceima</option>
                    <option value="nador">Nador</option>
                    <option value="settat">Settat</option>
                    <option value="jadida">El Jadida</option>
                    <option value="ouarzazate">Ouarzazate</option>
                    <option value="dakhla">Dakhla</option>
                    <option value="laayoune">Laâyoune</option>
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

        <!-- Panneau de filtres avancés (caché par défaut) -->
        <!-- Moved above the sort buttons as requested -->
        <div id="advancedFilterPanel" class="advanced-filter-panel">
            <input type="hidden" name="advanced" value="" id="advancedInput">
            <input type="hidden" name="sort" value="" id="sortInput">
            
            <div class="advanced-filter-grid">
                <!-- Catégorie -->
                <div class="filter-group">
                    <label class="filter-label">Catégorie</label>
                    <select name="categorie" class="filter-select" id="categorieSelect">
                        <option value="">Toutes les catégories</option>
                        <option value="immobilier">Immobilier</option>
                        <option value="vehicules">Véhicules</option>
                        <option value="electronique">Électronique</option>
                        <option value="maison">Maison</option>
                        <option value="vetements">Vêtements</option>
                        <option value="animaux">Animaux</option>
                        <option value="sport">Sport</option>
                        <option value="autres">Autres</option>
                    </select>
                </div>
                
                <!-- Sous-catégorie -->
                <div class="filter-group">
                    <label class="filter-label">Sous-catégorie</label>
                    <select name="sous_categorie" class="filter-select" id="sousCategorieSelect">
                        <option value="">Toutes les sous-catégories</option>
                        <!-- Sera rempli dynamiquement par JavaScript -->
                    </select>
                </div>

                <!-- Prix -->
                <div class="filter-group">
                    <label class="filter-label">Prix (DH)</label>
                    <div class="price-range">
                        <input type="number" name="prix_min" class="filter-input" placeholder="Min" min="0">
                        <span class="price-separator">à</span>
                        <input type="number" name="prix_max" class="filter-input" placeholder="Max" min="0">
                    </div>
                </div>
            </div>

            <div class="filter-buttons">
                <button type="submit" class="btn-apply">
                    <i class="fa-solid fa-check"></i> Appliquer
                </button>
                <button type="button" class="btn-reset" id="resetBtn">
                    <i class="fa-solid fa-rotate-right"></i> Réinitialiser
                </button>
            </div>
        </div>

        <!-- Boutons de tri (now after the advanced filter panel) -->
        <div class="sort-buttons">
            <button type="button" class="btn-sort" data-sort="recent">
                <i class="fa-solid fa-clock"></i> Plus récent
            </button>
            <button type="button" class="btn-sort" data-sort="cher">
                <i class="fa-solid fa-arrow-up-wide-short"></i> Plus cher
            </button>
            <button type="button" class="btn-sort" data-sort="moins_cher">
                <i class="fa-solid fa-arrow-down-wide-short"></i> Moins cher
            </button>
        </div>
    </form>
</div>

<script>
// Mapping des sous-catégories par catégorie
const subCategories = {
    'immobilier': [
        {id: 'appartements', name: 'Appartements'},
        {id: 'maisons', name: 'Maisons et Villas'},
        {id: 'bureaux', name: 'Bureaux et Commerces'},
        {id: 'terrains', name: 'Terrains'},
        {id: 'locations', name: 'Locations vacances'}
    ],
    'vehicules': [
        {id: 'voitures', name: 'Voitures'},
        {id: 'motos', name: 'Motos'},
        {id: 'camions', name: 'Camions'},
        {id: 'pieces', name: 'Pièces et Accessoires'}
    ],
    'electronique': [
        {id: 'telephones', name: 'Téléphones'},
        {id: 'ordinateurs', name: 'Ordinateurs'},
        {id: 'tv', name: 'TV et Écrans'},
        {id: 'photo', name: 'Photo et Caméras'},
        {id: 'jeux', name: 'Consoles et Jeux vidéo'}
    ],
    'maison': [
        {id: 'meubles', name: 'Meubles'},
        {id: 'electromenager', name: 'Électroménager'},
        {id: 'decoration', name: 'Décoration'},
        {id: 'jardin', name: 'Jardin et Bricolage'}
    ],
    'vetements': [
        {id: 'homme', name: 'Homme'},
        {id: 'femme', name: 'Femme'},
        {id: 'enfant', name: 'Enfant'},
        {id: 'accessoires', name: 'Accessoires et Bijoux'}
    ],
    'animaux': [
        {id: 'chiens', name: 'Chiens'},
        {id: 'chats', name: 'Chats'},
        {id: 'oiseaux', name: 'Oiseaux'},
        {id: 'autres_animaux', name: 'Autres animaux'},
        {id: 'accessoires_animaux', name: 'Accessoires animaux'}
    ],
    'sport': [
        {id: 'fitness', name: 'Fitness et Musculation'},
        {id: 'velos', name: 'Vélos'},
        {id: 'football', name: 'Football'},
        {id: 'sports_hiver', name: 'Sports d\'hiver'},
        {id: 'sports_eau', name: 'Sports d\'eau'}
    ],
    'autres': [
        {id: 'livres', name: 'Livres et Magazines'},
        {id: 'instruments', name: 'Instruments de musique'},
        {id: 'collections', name: 'Collections'},
        {id: 'divers', name: 'Divers'}
    ]
};

// Fonction pour charger les sous-catégories en fonction de la catégorie sélectionnée
function loadSubcategories() {
    const categorieSelect = document.getElementById('categorieSelect');
    const sousCategorieSelect = document.getElementById('sousCategorieSelect');
    
    // Vider le select des sous-catégories
    sousCategorieSelect.innerHTML = '<option value="">Toutes les sous-catégories</option>';
    
    const selectedCategorie = categorieSelect.value;
    
    // Si une catégorie est sélectionnée, charger ses sous-catégories
    if (selectedCategorie && subCategories[selectedCategorie]) {
        subCategories[selectedCategorie].forEach(subCat => {
            const option = document.createElement('option');
            option.value = subCat.id;
            option.textContent = subCat.name;
            sousCategorieSelect.appendChild(option);
        });
    }
}

// Afficher/masquer le panneau de filtres avancés
function toggleAdvancedFilter() {
    const panel = document.getElementById('advancedFilterPanel');
    const advancedInput = document.getElementById('advancedInput');
    
    panel.classList.toggle('show');
    
    // Mettre à jour le champ caché pour conserver l'état du panneau
    if (panel.classList.contains('show')) {
        advancedInput.value = '1';
    } else {
        advancedInput.value = '';
    }
}

// Gérer les boutons de tri
function handleSortButtons() {
    const sortButtons = document.querySelectorAll('.btn-sort');
    const sortInput = document.getElementById('sortInput');
    
    sortButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Désactiver tous les boutons
            sortButtons.forEach(btn => btn.classList.remove('active'));
            
            // Activer ce bouton
            this.classList.add('active');
            
            // Mettre à jour le champ caché
            sortInput.value = this.dataset.sort;
        });
    });
}

// Réinitialiser tous les filtres
function resetFilters() {
    // Réinitialiser tous les champs du formulaire
    document.querySelectorAll('#searchForm input:not([type="hidden"]), #searchForm select').forEach(element => {
        element.value = '';
    });
    
    // Garder le panneau avancé visible
    document.getElementById('advancedInput').value = '1';
    
    // Réinitialiser les boutons de tri
    document.querySelectorAll('.btn-sort').forEach(btn => btn.classList.remove('active'));
    document.getElementById('sortInput').value = '';
    
    // Recharger les sous-catégories (vider la liste)
    loadSubcategories();
}

// Gérer la soumission du formulaire (pour démonstration uniquement)
function handleFormSubmit(event) {
    event.preventDefault();
    
    // Récupérer tous les champs du formulaire
    const formData = new FormData(document.getElementById('searchForm'));
    let searchParams = {};
    
    // Convertir les données du formulaire en objet
    for (let [key, value] of formData.entries()) {
        if (value) { // Ne pas inclure les champs vides
            searchParams[key] = value;
        }
    }
    
    // Afficher les paramètres de recherche (pour démonstration)
    console.log("Paramètres de recherche:", searchParams);
    
    // Dans une application réelle, vous redirigeriez vers une page de résultats
    // ou vous feriez une requête AJAX ici
    alert("Recherche effectuée! Consultez la console pour voir les paramètres.");
}

// Initialiser tous les événements lorsque le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter les écouteurs d'événements
    document.getElementById('toggleFiltersBtn').addEventListener('click', toggleAdvancedFilter);
    document.getElementById('categorieSelect').addEventListener('change', loadSubcategories);
    document.getElementById('resetBtn').addEventListener('click', resetFilters);
    document.getElementById('searchForm').addEventListener('submit', handleFormSubmit);
    
    // Initialiser les boutons de tri
    handleSortButtons();
    
    // Charger les sous-catégories si nécessaire
    loadSubcategories();
});
</script>

</body>
</html>