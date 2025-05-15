@extends('layouts.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails de l'utilisateur</h1>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Informations personnelles</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <td>{{ $user->nom }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $user->telephon }}</td>
                            </tr>
                            <tr>
                                <th>Ville</th>
                                <td>{{ $user->ville }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>
                                    @if($user->type_utilisateur == 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">Normal</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Statut</th>
                                <td>
                                    @if($user->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($user->statut == 'valide')
                                        <span class="badge bg-success">Validé</span>
                                    @else
                                        <span class="badge bg-danger">Supprimé</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date d'inscription</th>
                                <td>{{ $user->date_inscription }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Statistiques</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Annonces</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($userAds) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Favoris</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($userFavorites) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-heart fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User's Ads -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Annonces de l'utilisateur</h6>
        </div>
        <div class="card-body">
            @if(count($userAds) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Prix</th>
                                <th>Catégorie</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userAds as $ad)
                            <tr>
                                <td>{{ $ad->id }}</td>
                                <td>{{ $ad->titre }}</td>
                                <td>{{ $ad->prix }} DH</td>
                                <td>{{ $ad->categorie->nom }}</td>
                                <td>
                                    @if($ad->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($ad->statut == 'validee')
                                        <span class="badge bg-success">Validée</span>
                                    @else
                                        <span class="badge bg-danger">Supprimée</span>
                                    @endif
                                </td>
                                <td>{{ $ad->date_publication }}</td>
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
            @else
                <p>Cet utilisateur n'a pas encore publié d'annonces.</p>
            @endif
        </div>
    </div>
    
    <!-- User's Favorites -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Annonces favorites</h6>
        </div>
        <div class="card-body">
            @if(count($userFavorites) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Prix</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userFavorites as $favorite)
                            <tr>
                                <td>{{ $favorite->annonce->id }}</td>
                                <td>{{ $favorite->annonce->titre }}</td>
                                <td>{{ $favorite->annonce->prix }} DH</td>
                                <td>{{ $favorite->annonce->categorie->nom }}</td>
                                <td>
                                    <a href="{{ route('admin.annonces.show', $favorite->annonce->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Cet utilisateur n'a pas encore ajouté d'annonces aux favoris.</p>
            @endif
        </div>
    </div>
</div>
@endsection