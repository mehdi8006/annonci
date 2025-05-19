@extends('admin.layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
    <div class="admin-header rounded-lg shadow-sm mb-4">
        <h1 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Gestion des utilisateurs</h1>
        <div class="admin-header-actions">
            <button type="button" class="admin-button" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-1"></i> Filtres
            </button>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtrer les utilisateurs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="search" class="admin-form-label">Recherche</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                        <input type="text" id="search" name="search" class="admin-form-input form-control" placeholder="Nom, email, téléphone..." value="{{ request('search') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="admin-form-group">
                                    <label for="statut" class="admin-form-label">Statut</label>
                                    <select id="statut" name="statut" class="admin-form-select form-select">
                                        <option value="">Tous les statuts</option>
                                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>Actif</option>
                                        <option value="supprime" {{ request('statut') === 'supprime' ? 'selected' : '' }}>Supprimé</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="admin-form-group">
                                    <label for="type" class="admin-form-label">Type</label>
                                    <select id="type" name="type" class="admin-form-select form-select">
                                        <option value="">Tous les types</option>
                                        <option value="normal" {{ request('type') === 'normal' ? 'selected' : '' }}>Utilisateur normal</option>
                                        <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" form="filterForm" class="admin-button">
                        <i class="fas fa-search me-1"></i> Appliquer les filtres
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card shadow-sm rounded-lg border-0">
        @if(request('search') || request('statut') || request('type'))
            <div class="alert alert-info m-3">
                <i class="fas fa-filter me-2"></i> Filtres actifs:
                @if(request('search'))<span class="badge bg-primary me-2">Recherche: {{ request('search') }}</span>@endif
                @if(request('statut'))<span class="badge bg-primary me-2">Statut: {{ request('statut') }}</span>@endif
                @if(request('type'))<span class="badge bg-primary me-2">Type: {{ request('type') }}</span>@endif
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary ms-2">Réinitialiser</a>
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="admin-table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Utilisateur</th>
                        <th>Contact</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        {{ strtoupper(substr($user->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $user->nom }}</div>
                                        <div class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fas fa-envelope me-1 text-muted"></i> {{ $user->email }}</div>
                                <div><i class="fas fa-phone me-1 text-muted"></i> {{ $user->telephon }}</div>
                                <div><i class="fas fa-map-marker-alt me-1 text-muted"></i> {{ $user->ville }}</div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle {{ $user->type_utilisateur === 'admin' ? 'btn-soft-primary' : 'btn-soft-secondary' }}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if($user->type_utilisateur === 'admin')
                                            <i class="fas fa-user-shield me-1"></i> Admin
                                        @else
                                            <i class="fas fa-user me-1"></i> Normal
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="{{ $user->statut }}">
                                                <input type="hidden" name="type_utilisateur" value="normal">
                                                <button type="submit" class="dropdown-item {{ $user->type_utilisateur === 'normal' ? 'active' : '' }}">
                                                    <i class="fas fa-user me-2"></i> Utilisateur normal
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="{{ $user->statut }}">
                                                <input type="hidden" name="type_utilisateur" value="admin">
                                                <button type="submit" class="dropdown-item {{ $user->type_utilisateur === 'admin' ? 'active' : '' }}">
                                                    <i class="fas fa-user-shield me-2"></i> Administrateur
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle 
                                        @if($user->statut === 'valide') btn-soft-success
                                        @elseif($user->statut === 'en_attente') btn-soft-warning
                                        @else btn-soft-danger @endif" 
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if($user->statut === 'valide')
                                            <i class="fas fa-check-circle me-1"></i> Actif
                                        @elseif($user->statut === 'en_attente')
                                            <i class="fas fa-clock me-1"></i> En attente
                                        @else
                                            <i class="fas fa-ban me-1"></i> Supprimé
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                                <input type="hidden" name="statut" value="valide">
                                                <button type="submit" class="dropdown-item {{ $user->statut === 'valide' ? 'active' : '' }}">
                                                    <i class="fas fa-check-circle text-success me-2"></i> Activer
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                                <input type="hidden" name="statut" value="en_attente">
                                                <button type="submit" class="dropdown-item {{ $user->statut === 'en_attente' ? 'active' : '' }}">
                                                    <i class="fas fa-clock text-warning me-2"></i> Mettre en attente
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                                <input type="hidden" name="statut" value="supprime">
                                                <button type="submit" class="dropdown-item {{ $user->statut === 'supprime' ? 'active' : '' }}">
                                                    <i class="fas fa-ban text-danger me-2"></i> Désactiver
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination m-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('css')
<style>
    /* Modern styles */
    .admin-card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        padding: 0;
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .admin-header {
        background-color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 0.75rem;
    }
    
    .admin-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .admin-table th {
        padding: 1rem;
        font-weight: 600;
        color: #4b5563;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .admin-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    
    .admin-table tr:last-child td {
        border-bottom: none;
    }
    
    .admin-table tr:hover {
        background-color: #f9fafb;
    }
    
    .btn-soft-primary {
        background-color: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: none;
    }
    
    .btn-soft-secondary {
        background-color: rgba(100, 116, 139, 0.1);
        color: #64748b;
        border: none;
    }
    
    .btn-soft-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: none;
    }
    
    .btn-soft-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: none;
    }
    
    .btn-soft-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: none;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        background-color: #3b82f6;
        color: white;
        font-size: 16px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        justify-content: center;
    }
    
    .page-item {
        margin: 0 5px;
    }
    
    .page-link {
        display: block;
        padding: 0.5rem 0.75rem;
        line-height: 1.25;
        color: #3b82f6;
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .page-link:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #a0aec0;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #e2e8f0;
    }
    
    .dropdown-item.active {
        background-color: #f1f5f9;
        color: inherit;
    }
    
    /* For mobile responsiveness */
    @media (max-width: 767px) {
        .admin-table th, .admin-table td {
            padding: 0.75rem 0.5rem;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        
        .admin-table .btn {
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection