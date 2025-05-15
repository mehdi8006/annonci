@extends('layouts.admin')

@section('title', 'Gestion des Villes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Villes</h1>
        <a href="{{ route('admin.villes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Ajouter une ville
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Liste des villes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="villesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Région</th>
                            <th>Annonces</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($villes as $ville)
                        <tr>
                            <td>{{ $ville->id }}</td>
                            <td>{{ $ville->nom }}</td>
                            <td>{{ $ville->region }}</td>
                            <td>{{ $ville->annonces_count }}</td>
                            <td>
                                <a href="{{ route('admin.villes.edit', $ville->id) }}" class="btn btn-sm btn-primary">
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