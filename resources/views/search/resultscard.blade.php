<div class="container2">
    <div class="products-grid2">
        @foreach($annonces as $annonce)
    <a href="{{ route('details',['id' =>$annonce->id]) }}">

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
                                {{ $annonce->date_publication->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <!-- Favorites section removed -->
                </div>

                <div class="product-image2" style="background-image: url('{{ $annonce->images->where('principale', true)->first()->url ?? '/api/placeholder/380/240' }}')"></div>

                <div class="product-details2">
                    <div class="location2">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $annonce->sousCategorie ? $annonce->sousCategorie->nom : $annonce->categorie->nom }} dans {{ $annonce->ville->nom }}
                    </div>
                    
                    <h2 class="product-title2"> {{ Str::limit($annonce->titre, 45) }} </h2>
                    
                    <div class="price2">
                        {{ number_format($annonce->prix, 0, ',', ' ') }}<span class="currency2">DH</span>
                    </div>

                    <div class="categories2">
                        <span class="category-tag2">
                            <i class="fa-solid fa-tag"></i>
                            {{ $annonce->categorie->nom }}
                        </span>
                        @if($annonce->sousCategorie)
                            <span class="category-tag2">
                                <i class="fa-solid fa-tag"></i>
                                {{ $annonce->sousCategorie->nom }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
    </a>
        @endforeach
    </div>
</div>

<style>
    /* Base link styling */
a {
    text-decoration: none;
    color: inherit;
}

/* Container principal */
.container2 {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* Grille de produits */
.products-grid2 {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}

/* Style for anchor tags in products grid - NEW */
.products-grid2 > a {
    text-decoration: none;
    color: inherit;
    display: block;
    width: calc(33.33% - 14px); /* Match the original product-card2 width */
    transition: transform 0.3s ease; /* Move hover effect to the anchor */
}

/* Maintain the hover effects on the anchor rather than default link behavior - NEW */
.products-grid2 > a:hover {
    text-decoration: none;
    color: inherit;
    transform: translateY(-5px); /* Move hover effect to the anchor */
}

/* Style de base pour les cartes de produits */
.product-card2 {
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    width: 100%; /* Changed from calc(33.33% - 14px) to take full anchor width */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease; /* Keep only box-shadow transition here */
}

/* Animation au survol de la carte - Modified */
.product-card2:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    /* transform moved to the anchor tag */
}

/* En-tête de la carte */
.card-header2 {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

/* Section utilisateur dans l'en-tête */
.user-section2 {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Avatar d'utilisateur */
.user-avatar2 {
    width: 40px;
    height: 40px;
    background-color: #e1e5eb;
    background: linear-gradient(135deg, #e1e5eb, #d4d8e0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    position: relative;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Icône dans l'avatar */
.avatar-icon2 {
    font-size: 20px;
}

/* Détails de l'utilisateur */
.user-details2 {
    display: flex;
    flex-direction: column;
}

/* Nom d'utilisateur */
.username2 {
    font-weight: 600;
    color: #111827;
    font-size: 14px;
    letter-spacing: -0.02em;
}

/* Horodatage */
.timestamp2 {
    color: #888;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 2px;
}

.timestamp2 i {
    font-size: 11px;
    opacity: 0.7;
}

/* Image du produit */
.product-image2 {
    width: 100%;
    height: 240px;
    background-image: url('/api/placeholder/380/240');
    background-size: cover;
    background-position: center;
    position: relative;
    overflow: hidden;
}

/* Dégradé en bas de l'image */
.product-image2::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(transparent 60%, rgba(0, 0, 0, 0.1) 100%);
    pointer-events: none;
}

/* Détails du produit */
.product-details2 {
    padding: 16px;
}

/* Localisation */
.location2 {
    color: #4b5563;
    font-size: 13px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 400;
}

.location2 i {
    font-size: 12px;
    color: #9ca3af;
}

/* Titre du produit */
.product-title2 {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
    letter-spacing: -0.02em;
    line-height: 1.3;
}

/* Prix */
.price2 {
    font-size: 20px;
    font-weight: 700;
    color: orange;
    margin-bottom: 12px;
    display: flex;
    align-items: baseline;
    gap: 2px;
}

.price2 .currency2 {
    color: black;
    font-size: 18px;
    margin-left: 2px;
    font-weight: 500;
}

/* Conteneur de catégories */
.categories2 {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Étiquettes de catégorie */
.category-tag2 {
    background-color: #f1f5f9;
    color: #4b5563;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.category-tag2:hover {
    background-color: #e2e8f0;
}

.category-tag2 i {
    font-size: 11px;
    opacity: 0.8;
}

/* Responsive design pour différentes tailles d'écran */

/* Écrans moyens (jusqu'à 1200px) - 2 cartes par ligne */
@media (max-width: 1200px) {
    .products-grid2 > a {
        width: calc(50% - 10px);
    }
}

/* Tablettes (jusqu'à 768px) - 1 carte par ligne */
@media (max-width: 768px) {
    .products-grid2 > a {
        width: 100%;
    }
}

/* Petits mobiles (jusqu'à 480px) */
@media (max-width: 480px) {
    .container2 {
        padding: 10px;
    }

    .card-header2 {
        padding: 10px 12px;
    }

    .user-avatar2 {
        width: 36px;
        height: 36px;
    }

    .user-details2 .username2 {
        font-size: 13px;
    }

    .timestamp2 {
        font-size: 11px;
    }

    .product-details2 {
        padding: 12px;
    }

    .product-title2 {
        font-size: 15px;
    }

    .price2 {
        font-size: 22px;
    }

    .price2 .currency2 {
        font-size: 16px;
    }
}
</style>

<script>
    // JavaScript related to favorites has been removed
    document.addEventListener('DOMContentLoaded', function() {
        // Any remaining non-favorite related functionality can go here
    });
</script>