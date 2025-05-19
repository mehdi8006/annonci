<!-- resources/views/admin/dashboard.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="admin-header">
        <h1>Tableau de bord</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-title">Total Utilisateurs</div>
                <div class="stats-value">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-title">Utilisateurs Actifs</div>
                <div class="stats-value">{{ $activeUsers }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-warning">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stats-title">Utilisateurs en Attente</div>
                <div class="stats-value">{{ $pendingUsers }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-info">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="stats-title">Nouveaux ce mois</div>
                <div class="stats-value">{{ $newUsersThisMonth }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-primary">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stats-title">Total Annonces</div>
                <div class="stats-value">{{ $totalAnnonces }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-title">Annonces Actives</div>
                <div class="stats-value">{{ $activeAnnonces }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-title">Annonces en Attente</div>
                <div class="stats-value">{{ $pendingAnnonces }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="stats-icon stats-info">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="stats-title">Nouvelles ce mois</div>
                <div class="stats-value">{{ $newAnnoncesThisMonth }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="admin-stats-card">
                <div class="stats-icon stats-danger">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="stats-title">Signalements en Attente</div>
                <div class="stats-value">{{ $pendingReports }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="admin-stats-card">
                <div class="stats-icon stats-warning">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stats-title">Avis en Attente</div>
                <div class="stats-value">{{ $pendingReviews }}</div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Inscriptions d'utilisateurs (6 derniers mois)</h2>
                </div>
                <div>
                    <canvas id="userRegistrationsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Création d'annonces (6 derniers mois)</h2>
                </div>
                <div>
                    <canvas id="annonceCreationChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Derniers utilisateurs inscrits</h2>
                    <a href="{{ route('admin.users.index') }}" class="admin-button admin-button-secondary">
                        <i class="fas fa-users"></i> Voir tous
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestUsers as $user)
                                <tr>
                                    <td>{{ $user->nom }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($user->statut === 'valide')
                                            <span class="admin-badge admin-badge-success">Actif</span>
                                        @elseif($user->statut === 'en_attente')
                                            <span class="admin-badge admin-badge-warning">En attente</span>
                                        @else
                                            <span class="admin-badge admin-badge-danger">Supprimé</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Dernières annonces publiées</h2>
                    <a href="{{ route('admin.annonces.index') }}" class="admin-button admin-button-secondary">
                        <i class="fas fa-list"></i> Voir toutes
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Vendeur</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestAnnonces as $annonce)
                                <tr>
                                    <td>{{ $annonce->titre }}</td>
                                    <td>{{ $annonce->utilisateur->nom }}</td>
                                    <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($annonce->statut === 'validee')
                                            <span class="admin-badge admin-badge-success">Active</span>
                                        @elseif($annonce->statut === 'en_attente')
                                            <span class="admin-badge admin-badge-warning">En attente</span>
                                        @else
                                            <span class="admin-badge admin-badge-danger">Supprimée</span>
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

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Derniers signalements</h2>
                    <a href="{{ route('admin.reports.index') }}" class="admin-button admin-button-secondary">
                        <i class="fas fa-flag"></i> Voir tous
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Annonce</th>
                                <th>Type</th>
                                <th>Signalé par</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReports as $report)
                                <tr>
                                    <td>{{ $report->annonce->titre }}</td>
                                    <td>
                                        @switch($report->type)
                                            @case('fraude')
                                                <span class="admin-badge admin-badge-danger">Fraude</span>
                                                @break
                                            @case('contenu_inapproprie')
                                                <span class="admin-badge admin-badge-danger">Contenu inapproprié</span>
                                                @break
                                            @case('produit_interdit')
                                                <span class="admin-badge admin-badge-danger">Produit interdit</span>
                                                @break
                                            @case('doublon')
                                                <span class="admin-badge admin-badge-warning">Doublon</span>
                                                @break
                                            @case('mauvaise_categorie')
                                                <span class="admin-badge admin-badge-warning">Mauvaise catégorie</span>
                                                @break
                                            @default
                                                <span class="admin-badge admin-badge-secondary">Autre</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $report->utilisateur ? $report->utilisateur->nom : 'Anonyme' }}</td>
                                    <!-- Continuing resources/views/admin/dashboard.blade.php -->
                                    <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($report->statut === 'traitee')
                                            <span class="admin-badge admin-badge-success">Traité</span>
                                        @elseif($report->statut === 'en_attente')
                                            <span class="admin-badge admin-badge-warning">En attente</span>
                                        @else
                                            <span class="admin-badge admin-badge-danger">Rejeté</span>
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
@endsection

@section('js')
<script>
    // User Registrations Chart
    var userCtx = document.getElementById('userRegistrationsChart').getContext('2d');
    var userChart = new Chart(userCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($userRegistrationsChart['months']) !!},
            datasets: [{
                label: 'Nouveaux utilisateurs',
                data: {!! json_encode($userRegistrationsChart['counts']) !!},
                backgroundColor: '#3b82f6',
                borderColor: '#2563eb',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // Annonce Creation Chart
    var annonceCtx = document.getElementById('annonceCreationChart').getContext('2d');
    var annonceChart = new Chart(annonceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($annonceCreationChart['months']) !!},
            datasets: [{
                label: 'Nouvelles annonces',
                data: {!! json_encode($annonceCreationChart['counts']) !!},
                backgroundColor: '#10b981',
                borderColor: '#059669',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection