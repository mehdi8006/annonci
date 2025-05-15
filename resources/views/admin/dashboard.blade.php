@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Tableau de bord</h1>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 stats-card bg-primary text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 stats-card bg-success text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Annonces</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalAds }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 stats-card bg-info text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Catégories</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalCategories }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 stats-card bg-warning text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Villes</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalCities }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-city fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Ads -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Annonces récentes</h6>
                    <a href="{{ route('admin.annonces') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Prix</th>
                                    <th>Utilisateur</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAds as $ad)
                                <tr>
                                    <td>{{ $ad->id }}</td>
                                    <td>{{ $ad->titre }}</td>
                                    <td>{{ $ad->prix }} DH</td>
                                    <td>{{ $ad->utilisateur->nom }}</td>
                                    <td>
                                        @if($ad->statut == 'en_attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($ad->statut == 'validee')
                                            <span class="badge bg-success">Validée</span>
                                        @else
                                            <span class="badge bg-danger">Supprimée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.annonces.show', $ad->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.annonces.edit', $ad->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Derniers utilisateurs inscrits</h6>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->nom }}</td>
                                    <td>
                                        @if($user->type_utilisateur == 'admin')
                                            <span class="badge bg-primary">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">Normal</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
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

    <!-- Charts Row -->
    <div class="row">
        <!-- Categories Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Annonces par catégorie</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cities Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Annonces par ville</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="citiesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Categories Chart
    var categoryCtx = document.getElementById('categoriesChart').getContext('2d');
    var categoryChart = new Chart(categoryCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($adsPerCategory as $category)
                    '{{ $category->nom }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($adsPerCategory as $category)
                        {{ $category->annonces_count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#5a5c69', '#6610f2', '#fd7e14', '#20c997', '#6f42c1'
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'right'
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        },
    });

    // Cities Chart
    var cityCtx = document.getElementById('citiesChart').getContext('2d');
    var cityChart = new Chart(cityCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($adsPerCity as $city)
                    '{{ $city->nom }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($adsPerCity as $city)
                        {{ $city->annonces_count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#5a5c69', '#6610f2', '#fd7e14', '#20c997', '#6f42c1'
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'right'
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        },
    });
</script>
@endsection