@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Catégories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Ajouter une catégorie
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Liste des catégories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="categoriesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Sous-catégories</th>
                            <th>Annonces</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->nom }}</td>
                            <td>{{ Str::limit($categorie->description, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.sous_categories', $categorie->id) }}" class="btn btn-sm btn-outline-info">
                                    {{ $categorie->sousCategories->count() }} sous-catégories
                                </a>
                            </td>
                            <td>{{ $categorie->annonces_count }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.sous_categories', $categorie->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-list"></i>
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