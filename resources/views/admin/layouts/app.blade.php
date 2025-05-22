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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --light: #f3f4f6;
            --dark: #1f2937;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
        }
        
        .admin-sidebar {
            width: 260px;
            background-color: var(--dark);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .admin-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .admin-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .admin-logo h1 {
            font-size: 24px;
            margin: 0;
            color: white;
        }
        
        .admin-nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .admin-nav-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
        }
        
        .admin-nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--primary);
        }
        
        .admin-nav-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .admin-nav-section {
            margin-top: 30px;
            padding: 0 20px;
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 1px;
        }
        
        .admin-header {
            background-color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .admin-header h1 {
            font-size: 24px;
            margin: 0;
            color: var(--dark);
        }
        
        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .admin-card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .admin-stats-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary);
            transition: transform 0.3s;
        }
        
        .admin-stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: white;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stats-primary {
            background-color: var(--primary);
        }
        
        .stats-success {
            background-color: var(--success);
        }
        
        .stats-warning {
            background-color: var(--warning);
        }
        
        .stats-danger {
            background-color: var(--danger);
        }
        
        .stats-info {
            background-color: var(--info);
        }
        
        .stats-title {
            font-size: 14px;
            color: var(--secondary);
            margin-bottom: 5px;
        }
        
        .stats-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .admin-button {
            padding: 8px 16px;
            border-radius: 5px;
            background-color: var(--primary);
            color: white;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .admin-button:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        
        .admin-button-secondary {
            background-color: var(--secondary);
        }
        
        .admin-button-secondary:hover {
            background-color: #4b5563;
        }
        
        .admin-button-success {
            background-color: var(--success);
        }
        
        .admin-button-success:hover {
            background-color: #059669;
        }
        
        .admin-button-danger {
            background-color: var(--danger);
        }
        
        .admin-button-danger:hover {
            background-color: #dc2626;
        }
        
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .admin-table th,
        .admin-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .admin-table th {
            font-weight: 600;
            color: var(--secondary);
            font-size: 14px;
        }
        
        .admin-table tr:hover {
            background-color: #f9fafb;
        }
        
        .admin-table-actions {
            display: flex;
            gap: 5px;
        }
        
        .admin-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .admin-badge-primary {
            background-color: #dbeafe;
            color: var(--primary);
        }
        
        .admin-badge-success {
            background-color: #d1fae5;
            color: var(--success);
        }
        
        .admin-badge-warning {
            background-color: #fef3c7;
            color: var(--warning);
        }
        
        .admin-badge-danger {
            background-color: #fee2e2;
            color: var(--danger);
        }
        
        .admin-badge-secondary {
            background-color: #e5e7eb;
            color: var(--secondary);
        }
        
        .admin-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .admin-form-group {
            margin-bottom: 20px;
        }
        
        .admin-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .admin-form-input,
        .admin-form-select,
        .admin-form-textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .admin-form-input:focus,
        .admin-form-select:focus,
        .admin-form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }
        
        .admin-form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .admin-form-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }
        
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-260px);
            }
            
            .admin-content {
                margin-left: 0;
            }
            
            .sidebar-open .admin-sidebar {
                transform: translateX(0);
            }
            
            .sidebar-open .admin-content {
                margin-left: 260px;
            }
            
            .toggle-sidebar {
                display: block !important;
            }
        }
    </style>
    @yield('css')
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="admin-logo">
            <h1><i class="fa-solid fa-bag-shopping"></i> Annoncia</h1>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
        
        <div class="admin-nav-section">Gestion des utilisateurs</div>
        
        <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Utilisateurs
        </a>
        
        <div class="admin-nav-section">Gestion des annonces</div>
        
        <a href="{{ route('admin.annonces.index') }}" class="admin-nav-item {{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}">
            <i class="fas fa-list"></i> Annonces
        </a>
        
        <!-- Replace the categories nav item with this one -->
<a href="{{ route('admin.catalogues.index') }}" class="admin-nav-item {{ request()->routeIs('admin.catalogues.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') || request()->routeIs('admin.cities.*') ? 'active' : '' }}">
    <i class="fas fa-database"></i> Catalogues
</a>
        
        <div class="admin-nav-section">Modération</div>
        
        
        
        <a href="{{ route('admin.reviews.index') }}" class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Avis
        </a>
        
        <div class="admin-nav-section">Autres</div>
        
        <a href="{{ route('homeshow') }}" class="admin-nav-item">
            <i class="fas fa-home"></i> Retour au site
        </a>
        
        <a href="{{ route('logout') }}" class="admin-nav-item">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add any common JavaScript here
    </script>
    
    @yield('js')
</body>
</html>