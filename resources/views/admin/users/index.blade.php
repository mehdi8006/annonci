@extends('admin.layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Liste des utilisateurs</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-1"></i> Filtrer
            </button>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Filtrer les utilisateurs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.index') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label for="search" class="form-label">Recherche</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Nom, email, téléphone..." value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select id="statut" name="statut" class="form-select">
                                    <option value="">Tous les statuts</option>
                                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>Actif</option>
                                    <option value="supprime" {{ request('statut') === 'supprime' ? 'selected' : '' }}>Supprimé</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select id="type" name="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    <option value="normal" {{ request('type') === 'normal' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">Réinitialiser</a>
                            <button type="submit" class="btn btn-primary">Appliquer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('search') || request('statut') || request('type'))
        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4">
            <div>
                <i class="fas fa-filter me-2 text-primary"></i> 
                <strong>Filtres: </strong>
                @if(request('search'))<span class="badge bg-primary me-2">Recherche: {{ request('search') }}</span>@endif
                @if(request('statut'))<span class="badge bg-primary me-2">Statut: {{ request('statut') }}</span>@endif
                @if(request('type'))<span class="badge bg-primary me-2">Type: {{ request('type') }}</span>@endif
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times me-1"></i> Effacer
            </a>
        </div>
    @endif

    <!-- Users Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" width="5%">ID</th>
                            <th width="25%">Utilisateur</th>
                            <th width="15%">Type</th>
                            <th width="15%">Statut</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-circle bg-primary text-white">
                                                {{ strtoupper(substr($user->nom, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->nom }}</h6>
                                            <small class="text-muted">Inscrit le {{ $user->created_at->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                               
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle {{ $user->type_utilisateur === 'admin' ? 'btn-light-primary' : 'btn-light-secondary' }}" type="button" data-bs-toggle="dropdown">
                                            @if($user->type_utilisateur === 'admin')
                                                <i class="fas fa-user-shield me-1"></i> Admin
                                            @else
                                                <i class="fas fa-user me-1"></i> Utilisateur
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu shadow-sm border-0">
                                            <li>
                                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="{{ $user->statut }}">
                                                    <input type="hidden" name="type_utilisateur" value="normal">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-user me-2 text-secondary"></i> Utilisateur
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="statut" value="{{ $user->statut }}">
                                                    <input type="hidden" name="type_utilisateur" value="admin">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-user-shield me-2 text-primary"></i> Admin
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle 
                                            @if($user->statut === 'valide') btn-light-success
                                            @elseif($user->statut === 'en_attente') btn-light-warning
                                            @else btn-light-danger @endif" 
                                            type="button" data-bs-toggle="dropdown">
                                            @if($user->statut === 'valide')
                                                <i class="fas fa-check-circle me-1"></i> Actif
                                            @elseif($user->statut === 'en_attente')
                                                <i class="fas fa-clock me-1"></i> En attente
                                            @else
                                                <i class="fas fa-ban me-1"></i> Supprimé
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu shadow-sm border-0">
                                            <li>
                                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                                    <input type="hidden" name="statut" value="valide">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-check-circle me-2 text-success"></i> Activer
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                                    <input type="hidden" name="statut" value="en_attente">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-clock me-2 text-warning"></i> En attente
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                                    <input type="hidden" name="statut" value="supprime">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-ban me-2 text-danger"></i> Désactiver
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> Voir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@section('css')
<style>
    /* Custom Avatar */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }
    
    /* Light Button Variants */
    .btn-light-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: none;
    }
    
    .btn-light-secondary {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: none;
    }
    
    .btn-light-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: none;
    }
    
    .btn-light-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: none;
    }
    
    .btn-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: none;
    }
    
    /* Dropdown Styling */
    .dropdown-menu {
        padding: 0.5rem 0;
        border-radius: 0.375rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    /* Table Styling */
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.75rem 0.5rem;
    }
    
    /* Pagination Styling */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        padding: 0.375rem 0.75rem;
        color: #0d6efd;
        border-radius: 0.25rem;
        margin: 0 0.125rem;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endsection