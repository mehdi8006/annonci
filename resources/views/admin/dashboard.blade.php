@extends('admin.layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid px-4">
    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
            <p class="text-muted mb-0">Vue d'ensemble de votre plateforme Annoncia</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt me-1"></i> Actualiser
            </button>
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Actions rapides
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><h6 class="dropdown-header">Approbations</h6></li>
                    <li>
                        <button class="dropdown-item" onclick="quickAction('approveUsers')">
                            <i class="fas fa-user-check me-2 text-success"></i> Approuver tous les utilisateurs
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" onclick="quickAction('approveAnnonces')">
                            <i class="fas fa-check-circle me-2 text-success"></i> Approuver toutes les annonces
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" onclick="quickAction('autoModerate')">
                            <i class="fas fa-robot me-2 text-info"></i> Modération automatique des avis
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Navigation</h6></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.catalogues.index') }}">
                            <i class="fas fa-plus me-2 text-primary"></i> Ajouter catégorie/ville
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.annonces.index', ['sort' => 'reports_count', 'direction' => 'desc']) }}">
                            <i class="fas fa-exclamation-triangle me-2 text-danger"></i> Signalements critiques
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    @if(count($alerts) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0 text-warning">
                            <i class="fas fa-bell me-2"></i>Éléments nécessitant votre attention
                        </h6>
                        <span class="badge bg-warning text-dark">{{ count($alerts) }}</span>
                    </div>
                    <div class="row g-2">
                        @foreach($alerts as $alert)
                        <div class="col-lg-6 col-xl-4">
                            <div class="alert alert-{{ $alert['type'] }} border-0 mb-2 py-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $alert['icon'] }} me-2"></i>
                                        <span class="small">{{ $alert['message'] }}</span>
                                    </div>
                                    <a href="{{ $alert['action'] }}" class="btn btn-sm btn-outline-{{ $alert['type'] }}">
                                        {{ $alert['action_text'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Utilisateurs</div>
                            <div class="h3 mb-0 text-primary">{{ number_format($stats['users']['total']) }}</div>
                            <div class="small">
                                <span class="text-success">{{ $stats['users']['active'] }} actifs</span> • 
                                <span class="text-warning">{{ $stats['users']['pending'] }} en attente</span>
                            </div>
                        </div>
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $userTrend = $stats['users']['this_month'] - $stats['users']['last_month'];
                        @endphp
                        <small class="text-{{ $userTrend >= 0 ? 'success' : 'danger' }}">
                            <i class="fas fa-arrow-{{ $userTrend >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($userTrend) }} ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Annonces</div>
                            <div class="h3 mb-0 text-success">{{ number_format($stats['annonces']['total']) }}</div>
                            <div class="small">
                                <span class="text-success">{{ $stats['annonces']['published'] }} publiées</span> • 
                                <span class="text-warning">{{ $stats['annonces']['pending'] }} en attente</span>
                            </div>
                        </div>
                        <div class="stats-icon bg-success">
                            <i class="fas fa-bullhorn text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $annonceTrend = $stats['annonces']['this_month'] - $stats['annonces']['last_month'];
                        @endphp
                        <small class="text-{{ $annonceTrend >= 0 ? 'success' : 'danger' }}">
                            <i class="fas fa-arrow-{{ $annonceTrend >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($annonceTrend) }} ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Avis</div>
                            <div class="h3 mb-0 text-warning">{{ number_format($stats['reviews']['total']) }}</div>
                            <div class="small">
                                <span class="text-success">{{ $stats['reviews']['approved'] }} approuvés</span> • 
                                <span class="text-warning">{{ $stats['reviews']['pending'] }} en attente</span>
                            </div>
                        </div>
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-star text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-info">
                            <i class="fas fa-chart-line me-1"></i>
                            Moyenne: {{ number_format($stats['reviews']['average_rating'], 1) }}/5
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Signalements</div>
                            <div class="h3 mb-0 text-danger">{{ number_format($stats['reports']['total']) }}</div>
                            <div class="small">
                                <span class="text-danger">{{ $stats['reports']['pending'] }} en attente</span> • 
                                <span class="text-success">{{ $stats['reports']['processed'] }} traités</span>
                            </div>
                        </div>
                        <div class="stats-icon bg-danger">
                            <i class="fas fa-flag text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($stats['reports']['critical'] > 0)
                        <small class="text-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            {{ $stats['reports']['critical'] }} critiques
                        </small>
                        @else
                        <small class="text-success">
                            <i class="fas fa-check me-1"></i>
                            Aucun critique
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- User Registration Trend -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-line me-2"></i>Évolution des inscriptions
                    </h6>
                    <div class="small text-muted">12 derniers mois</div>
                </div>
                <div class="card-body">
                    <canvas id="userRegistrationChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Announcement Status Distribution -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Statut des annonces
                    </h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="annonceStatusChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Reviews Rating Distribution -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-star me-2"></i>Distribution des notes
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="reviewsRatingChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Activity -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Activité mensuelle
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyActivityChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Categories and Recent Activity -->
    <div class="row mb-4">
        <!-- Top Categories -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-tags me-2"></i>Catégories populaires
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="topCategoriesChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-clock me-2"></i>Activité récente
                    </h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <!-- Recent Users -->
                    @if(count($recentActivity['users']) > 0)
                    <div class="mb-3">
                        <div class="small text-muted fw-bold mb-2">NOUVEAUX UTILISATEURS</div>
                        @foreach($recentActivity['users'] as $user)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="avatar-sm bg-primary text-white me-3">
                                {{ strtoupper(substr($user->nom, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-medium">{{ $user->nom }}</div>
                                <div class="small text-muted">{{ $user->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="badge bg-{{ $user->statut === 'valide' ? 'success' : 'warning' }}">
                                {{ $user->statut }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Pending Announcements -->
                    @if(count($recentActivity['annonces']) > 0)
                    <div class="mb-3">
                        <div class="small text-muted fw-bold mb-2">ANNONCES EN ATTENTE</div>
                        @foreach($recentActivity['annonces'] as $annonce)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="fw-medium">{{ Str::limit($annonce->titre, 30) }}</div>
                                <div class="small text-muted">{{ $annonce->utilisateur->nom ?? 'Utilisateur inconnu' }} • {{ $annonce->created_at->diffForHumans() }}</div>
                            </div>
                            <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-sm btn-outline-primary">
                                Voir
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Pending Reviews -->
                    @if(count($recentActivity['reviews']) > 0)
                    <div class="mb-3">
                        <div class="small text-muted fw-bold mb-2">AVIS EN ATTENTE</div>
                        @foreach($recentActivity['reviews'] as $review)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <div class="rating-stars me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="fw-medium">{{ $review->utilisateur->nom ?? 'Utilisateur inconnu' }}</span>
                                </div>
                                <div class="small text-muted">{{ Str::limit($review->annonce->titre ?? 'Annonce inconnue', 25) }} • {{ $review->created_at->diffForHumans() }}</div>
                            </div>
                            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-outline-warning">
                                Modérer
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Recent Reports -->
                    @if(count($recentActivity['reports']) > 0)
                    <div>
                        <div class="small text-muted fw-bold mb-2">SIGNALEMENTS RÉCENTS</div>
                        @foreach($recentActivity['reports'] as $report)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="fw-medium">{{ Str::limit($report->annonce->titre ?? 'Annonce inconnue', 25) }}</div>
                                <div class="small text-muted">
                                    <span class="badge bg-danger text-white me-1">{{ str_replace('_', ' ', $report->type) }}</span>
                                    {{ $report->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <a href="{{ route('admin.annonces.show', $report->annonce->id) }}" class="btn btn-sm btn-outline-danger">
                                Traiter
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if(count($recentActivity['users']) === 0 && count($recentActivity['annonces']) === 0 && count($recentActivity['reviews']) === 0 && count($recentActivity['reports']) === 0)
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h6>Tout est à jour !</h6>
                        <p class="text-muted mb-0">Aucune activité récente nécessitant votre attention.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Overview -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-cogs me-2"></i>Vue d'ensemble du système
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-primary">{{ $stats['categories'] }}</div>
                                <div class="small text-muted">Catégories</div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-info">{{ $stats['cities'] }}</div>
                                <div class="small text-muted">Villes</div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-success">{{ number_format(($stats['users']['active'] / max($stats['users']['total'], 1)) * 100, 1) }}%</div>
                                <div class="small text-muted">Taux d'activation</div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-warning">{{ number_format(($stats['annonces']['published'] / max($stats['annonces']['total'], 1)) * 100, 1) }}%</div>
                                <div class="small text-muted">Annonces publiées</div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-info">{{ number_format($stats['reviews']['average_rating'], 1) }}/5</div>
                                <div class="small text-muted">Note moyenne</div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-{{ $stats['reports']['critical'] > 0 ? 'danger' : 'success' }}">
                                    {{ $stats['reports']['critical'] }}
                                </div>
                                <div class="small text-muted">Alertes critiques</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-content">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
        <div class="mt-2">Traitement en cours...</div>
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
    
    /* Rating stars */
    .rating-stars {
        font-size: 0.8rem;
        line-height: 1;
    }
    
    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    
    .loading-content {
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        text-align: center;
    }
    
    /* Chart containers */
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    /* Custom scrollbar */
    .card-body::-webkit-scrollbar {
        width: 6px;
    }
    
    .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .card-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .card-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .h3 {
            font-size: 1.5rem;
        }
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

// Chart data from backend
const chartData = @json($chartData);

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // User Registration Trend Chart
    const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
    new Chart(userRegistrationCtx, {
        type: 'line',
        data: {
            labels: chartData.userRegistrations.labels,
            datasets: [{
                label: 'Nouvelles inscriptions',
                data: chartData.userRegistrations.data,
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
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Announcement Status Distribution Chart
    const annonceStatusCtx = document.getElementById('annonceStatusChart').getContext('2d');
    new Chart(annonceStatusCtx, {
        type: 'doughnut',
        data: {
            labels: chartData.annonceStatus.labels,
            datasets: [{
                data: chartData.annonceStatus.data,
                backgroundColor: chartData.annonceStatus.colors,
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
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Reviews Rating Distribution Chart
    const reviewsRatingCtx = document.getElementById('reviewsRatingChart').getContext('2d');
    new Chart(reviewsRatingCtx, {
        type: 'bar',
        data: {
            labels: chartData.reviewsRating.labels,
            datasets: [{
                label: 'Nombre d\'avis',
                data: chartData.reviewsRating.data,
                backgroundColor: [
                    chartColors.danger,
                    '#ff6b35',
                    chartColors.warning,
                    '#4ade80',
                    chartColors.success
                ],
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
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Monthly Activity Chart
    const monthlyActivityCtx = document.getElementById('monthlyActivityChart').getContext('2d');
    new Chart(monthlyActivityCtx, {
        type: 'bar',
        data: {
            labels: chartData.monthlyActivity.labels,
            datasets: [
                {
                    label: 'Annonces',
                    data: chartData.monthlyActivity.annonces,
                    backgroundColor: chartColors.success + '80',
                    borderColor: chartColors.success,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
                },
                {
                    label: 'Avis',
                    data: chartData.monthlyActivity.reviews,
                    backgroundColor: chartColors.warning + '80',
                    borderColor: chartColors.warning,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Top Categories Chart
    const topCategoriesCtx = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCategoriesCtx, {
        type: 'bar',
        data: {
            labels: chartData.topCategories.labels,
            datasets: [{
                label: 'Nombre d\'annonces',
                data: chartData.topCategories.data,
                backgroundColor: chartColors.info + '80',
                borderColor: chartColors.info,
                borderWidth: 1,
                borderRadius: 4,
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
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
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

// Quick Actions
function quickAction(action) {
    showLoading();
    
    let url = '';
    let message = '';
    
    switch(action) {
        case 'approveUsers':
            url = '{{ route("admin.dashboard") }}/approve-users';
            message = 'Approbation des utilisateurs en cours...';
            break;
        case 'approveAnnonces':
            url = '{{ route("admin.dashboard") }}/approve-annonces';
            message = 'Approbation des annonces en cours...';
            break;
        case 'autoModerate':
            url = '{{ route("admin.dashboard") }}/auto-moderate';
            message = 'Modération automatique en cours...';
            break;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showNotification('Une erreur est survenue', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Une erreur est survenue', 'error');
        console.error('Error:', error);
    });
}

// Refresh Dashboard
function refreshDashboard() {
    showLoading();
    
    fetch('{{ route("admin.dashboard") }}/data', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        // Update statistics cards
        updateStats(data.stats);
        showNotification('Tableau de bord actualisé', 'success');
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur lors de l\'actualisation', 'error');
        console.error('Error:', error);
    });
}

// Update statistics cards
function updateStats(stats) {
    // Update user stats
    document.querySelector('.h3.text-primary').textContent = new Intl.NumberFormat().format(stats.users.total);
    
    // You can add more specific updates here for each stat card
}

// Show loading overlay
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

// Hide loading overlay
function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px;';
    
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Auto-refresh dashboard every 5 minutes
setInterval(() => {
    fetch('{{ route("admin.dashboard") }}/data')
        .then(response => response.json())
        .then(data => {
            updateStats(data.stats);
        })
        .catch(error => console.error('Auto-refresh error:', error));
}, 300000); // 5 minutes
</script>
@endsection