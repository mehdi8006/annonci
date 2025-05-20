<!-- resources/views/admin/catalogues/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion du Catalogue')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion du Catalogue</h1>
    </div>

    <!-- Categories Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-tag me-2"></i>Catégories
            </h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Nouvelle catégorie
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="categoriesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" width="5%">ID</th>
                            <th width="30%">Nom</th>
                            <th width="10%">Annonces</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $categorie)
                            <tr data-category-id="{{ $categorie->id }}" class="category-row">
                                <td class="ps-3 fw-medium">{{ $categorie->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="expandable-icon me-2" data-category-id="{{ $categorie->id }}">
                                            <i class="fas fa-plus-circle text-primary"></i>
                                        </span>
                                        <span>{{ $categorie->nom }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info px-2 py-1">{{ $categorie->annonces_count }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categories.show', $categorie->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($categorie->annonces_count == 0)
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete('{{ route('admin.categories.destroy', $categorie->id) }}', 'cette catégorie')" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-danger" disabled title="Suppression impossible - contient des annonces">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr class="subcategory-container" data-parent="{{ $categorie->id }}" style="display: none;">
                                <td colspan="4" class="p-0">
                                    <div class="subcategory-table p-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-muted">Sous-catégories de "{{ $categorie->nom }}"</h6>
                                            <a href="{{ route('admin.subcategories.create', $categorie->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus me-1"></i> Ajouter
                                            </a>
                                        </div>
                                        
                                        @if($categorie->sousCategories->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-0 bg-white">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="5%">ID</th>
                                                            <th width="65%">Nom</th>
                                                            <th width="30%" class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($categorie->sousCategories as $sousCategorie)
                                                            <tr>
                                                                <td>{{ $sousCategorie->id }}</td>
                                                                <td>{{ $sousCategorie->nom }}</td>
                                                                <td class="text-center">
                                                                    <div class="btn-group">
                                                                        <a href="{{ route('admin.subcategories.edit', $sousCategorie->id) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        @if($sousCategorie->annonces()->count() == 0)
                                                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                                    onclick="confirmDelete('{{ route('admin.subcategories.destroy', $sousCategorie->id) }}', 'cette sous-catégorie')" 
                                                                                    title="Supprimer">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-sm btn-outline-danger" disabled title="Suppression impossible - contient des annonces">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i> Aucune sous-catégorie disponible.
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cities Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-map-marker-alt me-2"></i>Villes
            </h5>
            <a href="{{ route('admin.cities.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Nouvelle ville
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" width="5%">ID</th>
                            <th width="30%">Nom</th>
                            <th width="20%">Région</th>
                            <th width="10%">Annonces</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($villes as $ville)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $ville->id }}</td>
                                <td>{{ $ville->nom }}</td>
                                <td>{{ $ville->region ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info px-2 py-1">{{ $ville->annonces_count }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.cities.show', $ville->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cities.edit', $ville->id) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($ville->annonces_count == 0)
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete('{{ route('admin.cities.destroy', $ville->id) }}', 'cette ville')" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-danger" disabled title="Suppression impossible - contient des annonces">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

@section('css')
<style>
    .expandable-icon {
        cursor: pointer;
        transition: transform 0.3s;
    }
    
    .expandable-icon.expanded {
        transform: rotate(45deg);
    }
    
    .subcategory-table {
        border-radius: 0.5rem;
    }
</style>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup expandable categories
        document.querySelectorAll('.expandable-icon').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category-id');
                const subcategoryRow = document.querySelector(`.subcategory-container[data-parent="${categoryId}"]`);
                
                // Toggle icon
                this.classList.toggle('expanded');
                if (this.classList.contains('expanded')) {
                    this.innerHTML = '<i class="fas fa-minus-circle text-primary"></i>';
                } else {
                    this.innerHTML = '<i class="fas fa-plus-circle text-primary"></i>';
                }
                
                // Toggle subcategory display
                if (subcategoryRow.style.display === 'none') {
                    subcategoryRow.style.display = 'table-row';
                } else {
                    subcategoryRow.style.display = 'none';
                }
            });
        });
    });
    
    // Delete confirmation
    function confirmDelete(deleteUrl, itemName) {
        document.getElementById('deleteItemName').textContent = itemName;
        document.getElementById('deleteForm').action = deleteUrl;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        modal.show();
    }
</script>
@endsection