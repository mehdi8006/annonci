@extends('layouts.admin')

@section('title', 'Détails de l\'annonce')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails de l'annonce</h1>
        <div>
            <a href="{{ route('admin.annonces.edit', $annonce->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
            <a href="{{ route('admin.annonces') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Informations de l'annonce</h6>
                </div>
                <div class="card-body">
                    <h4>{{ $annonce->titre }}</h4>
                    <p class="badge bg-primary">{{ $annonce->prix }} DH</p>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($annonce->description)) !!}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $annonce->id }}</td>
                                </tr>
                                <tr>
                                    <th>Catégorie</th>
                                    <td>{{ $annonce->categorie->nom }}</td>
                                </tr>
                                <tr>
                                    <th>Sous-catégorie</th>
                                    <td>{{ $annonce->sousCategorie ? $annonce->sousCategorie->nom : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Ville</th>
                                    <td>{{ $annonce->ville->nom }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Statut</th>
                                    <td>
                                        @if($annonce->statut == 'en_attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($annonce->statut == 'validee')
                                            <span class="badge bg-success">Validée</span>
                                        @else
                                            <span class="badge bg-danger">Supprimée</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date de publication</th>
                                    <td>{{ $annonce->date_publication }}</td>
                                </tr>
                                <tr>
                                    <th>Créée le</th>
                                    <td>{{ $annonce->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Mise à jour le</th>
                                    <td>{{ $annonce->updated_at }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Images -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Images</h6>
                    <a href="{{ route('admin.images', $annonce->id) }}" class="btn btn-sm btn-primary">
                        Gérer les images
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($annonce->images as $image)
                            <div class="col-md-3 mb-3">
                                <div class="card {{ $image->principale ? 'border-primary' : '' }}">
                                    <img src="{{ asset($image->url) }}" class="card-img-top" alt="Image de l'annonce" style="height: 150px; object-fit: cover;">
                                    <div class="card-body text-center p-2">
                                        @if($image->principale)
                                            <span class="badge bg-primary">Image principale</span>
                                        @else
                                            <form action="{{ route('admin.images.set-main', $image->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Définir comme principale</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>Aucune image disponible pour cette annonce.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Publisher Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Informations sur l'annonceur</h6>
                </div>
                <div class="card-body">
                    <h5>{{ $annonce->utilisateur->nom }}</h5>
                    <p><i class="fas fa-envelope me-2"></i> {{ $annonce->utilisateur->email }}</p>
                    <p><i class="fas fa-phone me-2"></i> {{ $annonce->utilisateur->telephon }}</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i> {{ $annonce->utilisateur->ville }}</p>
                    <p>
                        <i class="fas fa-user-tag me-2"></i> 
                        @if($annonce->utilisateur->type_utilisateur == 'admin')
                            <span class="badge bg-primary">Admin</span>
                        @else
                            <span class="badge bg-secondary">Normal</span>
                        @endif
                    </p>
                    <p>
                        <i class="fas fa-user-check me-2"></i> 
                        @if($annonce->utilisateur->statut == 'en_attente')
                            <span class="badge bg-warning">En attente</span>
                        @elseif($annonce->utilisateur->statut == 'valide')
                            <span class="badge bg-success">Validé</span>
                        @else
                            <span class="badge bg-danger">Supprimé</span>
                        @endif
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('admin.users.show', $annonce->utilisateur->id) }}" class="btn btn-info w-100">
                            <i class="fas fa-user me-1"></i> Voir le profil
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Actions rapides</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.annonces.update', $annonce->id) }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="titre" value="{{ $annonce->titre }}">
                        <input type="hidden" name="description" value="{{ $annonce->description }}">
                        <input type="hidden" name="prix" value="{{ $annonce->prix }}">
                        <input type="hidden" name="id_categorie" value="{{ $annonce->id_categorie }}">
                        <input type="hidden" name="id_sous_categorie" value="{{ $annonce->id_sous_categorie }}">
                        <input type="hidden" name="id_ville" value="{{ $annonce->id_ville }}">
                        
                        <div class="mb-3">
                            <label for="statut" class="form-label">Changer le statut</label>
                            <select class="form-select" id="statut" name="statut">
                                <option value="en_attente" {{ $annonce->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="validee" {{ $annonce->statut == 'validee' ? 'selected' : '' }}>Validée</option>
                                <option value="supprimee" {{ $annonce->statut == 'supprimee' ? 'selected' : '' }}>Supprimée</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Mettre à jour le statut
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Supprimer l'annonce
                    </button>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cette annonce : <strong>{{ $annonce->titre }}</strong> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <form action="{{ route('admin.annonces.delete', $annonce->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
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