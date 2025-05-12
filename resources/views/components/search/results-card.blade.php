<!-- File: resources/views/components/search/results-card.blade.php -->

@props(['annonces'])

<div class="container2">
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
                    <!-- Favorite button removed as requested -->
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
</div>