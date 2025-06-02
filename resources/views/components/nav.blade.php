<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title>Modern Navigation Bar - Annoncia</title>
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #f97316;
            --secondary-dark: #ea580c;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f8fafc;
            --border-light: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-light);
        }

        /* Custom Navbar Styles */
        .navbar-modern {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-light);
            box-shadow: var(--shadow-md);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* Logo Styles */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-1px);
            color: var(--primary-dark) !important;
        }

        .navbar-brand i {
            font-size: 1.25rem;
        }

        /* Dropdown Buttons */
        .dropdown-toggle-modern {
            background: transparent;
            border: none;
            color: var(--text-dark);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .dropdown-toggle-modern:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .dropdown-toggle-modern::after {
            display: none;
        }

        .dropdown-toggle-modern i.chevron {
            transition: transform 0.2s ease;
            color: var(--text-muted);
        }

        .dropdown-toggle-modern:hover i.chevron {
            transform: rotate(180deg);
        }

        /* Modern Dropdown Menus */
        .dropdown-menu-modern {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            padding: 1rem 0;
            margin-top: 0.5rem;
            background: white;
            backdrop-filter: blur(10px);
            min-width: 280px;
        }

        .dropdown-header-modern {
            padding: 0.5rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 0.5rem;
        }

        .dropdown-item-modern {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 400;
            transition: all 0.2s ease;
            border-radius: 0;
        }

        .dropdown-item-modern:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            transform: translateX(4px);
        }

        .dropdown-item-modern i {
            width: 1.25rem;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        .dropdown-item-modern:hover i {
            color: white;
        }

        /* Search Bar Styles */
        .search-container-modern {
            position: relative;
            max-width: 400px;
            flex: 1;
        }

        .search-form-modern {
            position: relative;
            display: flex;
        }

        .search-input-modern {
            border: 2px solid var(--border-light);
            border-radius: 1rem;
            padding: 0.75rem 1.25rem;
            padding-right: 3.5rem;
            background: white;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            box-shadow: var(--shadow-sm);
        }

        .search-input-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .search-btn-modern {
            position: absolute;
            right: 0.25rem;
            top: 0.25rem;
            bottom: 0.25rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 0.75rem;
            padding: 0 1rem;
            color: white;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-btn-modern:hover {
            transform: translateY(-1px) scale(1.02);
            box-shadow: var(--shadow-md);
        }

        /* Action Buttons */
        .btn-login-modern {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-login-modern:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-publish-modern {
            background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            box-shadow: var(--shadow-sm);
        }

        .btn-publish-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        /* Profile Dropdown */
        .profile-btn-modern {
            background: white;
            border: 2px solid var(--primary-color);
            border-radius: 2rem;
            padding: 0.4rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-dark);
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            box-shadow: var(--shadow-sm);
        }

        .profile-btn-modern:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .profile-icon-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .profile-dropdown-modern {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            padding: 0.75rem 0;
            margin-top: 0.5rem;
            min-width: 220px;
        }

        .profile-dropdown-item-modern {
            padding: 0.625rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .profile-dropdown-item-modern:hover {
            background: var(--bg-light);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .profile-dropdown-item-modern.logout-item:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .profile-dropdown-item-modern i {
            width: 1.25rem;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        .profile-dropdown-item-modern:hover i {
            color: var(--primary-color);
        }

        .profile-dropdown-item-modern.logout-item:hover i {
            color: white;
        }

        /* City List Scrollable */
        .city-list-modern {
            max-height: 300px;
            overflow-y: auto;
        }

        .city-list-modern::-webkit-scrollbar {
            width: 6px;
        }

        .city-list-modern::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 3px;
        }

        .city-list-modern::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 3px;
        }

        .city-list-modern::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .search-container-modern {
                margin: 1rem 0;
                max-width: 100%;
            }
            
            .navbar-nav .dropdown-menu-modern {
                position: static !important;
                float: none;
                box-shadow: none;
                border: 1px solid var(--border-light);
                margin: 0.5rem 0;
            }
        }

        /* Animation for navbar items */
        .navbar-nav .nav-item {
            animation: slideInUp 0.6s ease forwards;
        }

        .navbar-nav .nav-item:nth-child(2) {
            animation-delay: 0.1s;
        }

        .navbar-nav .nav-item:nth-child(3) {
            animation-delay: 0.2s;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Divider */
        .dropdown-divider-modern {
            margin: 0.5rem 0;
            border-top: 1px solid var(--border-light);
        }
    </style>
</head>
<body>
    <!-- Modern Bootstrap Navigation -->
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container-fluid px-4">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('homeshow') }}">
                <i class="fa-solid fa-bag-shopping"></i>
                Annoncia
            </a>

            <!-- Mobile toggle button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Left side navigation -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Categories Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle-modern" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Catégories</span>
                            <i class="fa-solid fa-chevron-down chevron"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-modern">
                            <li><div class="dropdown-header-modern">Toutes les catégories</div></li>
                            @foreach ($navCategories as $cat)
                            <li>
                                <a class="dropdown-item-modern" href="{{ route('search.by.category', $cat->id) }}">
                                    <i class="fa-solid fa-house"></i>
                                    <span>{{ $cat->nom }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- Cities Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle-modern" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Villes</span>
                            <i class="fa-solid fa-chevron-down chevron"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-modern">
                            <li><div class="dropdown-header-modern">Toutes les villes</div></li>
                            <li>
                                <div class="city-list-modern">
                                    @foreach ($navVilles as $vil)
                                    <a class="dropdown-item-modern" href="{{ route('search.by.city', $vil->id) }}">
                                        <i class="fa-solid fa-map-pin"></i>
                                        <span>{{ $vil->nom }}</span>
                                    </a>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Search Bar -->
                <div class="search-container-modern mx-3">
                    <form action="{{ route('process-nav-search') }}" method="GET" class="search-form-modern">
                        <input type="text" name="search_term" class="form-control search-input-modern" placeholder="Rechercher..." aria-label="Rechercher des annonces">
                        <button type="submit" class="btn search-btn-modern">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right side actions -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Guest Section -->
                    @if (!session()->has('user_id'))
                    <a href="{{ route('form') }}" class="btn-login-modern">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Se Connecter
                    </a>
                    @endif

                    <!-- Authenticated User Section -->
                    @if (session()->has('user_id'))
                    <div class="dropdown">
                        <a class="profile-btn-modern" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-icon-modern">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="d-none d-md-inline">{{ session('user_name') }}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-end profile-dropdown-modern">
                            <li>
                                <a class="profile-dropdown-item-modern" href="{{ route('member.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Tableau de bord</span>
                                </a>
                            </li>
                            <li>
                                <a class="profile-dropdown-item-modern" href="{{ route('member.annonces') }}">
                                    <i class="fa-regular fa-newspaper"></i>
                                    <span>Mes annonces</span>
                                </a>
                            </li>
                            <li>
                                <a class="profile-dropdown-item-modern" href="{{ route('member.favoris') }}">
                                    <i class="fa-regular fa-heart"></i>
                                    <span>Mes favoris</span>
                                </a>
                            </li>
                            <li>
                                <a class="profile-dropdown-item-modern" href="{{ route('member.parametres') }}">
                                    <i class="fa-solid fa-gear"></i>
                                    <span>Paramètres</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider-modern"></li>
                            <li>
                                <a class="profile-dropdown-item-modern logout-item" href="{{ route('logout') }}">
                                    <i class="fa-solid fa-sign-out-alt"></i>
                                    <span>Se Déconnecter</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif

                    <!-- Publish Button -->
                    <a href="{{ route('member.annonces.create') }}" class="btn-publish-modern">
                        <i class="fa-solid fa-square-plus"></i>
                        <span class="d-none d-md-inline">Déposer une annonce</span>
                        <span class="d-md-none">Déposer</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>