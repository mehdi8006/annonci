<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Membre') - Annoncia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-container {
            display: flex;
            flex: 1;
            margin-top: 20px;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            margin-left: 20px;
            border-radius: 8px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .profile {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 20px;
        }
        
        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
        }
        
        .profile-name {
            font-weight: 600;
            color: #333;
        }
        
        .nav-links {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .nav-link {
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.2s, color 0.2s;
        }
        
        .nav-link:hover {
            background-color: #f0f7ff;
            color: #3498db;
        }
        
        .nav-link.active {
            background-color: #e6f2ff;
            color: #3498db;
            border-left: 3px solid #3498db;
        }
        
        .nav-link i {
            margin-right: 10px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        .logout {
            margin-top: auto;
            border-top: 1px solid #eaeaea;
            padding-top: 10px;
        }
        
        .logout .nav-link {
            color: #e74c3c;
        }
        
        .logout .nav-link:hover {
            background-color: #fee;
            color: #c0392b;
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 0 40px;
            margin-bottom: 40px;
        }
        
        /* Page Header */
        .page-header {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .page-header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .page-header p {
            color: #666;
            font-size: 16px;
        }
        
        /* Messages */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert i {
            font-size: 20px;
        }
        
        /* Content Box */
        .content-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                margin: 0 20px;
                position: relative;
                top: 0;
            }
            
            .main-content {
                padding: 20px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Include navbar -->
    @include('components.nav')
    
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile">
                <div class="profile-icon">{{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}</div>
                <div class="profile-name">{{ session('user_name', 'Utilisateur') }}</div>
            </div>
            
            <div class="nav-links">
                <a href="{{ route('member.dashboard') }}" class="nav-link {{ $activePage == 'dashboard' ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Tableau de bord
                </a>
                <a href="{{ route('member.annonces.create') }}" class="nav-link {{ $activePage == 'ajouter' ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i>
                    Publier une annonce
                </a>
                <a href="{{ route('member.annonces') }}" class="nav-link {{ $activePage == 'annonces' ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    Mes annonces
                </a>
                <a href="{{ route('member.favoris') }}" class="nav-link {{ $activePage == 'favoris' ? 'active' : '' }}">
                    <i class="fas fa-heart"></i>
                    Mes favoris
                </a>
                <a href="{{ route('member.parametres') }}" class="nav-link {{ $activePage == 'parametres' ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Paramètres
                </a>
                
                <a href="{{ route('logout') }}" class="nav-link logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Se déconnecter
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>