@extends('admin.layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="container-fluid px-4">
    <!-- Statistics Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Statistiques</h1>
            <p class="text-muted mb-0">Analyse détaillée de votre plateforme Annoncia</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Date Range Filter -->
            <form method="GET" action="{{ route('admin.statistics.index') }}" class="d-flex gap-2 align-items-center">
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control form-control-sm">
                <span class="text-muted">à</span>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control form-control-sm">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter me-1"></i> Filtrer
                </button>
            </form>
            
            <!-- Export Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i> Exporter
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Exporter en CSV</h6></li>
                    <li><a class="dropdown-item" href="{{ route('admin.statistics.export', ['type' => 'cities', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Statistiques par ville</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.statistics.export', ['type' => 'categories', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Statistiques par catégorie</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.statistics.export', ['type' => 'subcategories', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Statistiques par sous-catégorie</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('admin.statistics.export', ['type' => 'users_favorites']) }}">Top utilisateurs (favoris)</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.statistics.export', ['type' => 'users_announcements']) }}">Top utilisateurs (annonces)</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Summary Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body text-center">
                    <div class="stats-icon bg-primary mx-auto mb-2">
                        <i class="fas fa-bullhorn text-white"></i>
                    </div>
                    <div class="h4 mb-1 text-primary">{{ number_format($statistics['summary_stats']['total_announcements']) }}</div>
                    <div class="small text-muted">Total Annonces</div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body text-center">
                    <div class="stats-icon bg-success mx-auto mb-2">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="h4 mb-1 text-success">{{ number_format($statistics['summary_stats']['total_users']) }}</div>
                    <div class="small text-muted">Total Utilisateurs</div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body text-center">
                    <div class="stats-icon bg-danger mx-auto mb-2">
                        <i class="fas fa-heart text-white"></i>
                    </div>
                    <div class="h4 mb-1 text-danger">{{ number_format($statistics['summary_stats']['total_favorites']) }}</div>
                    <div class="small text-muted">Total Favoris</div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body text-center">
                    <div class="stats-icon bg-info mx-auto mb-2">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <div class="h4 mb-1 text-info">{{ number_format($statistics['summary_stats']['total_cities']) }}</div>
                    <div class="small text-muted">Villes</div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body text-center">
                    <div class="stats-icon bg-warning mx-auto mb-2">
                        <i class="fas fa-tags text-white"></i>
                    </div>
                    <div class="h4 mb-1 text-warning">{{ number_format($statistics['summary_stats']['total_categories']) }}</div>
                    <div class="small text-muted">Catégories</div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body text-center">
                    <div class="stats-icon bg-secondary mx-auto mb-2">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <div class="h4 mb-1 text-secondary">{{ number_format($statistics['summary_stats']['total_subcategories']) }}</div>
                    <div class="small text-muted">Sous-catégories</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Period Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-clock me-2"></i>Annonces ajoutées par période
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-success">{{ number_format($statistics['announcements_by_period']['1_day']) }}</div>
                                <div class="small text-muted">Dernier jour</div>
                            </div>
                        </div>
                        <div class="col-md col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-info">{{ number_format($statistics['announcements_by_period']['1_week']) }}</div>
                                <div class="small text-muted">Dernière semaine</div>
                            </div>
                        </div>
                        <div class="col-md col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-warning">{{ number_format($statistics['announcements_by_period']['1_month']) }}</div>
                                <div class="small text-muted">Dernier mois</div>
                            </div>
                        </div>
                        <div class="col-md col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-primary">{{ number_format($statistics['announcements_by_period']['6_months']) }}</div>
                                <div class="small text-muted">6 derniers mois</div>
                            </div>
                        </div>
                        <div class="col-md col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-danger">{{ number_format($statistics['announcements_by_period']['1_year']) }}</div>
                                <div class="small text-muted">Dernière année</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Monthly Trend -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-line me-2"></i>Évolution mensuelle ({{ $startDate }} - {{ $endDate }})
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyTrendChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Announcements by Category (Pie Chart) -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Annonces par catégorie
                    </h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="categoryChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Announcements by City -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Top 10 villes
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="cityChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Subcategories -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Top sous-catégories
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="subcategoryChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Section -->
    <div class="row mb-4">
        <!-- Top Users by Favorites -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-heart me-2"></i>Top utilisateurs par favoris reçus
                    </h6>
                    <span class="badge bg-primary">{{ count($statistics['top_users_by_favorites']) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th class="text-center">Favoris</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statistics['top_users_by_favorites'] as $index => $user)
                                <tr>
                                    <td>
                                        @if($index < 3)
                                            <span class="badge bg-{{ $index === 0 ? 'warning' : ($index === 1 ? 'secondary' : 'dark') }}">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white me-2">
                                                {{ strtoupper(substr($user->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $user->nom }}</div>
                                                <div class="small text-muted">Inscrit {{ $user->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted small">{{ $user->email }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $user->total_favorites }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-heart fa-2x mb-2"></i>
                                        <p>Aucun utilisateur avec des favoris trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Users by Announcements -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-bullhorn me-2"></i>Top utilisateurs par annonces publiées
                    </h6>
                    <span class="badge bg-success">{{ count($statistics['top_users_by_announcements']) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th class="text-center">Annonces</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statistics['top_users_by_announcements'] as $index => $user)
                                <tr>
                                    <td>
                                        @if($index < 3)
                                            <span class="badge bg-{{ $index === 0 ? 'warning' : ($index === 1 ? 'secondary' : 'dark') }}">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success text-white me-2">
                                                {{ strtoupper(substr($user->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $user->nom }}</div>
                                                <div class="small text-muted">Inscrit {{ $user->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted small">{{ $user->email }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $user->total_annonces }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-bullhorn fa-2x mb-2"></i>
                                        <p>Aucun utilisateur avec des annonces trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics Tables -->
    <div class="row mb-4">
        <!-- Cities Statistics -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-map-marker-alt me-2"></i>Statistiques détaillées par ville
                    </h6>
                    <div>
                        <span class="badge bg-info me-2">{{ count($statistics['announcements_by_city']) }} villes</span>
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleTable('citiesTable')">
                            <i class="fas fa-eye"></i> Voir/Masquer
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" id="citiesTable" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Rang</th>
                                    <th>Ville</th>
                                    <th class="text-center">Nombre d'annonces</th>
                                    <th class="text-center">Pourcentage</th>
                                    <th class="text-center">Progression</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_announcements = $statistics['announcements_by_city']->sum('total'); @endphp
                                @foreach($statistics['announcements_by_city'] as $index => $city)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-info me-2"></i>
                                            <span class="fw-medium">{{ $city->ville_nom }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ number_format($city->total) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php $percentage = $total_announcements > 0 ? round(($city->total / $total_announcements) * 100, 1) : 0; @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-info" style="width: {{ $percentage }}%">
                                                {{ $percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($index === 0)
                                            <i class="fas fa-crown text-warning" title="Première place"></i>
                                        @elseif($index < 3)
                                            <i class="fas fa-medal text-secondary" title="Top 3"></i>
                                        @else
                                            <i class="fas fa-arrow-right text-muted"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subcategories Statistics -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-layer-group me-2"></i>Statistiques détaillées par sous-catégorie
                    </h6>
                    <div>
                        <span class="badge bg-warning me-2">{{ count($statistics['announcements_by_subcategory']) }} sous-catégories</span>
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleTable('subcategoriesTable')">
                            <i class="fas fa-eye"></i> Voir/Masquer
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" id="subcategoriesTable" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Rang</th>
                                    <th>Sous-catégorie</th>
                                    <th>Catégorie parent</th>
                                    <th class="text-center">Nombre d'annonces</th>
                                    <th class="text-center">Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics['announcements_by_subcategory'] as $index => $subcategory)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-tag text-warning me-2"></i>
                                            <span class="fw-medium">{{ $subcategory->sous_categorie_nom }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-outline-secondary">{{ $subcategory->categorie_nom }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning">{{ number_format($subcategory->total) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($subcategory->total >= 50)
                                            <span class="badge bg-success">Excellent</span>
                                        @elseif($subcategory->total >= 20)
                                            <span class="badge bg-info">Bon</span>
                                        @elseif($subcategory->total >= 10)
                                            <span class="badge bg-warning">Moyen</span>
                                        @else
                                            <span class="badge bg-secondary">Faible</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Health Summary -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Résumé de la santé du système
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-success">
                                    {{ number_format(($statistics['summary_stats']['active_announcements'] / max($statistics['summary_stats']['total_announcements'], 1)) * 100, 1) }}%
                                </div>
                                <div class="small text-muted">Taux d'activation des annonces</div>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-success" style="width: {{ ($statistics['summary_stats']['active_announcements'] / max($statistics['summary_stats']['total_announcements'], 1)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-info">
                                    {{ number_format(($statistics['summary_stats']['active_users'] / max($statistics['summary_stats']['total_users'], 1)) * 100, 1) }}%
                                </div>
                                <div class="small text-muted">Taux d'activation des utilisateurs</div>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-info" style="width: {{ ($statistics['summary_stats']['active_users'] / max($statistics['summary_stats']['total_users'], 1)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-warning">
                                    {{ $statistics['summary_stats']['avg_announcements_per_user'] }}
                                </div>
                                <div class="small text-muted">Moyenne annonces/utilisateur</div>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-warning" style="width: {{ min($statistics['summary_stats']['avg_announcements_per_user'] * 10, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-danger">
                                    {{ number_format(($statistics['summary_stats']['total_favorites'] / max($statistics['summary_stats']['total_announcements'], 1)), 1) }}
                                </div>
                                <div class="small text-muted">Ratio favoris/annonces</div>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-danger" style="width: {{ min(($statistics['summary_stats']['total_favorites'] / max($statistics['summary_stats']['total_announcements'], 1)) * 20, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Card hover effects */
    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    /* Stats icons */
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    /* Avatar styles */
    .avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }
    
    /* Table enhancements */
    .table th {
        border-top: none;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    /* Progress bars */
    .progress {
        border-radius: 10px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .progress-bar {
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* Custom badges */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    
    /* Chart containers */
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .h4 {
            font-size: 1.25rem;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
    }
    
    /* Loading states */
    .loading-chart {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 300px;
        color: #6c757d;
    }
    
    /* Custom scrollbar for tables */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: fadeInUp 0.5s ease-out;
    }
</style>
@endsection

@section('js')
<script>
// Chart.js configuration
const chartColors = {
    primary: '#2563eb',
    success: '#10b981',
    warning: '#f59e0b',
    danger: '#ef4444',
    info: '#06b6d4',
    secondary: '#64748b'
};

// Statistics data from backend
const statisticsData = @json($statistics);

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Monthly Trend Chart
    if (document.getElementById('monthlyTrendChart')) {
        const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        new Chart(monthlyTrendCtx, {
            type: 'line',
            data: {
                labels: statisticsData.monthly_trend.labels,
                datasets: [
                    {
                        label: 'Annonces',
                        data: statisticsData.monthly_trend.announcements,
                        borderColor: chartColors.primary,
                        backgroundColor: chartColors.primary + '20',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: chartColors.primary,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Utilisateurs',
                        data: statisticsData.monthly_trend.users,
                        borderColor: chartColors.success,
                        backgroundColor: chartColors.success + '20',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: chartColors.success,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }

    // Category Distribution Chart
    if (document.getElementById('categoryChart')) {
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryLabels = statisticsData.announcements_by_category.map(item => item.categorie_nom);
        const categoryData = statisticsData.announcements_by_category.map(item => item.total);
        
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: [
                        chartColors.primary,
                        chartColors.success,
                        chartColors.warning,
                        chartColors.danger,
                        chartColors.info,
                        chartColors.secondary,
                        '#ff6b35',
                        '#4ade80',
                        '#a855f7',
                        '#06d6a0'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // City Chart
    if (document.getElementById('cityChart')) {
        const cityCtx = document.getElementById('cityChart').getContext('2d');
        const cityLabels = statisticsData.announcements_by_city.slice(0, 10).map(item => item.ville_nom);
        const cityData = statisticsData.announcements_by_city.slice(0, 10).map(item => item.total);
        
        new Chart(cityCtx, {
            type: 'bar',
            data: {
                labels: cityLabels,
                datasets: [{
                    label: 'Nombre d\'annonces',
                    data: cityData,
                    backgroundColor: chartColors.info + '80',
                    borderColor: chartColors.info,
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                }
            }
        });
    }

    // Subcategory Chart
    if (document.getElementById('subcategoryChart')) {
        const subcategoryCtx = document.getElementById('subcategoryChart').getContext('2d');
        const subcategoryLabels = statisticsData.announcements_by_subcategory.slice(0, 10).map(item => item.sous_categorie_nom);
        const subcategoryData = statisticsData.announcements_by_subcategory.slice(0, 10).map(item => item.total);
        
        new Chart(subcategoryCtx, {
            type: 'bar',
            data: {
                labels: subcategoryLabels,
                datasets: [{
                    label: 'Nombre d\'annonces',
                    data: subcategoryData,
                    backgroundColor: chartColors.warning + '80',
                    borderColor: chartColors.warning,
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value);
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
}

// Toggle table visibility
function toggleTable(tableId) {
    const table = document.getElementById(tableId);
    if (table.style.display === 'none') {
        table.style.display = 'block';
    } else {
        table.style.display = 'none';
    }
}

// Print statistics
function printStatistics() {
    window.print();
}

// Auto-refresh data every 5 minutes
setInterval(function() {
    // You can implement AJAX refresh here if needed
    console.log('Auto-refresh triggered');
}, 300000);
</script>
@endsection