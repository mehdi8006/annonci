
    
 
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
    }

    /* Main content container - Add padding to prevent content from hiding behind fixed navbar */
    
    /* Fixed Navbar */
    .navbar-simple {
        background: rgba(255, 255, 255, 0.95);
        border-bottom: 1px solid var(--border-light);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 0.4rem 0; /* Reduced from 0.75rem to 0.4rem */
        /* Fixed positioning */
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1030;
        /* Smooth transition for any animations */
        transition: all 0.3s ease;
        /* Modern backdrop blur effect */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Logo */
    .navbar-brand {
        font-size: 1.3rem; /* Reduced from 1.5rem */
        font-weight: 700;
        color: var(--primary-color) !important;
        display: flex;
        align-items: center;
        gap: 0.4rem; /* Reduced gap */
        text-decoration: none;
    }

    .navbar-brand:hover {
        color: var(--primary-dark) !important;
    }

    /* Navigation Links */
    .nav-link-simple {
        color: var(--text-dark);
        font-weight: 500;
        padding: 0.4rem 0.8rem; /* Reduced padding */
        border-radius: 0.4rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.4rem; /* Reduced gap */
        transition: all 0.2s ease;
        font-size: 0.9rem; /* Slightly smaller text */
    }

    .nav-link-simple:hover {
        background-color: var(--bg-light);
        color: var(--primary-color);
    }

    /* Dropdown Menus */
    .dropdown-menu-simple {
        border: 1px solid var(--border-light);
        border-radius: 0.75rem;
        box-shadow: var(--shadow-md);
        padding: 0.5rem 0;
        margin-top: 0.5rem;
        background: white;
        min-width: 250px;
        z-index: 1031; /* Higher than navbar */
    }

    .dropdown-item-simple {
        padding: 0.75rem 1.25rem;
        color: var(--text-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: background-color 0.2s ease;
    }

    .dropdown-item-simple:hover {
        background-color: var(--bg-light);
        color: var(--primary-color);
    }

    .dropdown-item-simple i {
        width: 1rem;
        color: var(--text-muted);
    }

    .dropdown-item-simple:hover i {
        color: var(--primary-color);
    }

    /* Search Bar */
    .search-container {
        max-width: 400px;
        flex: 1;
    }

    .search-input {
        border: 1px solid var(--border-light);
        border-radius: 0.6rem;
        padding: 0.5rem 0.8rem; /* Reduced padding */
        padding-right: 2.8rem;
        background: white;
        transition: all 0.2s ease;
        font-size: 0.9rem; /* Smaller text */
        height: 38px; /* Fixed height */
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 0.2rem;
        top: 0.2rem;
        bottom: 0.2rem;
        background: var(--primary-color);
        border: none;
        border-radius: 0.4rem;
        padding: 0 0.8rem; /* Reduced padding */
        color: white;
        transition: background-color 0.2s ease;
        font-size: 0.85rem; /* Smaller icon */
    }

    .search-btn:hover {
        background: var(--primary-dark);
    }

    /* Buttons */
    .btn-login {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
        font-weight: 500;
        padding: 0.4rem 1rem; /* Reduced padding */
        border-radius: 0.4rem;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.9rem; /* Smaller text */
        height: 38px; /* Fixed height */
        display: flex;
        align-items: center;
    }

    .btn-login:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-publish {
        background: var(--secondary-color);
        color: white;
        font-weight: 600;
        padding: 0.4rem 1rem; /* Reduced padding */
        border-radius: 0.4rem;
        text-decoration: none;
        border: none;
        transition: background-color 0.2s ease;
        font-size: 0.9rem; /* Smaller text */
        height: 38px; /* Fixed height */
        display: flex;
        align-items: center;
    }

    .btn-publish:hover {
        background: var(--secondary-dark);
        color: white;
    }

    /* Profile Dropdown */
    .profile-btn {
        background: white;
        border: 1px solid var(--border-light);
        border-radius: 1.5rem;
        padding: 0.3rem 0.8rem; /* Reduced padding */
        display: flex;
        align-items: center;
        gap: 0.4rem; /* Reduced gap */
        color: var(--text-dark);
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.9rem; /* Smaller text */
        height: 38px; /* Fixed height */
    }

    .profile-btn:hover {
        background: var(--bg-light);
        color: var(--primary-color);
    }

    .profile-icon {
        background: var(--primary-color);
        border-radius: 50%;
        width: 1.5rem; /* Reduced size */
        height: 1.5rem; /* Reduced size */
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem; /* Smaller icon */
    }

    /* City List Scrollable */
    .city-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .city-list::-webkit-scrollbar {
        width: 4px;
    }

    .city-list::-webkit-scrollbar-track {
        background: var(--bg-light);
    }

    .city-list::-webkit-scrollbar-thumb {
        background: var(--text-muted);
        border-radius: 2px;
    }

    /* Smooth scroll behavior for page anchors */
    html {
        scroll-behavior: smooth;
        scroll-padding-top: 70px; /* Reduced to match new navbar height */
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .main-content {
            padding-top: 50px; /* Reduced for mobile */
        }
        
        .search-container {
            margin: 0.8rem 0; /* Reduced margin */
            max-width: 100%;
        }
        
        .dropdown-menu-simple {
            position: static !important;
            box-shadow: none;
            border: 1px solid var(--border-light);
            margin: 0.4rem 0; /* Reduced margin */
            z-index: auto;
        }
        
        /* Ensure mobile menu doesn't get cut off */
        .navbar-collapse {
            max-height: calc(100vh - 50px); /* Updated to match reduced height */
            overflow-y: auto;
        }
    }
</style>
    <!-- Simple Bootstrap Navigation -->
    <nav class="navbar navbar-expand-lg navbar-simple">
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
                        <a class="nav-link-simple" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Catégories</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-simple">
                            @foreach ($navCategories as $cat)
                            <li>
                                <a class="dropdown-item-simple" href="{{ route('search.by.category', $cat->id) }}">
                                    <i class="fa-solid fa-tag"></i>
                                    <span>{{ $cat->nom }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- Cities Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link-simple" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Villes</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-simple">
                            <li>
                                <div class="city-list">
                                    @foreach ($navVilles as $vil)
                                    <a class="dropdown-item-simple" href="{{ route('search.by.city', $vil->id) }}">
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
                <div class="search-container mx-3">
                    <form action="{{ route('process-nav-search') }}" method="GET" class="position-relative">
                        <input type="text" name="search_term" class="form-control search-input" placeholder="Rechercher..." aria-label="Rechercher des annonces">
                        <button type="submit" class="search-btn">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right side actions -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Guest Section -->
                    @if (!session()->has('user_id'))
                    <a href="{{ route('form') }}" class="btn-login">
                        <i class="fa-solid fa-right-to-bracket me-1"></i>
                        Se Connecter
                    </a>
                    @endif

                    <!-- Authenticated User Section -->
                    @if (session()->has('user_id'))
                    <div class="dropdown">
                        <a class="profile-btn" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="d-none d-md-inline">{{ session('user_name') }}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-simple dropdown-menu-end">
                            <li>
                                <a class="dropdown-item-simple" href="{{ route('member.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Tableau de bord</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item-simple" href="{{ route('member.annonces') }}">
                                    <i class="fa-regular fa-newspaper"></i>
                                    <span>Mes annonces</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item-simple" href="{{ route('member.favoris') }}">
                                    <i class="fa-regular fa-heart"></i>
                                    <span>Mes favoris</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item-simple" href="{{ route('member.parametres') }}">
                                    <i class="fa-solid fa-gear"></i>
                                    <span>Paramètres</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item-simple text-danger" href="{{ route('logout') }}">
                                    <i class="fa-solid fa-sign-out-alt"></i>
                                    <span>Se Déconnecter</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif

                    <!-- Publish Button -->
                    <a href="{{ route('member.annonces.create') }}" class="btn-publish">
                        <i class="fa-solid fa-square-plus me-1"></i>
                        <span class="d-none d-md-inline">Déposer une annonce</span>
                        <span class="d-md-none">Déposer</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

