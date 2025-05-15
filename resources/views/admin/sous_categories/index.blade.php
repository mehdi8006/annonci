@extends('layouts.admin')

@section('title', 'Gestion des Sous-Catégories')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            Gestion des Sous-Catégories
            @if($categorieId)
                de {{ App\Models\Categorie::find($categorieId)->nom }}
            @endif
        </h1>
        <a href="{{ route('admin.sous_categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Ajouter une sous-catégorie
        </a>
    </div>
    
    <!-- Filter by Category -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Filtrer par catégorie</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sous_categories') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select class="form-select" id="categorie" name="categorieId">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categorieId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Liste des sous-catégories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="sousCategoriesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Description</th>
                            <th>Annonces</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sousCategories as $sousCategorie)
                        <tr>
                            <td>{{ $sousCategorie->id }}</td>
                            <td>{{ $sousCategorie->nom }}</td>
                            <td>{{ $sousCategorie->categorie->nom }}</td>
                            <td>{{ Str::limit($sousCategorie->description, 50) }}</td>
                            <td>{{ $sousCategorie->annonces_count }}</td>
                            <td>
                                <a href="{{ route('admin.sous_categories.edit', $sousCategorie->id) }}" class="btn btn-sm btn-primary">
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
@endsection