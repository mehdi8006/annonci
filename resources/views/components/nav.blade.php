<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Optimisation chargement des polices/icônes -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <title>Barre de navigation complète - Annoncia</title>
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

        /* Container principal de la barre de navigation */
        nav.navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 10px 5%;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: sticky; /* Reste en haut lors du scroll */
            top: 0;
            z-index: 1000;
        }

        /* Styles du logo avec texte */
        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2563eb;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideInLeft 0.6s ease forwards; /* Animation d'entrée */
        }

        /* Navigation principale (contient les dropdowns et la recherche) */
        .main-navigation {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
            margin: 0 5%;
        }

        /* Containers pour les dropdowns de catégories et villes */
        .category-dropdown, .city-dropdown {
            position: relative;
            display: inline-block;
        }

        /* Buttons pour déclencher les dropdowns */
        .dropdown-button {
            background-color: transparent;
            border: none;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1f2937;
            font-weight: 500;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        /* Effet hover sur les boutons dropdown */
        .dropdown-button:hover {
            background-color: #f3f4f6;
        }

        .dropdown-button i {
            color: #6b7280;
        }

        /* Animation de rotation du chevron */
        .chevron {
            transition: transform 0.2s ease;
        }

        .dropdown-button:hover .chevron {
            transform: rotate(180deg);
        }

        /* Style des menus dropdown */
        .dropdown-menu {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 8px;
            min-width: 250px;
            padding: 8px 0;
            opacity: 0; /* Invisible par défaut */
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 1000;
        }

        /* Affichage du dropdown au hover */
        .category-dropdown:hover .dropdown-menu,
        .city-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Container de la barre de recherche */
        .search-container {
            flex: 1;
            max-width: 400px;
            position: relative;
            opacity: 0;
            animation: slideUpFade 0.6s ease 0.2s forwards; /* Animation d'entrée avec délai */
            will-change: transform, opacity; /* Optimisation performance */
        }

        /* Barre de recherche elle-même */
        .search-bar {
            display: flex;
            position: relative;
        }

        /* Input de recherche */
        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            background: #f1f5f9;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Styles du focus de l'input */
        .search-bar input:focus,
        .search-bar input:focus-visible {
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        /* Bouton de recherche */
        .search-bar button {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            padding: 0 16px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: transform 0.2s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Effet hover du bouton de recherche */
        .search-bar button:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.06);
        }

        /* Container des actions (connexion/déposer une annonce) */
        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            opacity: 0;
            animation: zoomIn 0.5s ease 0.4s forwards; /* Animation d'entrée avec délai */
            will-change: transform, opacity;
        }

        /* Styles de base des boutons */
        .btn {
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Styles du focus visuel pour l'accessibilité */
        .btn:focus-visible,
        .search-bar button:focus-visible {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
        }

        /* Bouton "Déposer une annonce" */
        .btn-publish {
            background-color: #ea580c;
            color: white;
            box-shadow: 5px 4px 6px rgba(249, 115, 22, 0.1);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-publish:hover {
            background-color: #d9480f;
            transform: translateY(-2px);
        }

        /* Bouton connexion */
        .btn-login {
            background-color: transparent;
            color: #2563eb;
            border: 2px solid #e2e8f0;
        }

        .btn-login:hover {
            background-color: rgba(37, 99, 235, 0.05);
            border-color: #2563eb;
        }

        /* Sections des menus dropdown */
        .dropdown-section {
            padding: 8px 0;
        }

        /* Items individuels des dropdowns */
        .dropdown-item {
            padding: 8px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #4b5563;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.15s ease;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dropdown-item i {
            width: 20px;
            text-align: left;
            color: #6b7280;
        }

        /* Séparateur entre sections */
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 4px 16px;
        }

        /* En-tête de section */
        .section-header {
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 0.05em;
        }

        /* Styles spécifiques au dropdown des villes */
        .city-dropdown .dropdown-menu {
            min-width: 300px;
            max-width: 350px;
        }

        /* Liste scrollable des villes */
        .city-list {
            max-height: 300px;
            overflow-y: auto;
            padding: 4px 0;
        }

        /* Personnalisation de la scrollbar */
        .city-list::-webkit-scrollbar {
            width: 6px;
        }

        .city-list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .city-list::-webkit-scrollbar-thumb {
            background: #c2c2c2;
            border-radius: 3px;
        }

        .city-list::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Media query pour écrans moyens et grands */
        @media (min-width: 769px) {
            .search-container {
                margin: 0;
                flex: 1;
            }
        }

        /* Media query pour tablettes et mobiles */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: stretch;
            }

            .main-navigation {
                flex-wrap: wrap;
                margin: 12px 0;
                justify-content: center;
            }

            .search-container {
                justify-content: center;
                max-width: 100%;
                width: 100%;
            }

            .actions {
                justify-content: center;
                width: 100%;
            }

            .search-bar button {
                right: 5px;
                top: 5px;
                bottom: 5px;
                padding: 0 14px;
            }
        }

        /* Animations personnalisées */
        
        /* Animation d'entrée depuis la gauche */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animation d'entrée du bas avec fade */
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation zoom en entrée */
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
     <style>
        .profile-button102 {
            background-color: #fff;
            border: 2px solid #3b82f6;
            border-radius: 9999px;
            padding: 8px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #1f2937;
            font-weight: 500;
            cursor: pointer;
            position: relative;
        }

        .profile-icon102 {
            background-color: #e5e7eb;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .profile-name102 {
            font-size: 15px;
        }

        .chevron102 {
            color: #6b7280;
            font-size: 14px;
        }

        .dropdown-menu102 {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            min-width: 200px;
            padding: 8px 0;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            pointer-events: none;
            z-index: 1000;
        }

        .profile-button102:hover .dropdown-menu102 {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item102 {
            padding: 8px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #4b5563;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.15s ease;
        }

        .dropdown-item102:hover {
            background-color: #f3f4f6;
        }

        .dropdown-item102 i {
            width: 20px;
            text-align: left;
            color: #6b7280;
        }

        .divider102 {
            height: 1px;
            background-color: #e5e7eb;
            margin: 4px 0;
        }

        .publish-button102 {
            background-color: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 16px;
            font-weight: 500;
            cursor: pointer;
            margin-left: 12px;
        }

        .publish-button102:hover {
            background-color: #dc2626;
        }

        /* Just for demo positioning */
        .demo-container102 {
            position: relative;
            display: inline-block;
        }
       .logout i {
            
            color:rgb(255, 0, 0);
        }
        .logout{

            color:rgb(255, 0, 0);
        }
    </style>
</head>
<body>
    <!-- Barre de navigation principale -->
    <!-- Navigation bar with logout button (in the authenticated user dropdown) -->
<nav class="navbar" role="navigation" aria-label="Barre de navigation principale">
    <!-- Logo avec icône shopping -->
    <a href="{{ route('homeshow') }}">
    <div class="logo-text">
        <i class="fa-solid fa-bag-shopping"></i> Annoncia
    </div>
    </a>
    <!-- Navigation principale contenant les dropdowns et la recherche -->
    <div class="main-navigation">
        <!-- Dropdown Catégories -->
        <div class="category-dropdown">
            <button class="dropdown-button">
                <i class="fa-solid fa-layer-group"></i>
                <span>Catégories</span>
                <i class="fa-solid fa-chevron-down chevron"></i>
            </button>
            
            <!-- Menu déroulant des catégories -->
            <div class="dropdown-menu">
                <div class="section-header">Toutes les categorie</div>

                <!-- Section 1: Catégories principales -->
                <div class="dropdown-section">
                    @foreach ($navCategories as $cat )
                         <a href="" class="dropdown-item">
                        <i class="fa-solid fa-house"></i>
                        <span>{{ $cat->nom }}</span>
                    </a>
                    @endforeach
                    
                   
                </div>
                
                
                
            </div>
        </div>

        <!-- Dropdown Villes -->
        <div class="city-dropdown">
            
            <button class="dropdown-button">
                <i class="fa-solid fa-location-dot"></i>
                <span>Villes</span>
                <i class="fa-solid fa-chevron-down chevron"></i>
            </button>
            
            <!-- Menu déroulant des villes -->
            <div class="dropdown-menu">
                <div class="section-header">Toutes les villes</div>
                
                <!-- Liste scrollable des villes du Maroc -->
                <div class="city-list">
                    @foreach ($navVilles as $vil )
                     <a href="" class="dropdown-item">
                        <i class="fa-solid fa-map-pin"></i>
                        <span>{{$vil->nom}}</span>
                    </a>   
                    @endforeach
                    
                  
                  
                    
                </div>
            </div>
        </div>

        <!-- Search form in nav.blade.php -->
<div class="search-container">
    <form action="{{ route('process-nav-search') }}" method="GET" class="search-bar">
        <input type="text" name="search_term" placeholder="Rechercher..." aria-label="Rechercher des annonces" />
        <button type="submit">
            <i class="fa-solid fa-search"></i>
        </button>
    </form>
</div>
    </div>

    <!-- Actions (boutons de connexion et publication) -->
    <!-- Update only the auth-related section in the navigation bar -->

<!-- Inside the navigation bar, replace the actions div with this: -->
<div class="actions">
    <!-- Section invité - visible uniquement pour les utilisateurs non connectés -->
    @if (!session()->has('user_id'))
    <a href="{{ route('form') }}">
        <button class="btn btn-login" id="login-btn">
            <i class="fa-solid fa-right-to-bracket"></i>
           Se Connecter
        </button>
    </a>  
    @endif   
   
    <!-- Section utilisateur connecté - visible uniquement pour les utilisateurs connectés -->
    @if (session()->has('user_id'))
    <div class="demo-container102">
        <button class="profile-button102">
            <div class="profile-icon102">
                <i class="fa-solid fa-user"></i>
            </div>
            <span class="profile-name102">{{ session('user_name') }}</span>
            <i class="fa-solid fa-chevron-down chevron102"></i>
            
            <div class="dropdown-menu102">
                <a href="{{ route('member.dashboard') }}" class="dropdown-item102">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('member.annonces') }}" class="dropdown-item102">
                    <i class="fa-regular fa-newspaper"></i>
                    <span>Mes annonces</span>
                </a>
                <a href="{{ route('member.favoris') }}" class="dropdown-item102">
                    <i class="fa-regular fa-heart"></i>
                    <span>Mes favoris</span>
                </a>
                <a href="{{ route('member.parametres') }}" class="dropdown-item102">
                    <i class="fa-solid fa-gear"></i>
                    <span>Paramètres</span>
                </a>
                <div class="divider102"></div>
                <!-- Bouton de déconnexion -->
               <a href="{{ route('logout') }}" class="dropdown-item102">
                    <div class="logout">  <i class="fa-solid fa-sign-out-alt"></i>
                    <span>Se Déconnecter</span></div> 
                </a>
            </div>
        </button>
    </div> 
    @endif   
   
    <!-- Bouton déposer une annonce (visible pour tous) -->
    <a href="{{ route('member.annonces.create') }}">
        <button class="btn btn-publish" id="publish-btn">
            <i class="fa-solid fa-square-plus"></i>
            Déposer une annonce 
        </button>
    </a>
</div>
</nav>

   
</body>
</html>