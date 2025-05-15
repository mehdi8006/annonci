@extends('layouts.admin')

@section('title', 'Gestion des Annonces')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Gestion des Annonces</h1>
    
    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Filtres</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.annonces') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Titre, description..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <select class="form-select" id="categorie" name="categorie">
                        <option value="">Toutes</option>
                        @foreach(App\Models\Categorie::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="ville" class="form-label">Ville</label>
                    <select class="form-select" id="ville" name="ville">
                        <option value="">Toutes</option>
                        @foreach(App\Models\Ville::all() as $ville)
                            <option value="{{ $ville->id }}" {{ request('ville') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select" id="statut" name="statut">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="validee" {{ request('statut') == 'validee' ? 'selected' : '' }}>Validée</option>
                        <option value="supprimee" {{ request('statut') == 'supprimee' ? 'selected' : '' }}>Supprimée</option>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.annonces') }}" class="btn btn-secondary">
                            <i class="fas fa-undo me-1"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Annonces List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold">Liste des annonces</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="annoncesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Utilisateur</th>
                            <th>Catégorie</th>
                            <th>Ville</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($annonces as $annonce)
                        <tr>
                            <td>{{ $annonce->id }}</td>
                            <td class="text-center">
                                @if($annonce->images->where('principale', true)->first())
                                    <img src="{{ asset($annonce->images->where('principale', true)->first()->url) }}" 
                                        alt="{{ $annonce->titre }}" style="max-width: 60px; max-height: 60px;">
                                @elseif($annonce->images->first())
                                    <img src="{{ asset($annonce->images->first()->url) }}" 
                                        alt="{{ $annonce->titre }}" style="max-width: 60px; max-height: 60px;">
                                @else
                                    <span class="badge bg-secondary">Pas d'image</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($annonce->titre, 30) }}</td>
                            <td>{{ $annonce->prix }} DH</td>
                            <td>{{ $annonce->utilisateur->nom }}</td>
                            <td>{{ $annonce->categorie->nom }}</td>
                            <td>{{ $annonce->ville->nom }}</td>
                            <td>
                                @if($annonce->statut == 'en_attente')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($annonce->statut == 'validee')
                                    <span class="badge bg-success">Validée</span>
                                @else
                                    <span class="badge bg-danger">Supprimée</span>
                                @endif
                            </td>
                            <td>{{ $annonce->date_publication }}</td>
                            <td>
                                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.annonces.edit', $annonce->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $annonce->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $annonce->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $annonce->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $annonce->id }}">Confirmer la suppression</h5>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add dataTable initialization if needed
    });
</script>
@endsection