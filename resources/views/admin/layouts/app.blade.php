<!-- resources/views/admin/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Administration Annoncia</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 17%;
            --navbar-height: 45px;
            --primary-blue: #1c2e4a;     /* Soft navy */
--light-blue: #2c4370;       /* Muted steel blue */
--primary-orange: #8a4a2f;   /* Warm terracotta */
--light-orange: #a85f3b;     /* Soft clay orange */

        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Top Navbar */
        .admin-navbar {
            height: var(--navbar-height);
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-orange) 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        .admin-navbar .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.25rem;
            text-decoration: none;
        }
        
        .admin-navbar .navbar-brand:hover {
            color: #e3f2fd !important;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            bottom: 0;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1020;
            box-shadow: 2px 0 15px rgba(0,0,0,0.15);
        }
        
        .admin-sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        /* Navigation Items */
        .admin-nav-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #bfdbfe;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .admin-nav-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            border-left-color: var(--light-orange);
        }
        
        .admin-nav-item.active {
            background-color: rgba(255,255,255,0.15);
            color: white;
            border-left-color: var(--primary-orange);
        }
        
        .admin-nav-item i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }
        
        /* Main Content */
        .admin-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 1.5rem;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left 0.3s ease;
        }
        
        .admin-content.expanded {
            margin-left: 0;
        }
        
        /* Cards */
        .admin-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: box-shadow 0.3s ease;
        }
        
        .admin-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
        }
        
        .stats-card.primary {
            border-left-color: var(--light-blue);
        }
        
        .stats-card.success {
            border-left-color: #059669;
        }
        
        .stats-card.warning {
            border-left-color: var(--primary-orange);
        }
        
        .stats-card.danger {
            border-left-color: #dc2626;
        }
        
        .stats-card.info {
            border-left-color: var(--light-orange);
        }
        
        /* Buttons */
        .btn-modern {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        /* Tables */
        .table-modern {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .table-modern th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        /* Forms */
        .form-modern .form-control,
        .form-modern .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.625rem 0.75rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-modern .form-control:focus,
        .form-modern .form-select:focus {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 0.2rem rgba(29, 78, 216, 0.25);
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .admin-navbar .navbar-brand {
                font-size: 1.1rem;
            }
        }
        
        /* Page Header */
        .page-header {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            border-left: 4px solid var(--light-blue);
        }
        
        /* Sidebar Toggle Button */
        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1rem;
            padding: 0.25rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        /* Admin User Dropdown */
        .dropdown-toggle::after {
            display: none !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .dropdown-item {
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
    </style>
    @yield('css')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar admin-navbar px-3 d-flex justify-content-between align-items-center" style="min-height: 45px;">
        <div class="d-flex align-items-center h-100">
            <button class="sidebar-toggle d-lg-none me-3 d-flex align-items-center justify-content-center" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center m-0 h-100" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-bag-shopping me-2"></i>
                <span>Annoncia Admin</span>
            </a>
        </div>
        
        <div class="d-flex align-items-center h-100">
            <div class="dropdown h-100 d-flex align-items-center">
                <button class="btn d-flex align-items-center text-decoration-none border-0 bg-transparent h-100" type="button" data-bs-toggle="dropdown" style="background: none !important;">
                    <div class="d-flex align-items-center rounded-pill px-2" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); height: 32px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; background-color: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
                            <i class="fas fa-user text-white" style="font-size: 11px;"></i>
                        </div>
                        <span class="text-white fw-medium me-2" style="font-size: 0.85rem; line-height: 1;">Admin {{ session('user_name') }}</span>
                        <i class="fas fa-chevron-down text-white" style="font-size: 9px; opacity: 0.8;"></i>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2">
                    <li><a class="dropdown-item py-2" href="{{ route('homeshow') }}"><i class="fas fa-home me-2 text-primary"></i>Retour au site</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2 text-danger"></i>Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <nav class="nav flex-column py-3">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tableau de bord</span>
            </a>
            
            <a href="{{ route('admin.statistics.index') }}" class="admin-nav-item {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Statistiques</span>
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Utilisateurs</span>
            </a>
            
            <a href="{{ route('admin.annonces.index') }}" class="admin-nav-item {{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                <span>Annonces</span>
            </a>
            
            <a href="{{ route('admin.catalogues.index') }}" class="admin-nav-item {{ request()->routeIs('admin.catalogues.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') || request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                <i class="fas fa-database"></i>
                <span>Catalogues</span>
            </a>
            
            <a href="{{ route('admin.reviews.index') }}" class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>Avis</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="admin-content" id="adminContent">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const content = document.getElementById('adminContent');
            
            sidebar.classList.toggle('show');
            
            // Close sidebar when clicking outside on mobile
            if (sidebar.classList.contains('show')) {
                document.addEventListener('click', function closeSidebar(e) {
                    if (!sidebar.contains(e.target) && !e.target.classList.contains('sidebar-toggle')) {
                        sidebar.classList.remove('show');
                        document.removeEventListener('click', closeSidebar);
                    }
                });
            }
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    
    @yield('js')
</body>
</html>