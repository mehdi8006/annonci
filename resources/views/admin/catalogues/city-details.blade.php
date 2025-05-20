<!-- resources/views/admin/catalogues/city-details.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Détails de la Ville')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with back button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $ville->nom }}</h1>
        <a href="{{ route('admin.catalogues.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- City Details Card -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-muted mb-1">ID</div>
                        <div>{{ $ville->id }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Nom</div>
                        <div>{{ $ville->nom }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Région</div>
                        <div>{{ $ville->region ?? 'Non spécifiée' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Nombre d'annonces</div>
                        <div>
                            <span class="badge bg-info px-2 py-1">{{ $ville->annonces->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Date de création</div>
                        <div>{{ $ville->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Dernière modification</div>
                        <div>{{ $ville->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="d-flex mt-4">
                        <a href="{{ route('admin.cities.edit', $ville->id) }}" class="btn btn-primary flex-grow-1 me-2">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                        @if($ville->annonces->count() == 0)
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('admin.cities.destroy', $ville->id) }}', 'cette ville')">
                                <i class="fas fa-trash me-1"></i> Supprimer
                            </button>
                        @else
                            <button type="button" class="btn btn-danger" disabled title="Suppression impossible - contient des annonces">
                                <i class="fas fa-trash me-1"></i> Supprimer
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Announcements Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-bullhorn me-2"></i>Annonces dans cette ville
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($ville->annonces->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3" width="5%">ID</th>
                                        <th width="35%">Titre</th>
                                        <th width="15%">Catégorie</th>
                                        <th width="15%">Prix</th>
                                        <th width="15%">Statut</th>
                                        <th width="15%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ville->annonces->take(10) as $annonce)
                                        <tr>
                                            <td class="ps-3 fw-medium">{{ $annonce->id }}</td>
                                            <td>{{ $annonce->titre }}</td>
                                            <td>{{ $annonce->categorie->nom }}</td>
                                            <td>{{ number_format($annonce->prix, 0, ',', ' ') }} DH</td>
                                            <td>
                                                <span class="badge 
                                                    @if($annonce->statut === 'validee') bg-success
                                                    @elseif($annonce->statut === 'en_attente') bg-warning text-dark
                                                    @else bg-danger @endif">
                                                    {{ $annonce->statut }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($ville->annonces->count() > 10)
                            <div class="p-3 text-center">
                                <span class="text-muted">Affichage des 10 premières annonces sur {{ $ville->annonces->count() }}</span>
                                <a href="{{ route('admin.annonces.index', ['ville' => $ville->id]) }}" class="btn btn-link">Voir toutes les annonces</a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state p-5 text-center">
                            <div class="empty-icon mb-3">
                                <i class="fas fa-bullhorn fa-3x text-muted"></i>
                            </div>
                            <h5>Aucune annonce</h5>
                            <p class="text-muted">Aucune annonce n'est associée à cette ville pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmation de suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Êtes-vous sûr de vouloir supprimer <span id="deleteItemName"></span> ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Delete confirmation
    function confirmDelete(deleteUrl, itemName) {
        document.getElementById('deleteItemName').textContent = itemName;
        document.getElementById('deleteForm').action = deleteUrl;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        modal.show();
    }
</script>
@endsection