@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h1 class="text-white text-2xl font-bold flex items-center">
                <i class="fa-solid fa-search-plus mr-3"></i>
                Recherche avancée
            </h1>
        </div>
        
        <form action="{{ route('search') }}" method="GET" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Keywords -->
                <div class="col-span-full">
                    <label for="keyword" class="block text-sm font-medium text-gray-700 mb-1">Mots-clés</label>
                    <input type="text" name="keyword" id="keyword" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-lg py-3" placeholder="Que recherchez-vous ?">
                </div>
                
                <!-- Category -->
                <div>
                    <label for="categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select name="categorie" id="categorie" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Subcategory (dynamic) -->
                <div>
                    <label for="sous_categorie" class="block text-sm font-medium text-gray-700 mb-1">Sous-catégorie</label>
                    <select name="sous_categorie" id="sous_categorie" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Toutes les sous-catégories</option>
                    </select>
                </div>
                
                <!-- City -->
                <div>
                    <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <select name="ville" id="ville" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Toutes les villes</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sort options -->
                <div>
                    <label for="tri" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                    <select name="tri" id="tri" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="date_desc">Plus récentes</option>
                        <option value="date_asc">Plus anciennes</option>
                        <option value="prix_asc">Prix: croissant</option>
                        <option value="prix_desc">Prix: décroissant</option>
                    </select>
                </div>
                
                <!-- Price range -->
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Fourchette de prix (DH)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input type="number" name="prix_min" id="prix_min" placeholder="Prix minimum" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <input type="number" name="prix_max" id="prix_max" placeholder="Prix maximum" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                </div>
                
                <!-- Submit button -->
                <div class="col-span-full mt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-300 flex items-center justify-center">
                        <i class="fa-solid fa-search mr-2"></i> Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Dynamic subcategories loading when category changes
    document.addEventListener('DOMContentLoaded', function() {
        const categorieSelect = document.getElementById('categorie');
        const sousCategorieSelect = document.getElementById('sous_categorie');
        
        if (categorieSelect && sousCategorieSelect) {
            categorieSelect.addEventListener('change', function() {
                const categorieId = this.value;
                
                // Clear subcategory options
                sousCategorieSelect.innerHTML = '<option value="">Toutes les sous-catégories</option>';
                
                if (categorieId) {
                    // Fetch subcategories via AJAX
                    fetch(`/api/categories/${categorieId}/sous-categories`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(sousCategorie => {
                                const option = document.createElement('option');
                                option.value = sousCategorie.id;
                                option.textContent = sousCategorie.nom;
                                sousCategorieSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error loading subcategories:', error));
                }
            });
        }
    });
</script>
@endsection