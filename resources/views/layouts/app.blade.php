<!-- File: resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ isset($title) ? $title . ' - ' : '' }}Annoncia</title>
    
    <!-- Optimisation chargement des polices/icônes -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        /* Reset global des marges et paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        /* Styles de base du body */
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        
        /* Suppression des soulignements des liens */
        a {
            text-decoration: none;
        }
        
        /* Styles for pagecarte component */
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

        /* Style de base pour les cartes de produits */
        .product-card2 {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            width: calc(25% - 15px);      /* 4 cartes par ligne avec espacement */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Animation au survol de la carte */
        .product-card2:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        /* Prix */
        .price2 {
            font-size: 24px;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 12px;
            display: flex;
            align-items: baseline;
            gap: 2px;
        }

        .price2 .currency2 {
            font-size: 18px;
            margin-left: 2px;
            font-weight: 600;
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
        
        /* Écrans moyens (jusqu'à 1200px) - 3 cartes par ligne */
        @media (max-width: 1200px) {
            .product-card2 {
                width: calc(33.33% - 14px);
            }
        }

        /* Tablettes (jusqu'à 992px) - 2 cartes par ligne */
        @media (max-width: 992px) {
            .product-card2 {
                width: calc(50% - 10px);
            }
        }

        /* Mobiles (jusqu'à 768px) - 1 carte par ligne */
        @media (max-width: 768px) {
            .product-card2 {
                width: 100%;
            }
        }

        /* Petits mobiles (jusqu'à 480px) */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

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
        
        /* Tailwind-like utility classes */
        .container {
            width: 100%;
            padding-right: 1rem;
            padding-left: 1rem;
            margin-right: auto;
            margin-left: auto;
        }
        
        @media (min-width: 640px) {
            .container {
                max-width: 640px;
            }
        }
        
        @media (min-width: 768px) {
            .container {
                max-width: 768px;
            }
        }
        
        @media (min-width: 1024px) {
            .container {
                max-width: 1024px;
            }
        }
        
        @media (min-width: 1280px) {
            .container {
                max-width: 1280px;
            }
        }
        
        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .bg-white {
            background-color: #ffffff;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .p-4 {
            padding: 1rem;
        }
        
        .grid {
            display: grid;
        }
        
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        .text-gray-700 {
            color: #374151;
        }
        
        .mb-1 {
            margin-bottom: 0.25rem;
        }
        
        .w-full {
            width: 100%;
        }
        
        .rounded-md {
            border-radius: 0.375rem;
        }
        
        .border-gray-300 {
            border-color: #d1d5db;
        }
        
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .focus\:border-blue-500:focus {
            border-color: #3b82f6;
        }
        
        .focus\:ring:focus {
            ring-width: 2px;
        }
        
        .focus\:ring-blue-200:focus {
            ring-color: #bfdbfe;
        }
        
        .bg-blue-600 {
            background-color: #2563eb;
        }
        
        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8;
        }
        
        .text-white {
            color: #ffffff;
        }
        
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .rounded {
            border-radius: 0.25rem;
        }
        
        .text-center {
            text-align: center;
        }
        
        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .text-gray-400 {
            color: #9ca3af;
        }
        
        .text-5xl {
            font-size: 3rem;
        }
        
        .text-xl {
            font-size: 1.25rem;
        }
        
        .text-semibold {
            font-weight: 600;
        }
        
        .text-gray-500 {
            color: #6b7280;
        }
        
        .mt-2 {
            margin-top: 0.5rem;
        }
        
        .inline-block {
            display: inline-block;
        }
    </style>
    
    <!-- Additional Styles -->
    @yield('styles')
</head>
<body>
    <!-- Include the navbar component -->
    @include('components.nav')
    
    <!-- Main content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer section -->
    <footer class="bg-white py-6 mt-8 shadow-inner">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between">
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="text-lg font-bold mb-4">Annoncia</h3>
                    <p class="text-gray-600">Votre plateforme de petites annonces au Maroc</p>
                </div>
                
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="text-lg font-bold mb-4">Liens utiles</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('homeshow') }}" class="text-gray-600 hover:text-blue-600">Accueil</a></li>
                        <li><a href="{{ route('advanced-search') }}" class="text-gray-600 hover:text-blue-600">Recherche avancée</a></li>
                    </ul>
                </div>
                
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <h3 class="text-lg font-bold mb-4">Catégories populaires</h3>
                    <ul class="space-y-2">
                        <!-- You can dynamically generate these from your popular categories -->
                        <li><a href="#" class="text-gray-600 hover:text-blue-600">Immobilier</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600">Voitures</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600">Électronique</a></li>
                    </ul>
                </div>
                
                <div class="w-full md:w-1/4">
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <p class="text-gray-600">info@annoncia.ma</p>
                    <p class="text-gray-600">+212 5XX-XXXXXX</p>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-blue-600"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-600 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-600 hover:text-blue-600"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                <p class="text-gray-600">&copy; {{ date('Y') }} Annoncia. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('scripts')
</body>
</html>