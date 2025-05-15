@extends('layouts.admin')

@section('title', 'Statistiques')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Statistiques et Rapports</h1>
    
    <div class="row">
        <!-- User Registration Chart -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Inscriptions d'utilisateurs (12 derniers mois)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ad Posting Chart -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Publication d'annonces (12 derniers mois)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="adPostingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Popular Categories -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Catégories populaires</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="popularCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Popular Cities -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Villes populaires</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="popularCitiesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Price Ranges -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Répartition des annonces par gamme de prix</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="priceRangesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status Distribution -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Répartition des annonces par statut</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Prepare data for charts
    document.addEventListener('DOMContentLoaded', function() {
        // User Registration Chart
        var userCtx = document.getElementById('userRegistrationChart').getContext('2d');
        var userChart = new Chart(userCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($userStats as $stat)
                        '{{ date("m/Y", mktime(0, 0, 0, $stat->month, 1, $stat->year)) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Inscriptions',
                    data: [
                        @foreach($userStats as $stat)
                            {{ $stat->count }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Ad Posting Chart
        var adCtx = document.getElementById('adPostingChart').getContext('2d');
        var adChart = new Chart(adCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($adStats as $stat)
                        '{{ date("m/Y", mktime(0, 0, 0, $stat->month, 1, $stat->year)) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Annonces publiées',
                    data: [
                        @foreach($adStats as $stat)
                            {{ $stat->count }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(28, 200, 138, 0.05)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(28, 200, 138, 1)',
                    pointHoverBorderColor: 'rgba(28, 200, 138, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Popular Categories Chart
        var categoryCtx = document.getElementById('popularCategoriesChart').getContext('2d');
        var categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach($popularCategories as $category)
                        '{{ $category->nom }}',
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($popularCategories as $category)
                            {{ $category->annonces_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#5a5c69', '#6610f2', '#fd7e14', '#20c997', '#6f42c1'
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        position: 'right'
                    }
                },
                cutout: '60%'
            }
        });

        // Popular Cities Chart
        var cityCtx = document.getElementById('popularCitiesChart').getContext('2d');
        var cityChart = new Chart(cityCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach($popularCities as $city)
                        '{{ $city->nom }}',
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($popularCities as $city)
                            {{ $city->annonces_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#5a5c69', '#6610f2', '#fd7e14', '#20c997', '#6f42c1'
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        position: 'right'
                    }
                },
                cutout: '60%'
            }
        });

        // Price Ranges Chart
        var priceRangesCtx = document.getElementById('priceRangesChart').getContext('2d');
        var priceRangesChart = new Chart(priceRangesCtx, {
            type: 'bar',
            data: {
                labels: Object.keys({{ json_encode($priceRanges) }}),
                datasets: [{
                    label: 'Nombre d\'annonces',
                    data: Object.values({{ json_encode($priceRanges) }}),
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(54, 185, 204, 0.8)',
                        'rgba(246, 194, 62, 0.8)',
                        'rgba(231, 74, 59, 0.8)'
                    ],
                    borderColor: [
                        'rgba(78, 115, 223, 1)',
                        'rgba(28, 200, 138, 1)',
                        'rgba(54, 185, 204, 1)',
                        'rgba(246, 194, 62, 1)',
                        'rgba(231, 74, 59, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Status Distribution Chart
        var statusDistributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
        var statusCounts = {
            'en_attente': {{ App\Models\Annonce::where('statut', 'en_attente')->count() }},
            'validee': {{ App\Models\Annonce::where('statut', 'validee')->count() }},
            'supprimee': {{ App\Models\Annonce::where('statut', 'supprimee')->count() }}
        };
        
        var statusDistributionChart = new Chart(statusDistributionCtx, {
            type: 'pie',
            data: {
                labels: ['En attente', 'Validée', 'Supprimée'],
                datasets: [{
                    data: [statusCounts['en_attente'], statusCounts['validee'], statusCounts['supprimee']],
                    backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        displayColors: false,
                        caretPadding: 10,
                    }
                }
            }
        });
    });
</script>
@endsection