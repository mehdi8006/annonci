    <style>
        /* Réinitialisation des styles par défaut */
       

        /* Style pour le titre de section */
        .section-title1 {
            margin-top: 50px;
            margin-left: 8px;
            font-size: 20px;
            font-weight: bold;
            color: #000;
            margin-bottom: 15px;
        }

        /* Conteneur de défilement horizontal pour les cartes */
        .scroll-container1 {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            gap: 16px;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        /* Masquer les barres de défilement sur webkit (Chrome, Safari) */
        .scroll-container1::-webkit-scrollbar {
            display: none;
        }

        /* Masquer les barres de défilement sur Firefox et IE */
        .scroll-container1 {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Carte de produit principale */
        .product-card1 {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            min-width: 320px;
            max-width: 380px;
            height: 400px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex-shrink: 0;  /* Empêche la carte de rétrécir dans le conteneur flex */
            cursor: pointer;
        }

        /* Effet au survol de la carte */
        .product-card1:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        /* En-tête de la carte */
        .card-header1 {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Section utilisateur dans l'en-tête */
        .user-section1 {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Avatar utilisateur */
        .user-avatar1 {
            width: 40px;
            height: 40px;
            background-color: #e1e5eb;
            background: linear-gradient(135deg, #e1e5eb, #d4d8e0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Détails de l'utilisateur */
        .user-details1 {
            display: flex;
            flex-direction: column;
        }

        /* Nom d'utilisateur */
        .username1 {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
            letter-spacing: -0.02em;
        }

        /* Horodatage */
        .timestamp1 {
            color: #888;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
        }

        /* Bouton favori */
        .favorite-btn1 {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            font-size: 18px;
            color: #888;
            transition: color 0.3s ease, transform 0.3s ease;
            border-radius: 50%;
        }

        /* État survol du bouton favori */
        .favorite-btn1:hover {
            color: #ff4757;
            transform: scale(1.1);
        }

        /* État actif du bouton favori */
        .favorite-btn1.active {
            color: #ff4757;
            animation: heartBeat 0.8s ease-in-out infinite alternate;
        }

        /* Animation de battement de cœur */
        @keyframes heartBeat {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }

                /* Image du produit */
        .product-image1 {
            width: 100%;
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .product-image1 img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cette propriété permet de remplir l'espace sans déformer l'image */
            object-position: center; /* Cette propriété permet de centrer l'image */
        }

        /* Gradient superposé sur l'image */
        .product-image1::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(transparent 60%, rgba(0, 0, 0, 0.1) 100%);
            pointer-events: none;
        }

        /* Section des détails du produit */
        .product-details1 {
            padding: 16px;
        }

        /* Localisation du produit */
        .location1 {
            color: #4b5563;
            font-size: 13px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 400;
        }

        /* Titre du produit */
        .product-title1 {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        /* Prix du produit */
        .price1 {
            font-size: 24px;
            font-weight: 700;
            color: #ff9800;
            margin-bottom: 8px;
            display: flex;
            align-items: baseline;
            gap: 2px;
        }

        /* Devise du prix */
        .price1 .currency1 {
            font-size: 18px;
            margin-left: 2px;
            font-weight: 600;
            color: #000;
        }

        /* Responsive Design - Tablettes */
        @media (max-width: 768px) {
            .product-card1 {
                min-width: 280px;
                max-width: 320px;
            }
        }

        /* Responsive Design - Mobiles */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .card-header1 {
                padding: 10px 12px;
            }

            .user-avatar1 {
                width: 36px;
                height: 36px;
            }

            .product-details1 {
                padding: 12px;
            }

            .product-title1 {
                font-size: 15px;
            }

            .price1 {
                font-size: 22px;
            }
        }
    </style>
      <style>
    
        .card123 {
            position: relative;
            width:100%;
            height: 400px;
            background-color: #e6f2ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .plus-circle {
            position: relative;
            width: 100px;
            height: 100px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .plus {
            color: #5d4b8c;
            font-size: 50px;
            font-weight: bold;
        }
        
        .star1, .star2, .star3 {
            position: absolute;
            color: #ffc83d;
            font-size: 24px;
        }
        
        .star1 {
            top: -10px;
            right: 10px;
            font-size: 30px;
        }
        
        .star2 {
            bottom: 10px;
            left: -10px;
            font-size: 22px;
        }
        
        .star3 {
            top: 30px;
            left: -15px;
            font-size: 26px;
        }
        
        .text {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
       
        
    </style>
@props(['ads','title'])
    <!-- Titre de la section des offres spéciales -->
    <div class="section-title1">{{$title}}</div>

    <!-- Conteneur de défilement pour les cartes de produits -->
    <div class="scroll-container1" id="card-container">
        @foreach ($ads as $ad )
        <a href="{{ route('details',['id' =>$ad->id]) }}">
        <div class="product-card1">
            <div class="card-header1">
                <div class="user-section1">
                    <!-- Avatar utilisateur -->
                    <div class="user-avatar1">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <!-- Détails utilisateur -->
                    <div class="user-details1">
                        <span class="username1">{{$ad->utilisateur->nom}}</span>
                        <span class="timestamp1">
                            <i class="fa-solid fa-clock"></i>
                            il y a {{ $ad->date_publication->diffForHumans() }}
                           
                        </span>
                    </div>
                </div>
                <!-- Bouton favori -->
                <button class="favorite-btn1" aria-label="Ajouter aux favoris">
                    <i class="fa-solid fa-heart"></i>
                </button>
            </div>

            <!-- Image du produit -->
            <div class="product-image1">
    @foreach($ad->images as $image)
        @if($image->principale == 1)
            <img src="{{ asset($image->url) }}" alt="Image principale">
            @break
        @endif
    @endforeach
</div>


            <div class="product-details1">
                <!-- Localisation -->
                <div class="location1">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $ad->ville->region }},{{ $ad->ville->nom }}
                </div>
                
                <!-- Titre du produit -->
                <h2 class="product-title1">{{ $ad->titre }}</h2>
                
                <!-- Prix -->
                <div class="price1">
                    {{ $ad->prix }}<span class="currency1">DH</span>
                </div>
            </div>
        </div>   
        </a>

        @endforeach
        
<!-- Conteneur de défilement pour les cartes de produits -->
<div class="product-card1">
<div class="card123">
    <div class="plus-circle">
        <div class="plus">+</div>
        <div class="star1">✦</div>
        <div class="star2">✦</div>
        <div class="star3">✦</div>
    </div>
    <div class="text">Voir plus d'annonces</div>
</div>
</div>
    <!-- Conteneur de défilement pour les cartes de produits -->
    </div>
    <!-- Conteneur de défilement pour les cartes de produits -->
    <!-- Conteneur de défilement pour les cartes de produits -->

    <script>
        // JavaScript pour la fonctionnalité de défilement et des favoris
        document.addEventListener('DOMContentLoaded', function() {
            // Défilement fluide pour une meilleure expérience utilisateur
            const container = document.getElementById('card-container');
            
            // Gestionnaires de clics pour les boutons favoris
            const favoriteButtons = document.querySelectorAll('.favorite-btn1');
            favoriteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Empêche la propagation de l'événement à la carte parente
                    e.stopPropagation();
                    
                    // Basculer la classe active pour l'animation
                    this.classList.toggle('active');
                    
                    // Obtenir le titre du produit à partir de la carte parente
                    const card = this.closest('.product-card1');
                    const productTitle = card.querySelector('.product-title1').textContent;
                    const isFavorite = this.classList.contains('active');
                    
                    // Afficher une alerte selon l'état du favori
                    if (isFavorite) {
                        alert(`Ajouté aux favoris: ${productTitle}`);
                    } else {
                        alert(`Retiré des favoris: ${productTitle}`);
                    }
                });
            });
        });
    </script>
