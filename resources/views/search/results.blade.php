@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="text-2xl font-bold mb-2">{{ $title }}</h1>
        
        @if(isset($type) && $type == 'search')
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Keywords -->
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700 mb-1">Mots-clés</label>
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    
                    <!-- Category -->
                    <div>
                        <label for="categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="categorie" id="categorie" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Subcategory (dynamic) -->
                    <div>
                        <label for="sous_categorie" class="block text-sm font-medium text-gray-700 mb-1">Sous-catégorie</label>
                        <select name="sous_categorie" id="sous_categorie" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Toutes les sous-catégories</option>
                            @if(isset($sousCategories) && count($sousCategories) > 0)
                                @foreach($sousCategories as $sousCat)
                                    <option value="{{ $sousCat->id }}" {{ request('sous_categorie') == $sousCat->id ? 'selected' : '' }}>{{ $sousCat->nom }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <!-- City -->
                    <div>
                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                        <select name="ville" id="ville" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Toutes les villes</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}" {{ request('ville') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Price range (min) -->
                    <div>
                        <label for="prix_min" class="block text-sm font-medium text-gray-700 mb-1">Prix minimum (DH)</label>
                        <input type="number" name="prix_min" id="prix_min" value="{{ request('prix_min') }}" placeholder="Min" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    
                    <!-- Price range (max) -->
                    <div>
                        <label for="prix_max" class="block text-sm font-medium text-gray-700 mb-1">Prix maximum (DH)</label>
                        <input type="number" name="prix_max" id="prix_max" value="{{ request('prix_max') }}" placeholder="Max" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    
                    <!-- Sort options -->
                    <div>
                        <label for="tri" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                        <select name="tri" id="tri" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="date_desc" {{ request('tri') == 'date_desc' ? 'selected' : '' }}>Plus récentes</option>
                            <option value="date_asc" {{ request('tri') == 'date_asc' ? 'selected' : '' }}>Plus anciennes</option>
                            <option value="prix_asc" {{ request('tri') == 'prix_asc' ? 'selected' : '' }}>Prix: croissant</option>
                            <option value="prix_desc" {{ request('tri') == 'prix_desc' ? 'selected' : '' }}>Prix: décroissant</option>
                        </select>
                    </div>
                    
                    <!-- Submit button -->
                    <div class="md:col-span-2 lg:col-span-1 flex items-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            <i class="fa-solid fa-search mr-2"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        @if(count($annonces) > 0)
            <div class="products-grid2">
                @foreach($annonces as $annonce)
                    <div class="product-card2">
                        <div class="card-header2">
                            <div class="user-section2">
                                <div class="user-avatar2">
                                    <i class="fa-solid fa-user avatar-icon2"></i>
                                </div>
                                <div class="user-details2">
                                    <span class="username2">{{ $annonce->utilisateur->nom }}</span>
                                    <span class="timestamp2">
                                        <i class="fa-solid fa-clock"></i>
                                        {{ $annonce->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            
                            @if(session()->has('user_id'))
                                <form action="{{ route('member.favoris.add', $annonce->id) }}" method="POST" class="favorite-form">
                                    @csrf
                                    <button type="submit" class="favorite-btn2 {{ $annonce->favorites->where('id_utilisateur', session('user_id'))->count() > 0 ? 'active' : '' }}" aria-label="Ajouter aux favoris">
                                        <i class="fa-solid fa-heart"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('form') }}" class="favorite-btn2" aria-label="Ajouter aux favoris">
                                    <i class="fa-solid fa-heart"></i>
                                </a>
                            @endif
                        </div>

                        <a href="{{ route('details', $annonce->id) }}">
                            <div class="product-image2" style="background-image: url('{{ $annonce->images->first() ? asset($annonce->images->first()->url) : '/api/placeholder/380/240' }}')"></div>
                        </a>

                        <div class="product-details2">
                            <div class="location2">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $annonce->categorie->nom }} dans {{ $annonce->ville->nom }}
                            </div>
                            
                            <h2 class="product-title2">{{ $annonce->titre }}</h2>
                            
                            <div class="price2">
                                {{ number_format($annonce->prix, 0, ',', ' ') }}<span class="currency2">DH</span>
                            </div>

                            <div class="categories2">
                                <span class="category-tag2">
                                    <i class="fa-solid fa-layer-group"></i>
                                    {{ $annonce->categorie->nom }}
                                </span>
                                
                                @if($annonce->sousCategorie)
                                <span class="category-tag2">
                                    <i class="fa-solid fa-tag"></i>
                                    {{ $annonce->sousCategorie->nom }}
                                </span>
                                @endif
                                
                                <span class="category-tag2">
                                    <i class="fa-solid fa-map-marker-alt"></i>
                                    {{ $annonce->ville->nom }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $annonces->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <i class="fa-solid fa-search text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700">Aucune annonce trouvée</h3>
                <p class="text-gray-500 mt-2">Essayez de modifier vos critères de recherche pour trouver ce que vous cherchez.</p>
                
                @if(isset($type) && ($type == 'categorie' || $type == 'ville'))
                    <a href="{{ route('homeshow') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        <i class="fa-solid fa-home mr-2"></i> Retour à l'accueil
                    </a>
                @endif
            </div>
        @endif
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
        
        // Handle favorite button clicks with AJAX
        const favoriteForms = document.querySelectorAll('.favorite-form');
        
        favoriteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const button = this.querySelector('.favorite-btn2');
                const formAction = this.getAttribute('action');
                
                fetch(formAction, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.classList.toggle('active');
                    }
                })
                .catch(error => console.error('Error toggling favorite:', error));
            });
        });
    });
</script>
@endsection