@extends('admin.layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
    <div class="admin-header rounded-lg shadow-sm mb-4">
        <h1 class="mb-0"><i class="fas fa-user-circle me-2 text-primary"></i>Détails de l'utilisateur</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.users.index') }}" class="admin-button">
                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="admin-card shadow-sm rounded-lg border-0 mb-4">
                <div class="card-body p-0">
                    <div class="profile-header">
                        <div class="user-status-badge 
                            @if($user->statut === 'valide') status-active
                            @elseif($user->statut === 'en_attente') status-pending
                            @else status-inactive @endif">
                            @if($user->statut === 'valide')
                                <i class="fas fa-check-circle"></i> Compte actif
                            @elseif($user->statut === 'en_attente')
                                <i class="fas fa-clock"></i> En attente
                            @else
                                <i class="fas fa-ban"></i> Compte désactivé
                            @endif
                        </div>
                    </div>
                    <div class="profile-content text-center p-4">
                        <div class="user-avatar mx-auto mb-3">
                            {{ strtoupper(substr($user->nom, 0, 1)) }}
                        </div>
                        <h4 class="user-name">{{ $user->nom }}</h4>
                        <p class="user-role mb-3">
                            @if($user->type_utilisateur === 'admin')
                                <span class="badge bg-primary"><i class="fas fa-user-shield me-1"></i> Administrateur</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-user me-1"></i> Utilisateur normal</span>
                            @endif
                        </p>
                        <p class="user-joined text-muted mb-0">
                            <i class="fas fa-calendar-alt me-1"></i> Membre depuis {{ $user->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="admin-card shadow-sm rounded-lg border-0 mb-4">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-address-card me-2 text-primary"></i>Coordonnées</h5>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="info-item">
                            <span class="info-icon"><i class="fas fa-envelope"></i></span>
                            <div class="info-content">
                                <label>Email</label>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-icon"><i class="fas fa-phone"></i></span>
                            <div class="info-content">
                                <label>Téléphone</label>
                                <p>{{ $user->telephon }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <div class="info-content">
                                <label>Ville</label>
                                <p>{{ $user->ville }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Actions -->
            <div class="admin-card shadow-sm rounded-lg border-0">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-cog me-2 text-primary"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <!-- Change Status Buttons -->
                        <div class="action-group mb-3">
                            <label class="action-label">Modifier le statut</label>
                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                    <input type="hidden" name="statut" value="valide">
                                    <button type="submit" class="btn btn-success w-100 mb-2 {{ $user->statut === 'valide' ? 'active' : '' }}">
                                        <i class="fas fa-check-circle me-2"></i> Activer le compte
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                    <input type="hidden" name="statut" value="en_attente">
                                    <button type="submit" class="btn btn-warning w-100 mb-2 {{ $user->statut === 'en_attente' ? 'active' : '' }}">
                                        <i class="fas fa-clock me-2"></i> Mettre en attente
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                                    <input type="hidden" name="statut" value="supprime">
                                    <button type="submit" class="btn btn-danger w-100 {{ $user->statut === 'supprime' ? 'active' : '' }}">
                                        <i class="fas fa-ban me-2"></i> Désactiver le compte
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Change Type Buttons -->
                        <div class="action-group">
                            <label class="action-label">Modifier le type</label>
                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="statut" value="{{ $user->statut }}">
                                    <input type="hidden" name="type_utilisateur" value="normal">
                                    <button type="submit" class="btn btn-outline-secondary w-100 mb-2 {{ $user->type_utilisateur === 'normal' ? 'active' : '' }}">
                                        <i class="fas fa-user me-2"></i> Utilisateur normal
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="statut" value="{{ $user->statut }}">
                                    <input type="hidden" name="type_utilisateur" value="admin">
                                    <button type="submit" class="btn btn-outline-primary w-100 {{ $user->type_utilisateur === 'admin' ? 'active' : '' }}">
                                        <i class="fas fa-user-shield me-2"></i> Administrateur
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- User's Listings -->
            <div class="admin-card shadow-sm rounded-lg border-0">
                <div class="card-header border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Annonces de l'utilisateur</h5>
                    <span class="badge bg-primary">{{ $user->annonces->count() }} annonce(s)</span>
                </div>
                
                @if($user->annonces->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Titre</th>
                                        <th>Prix</th>
                                        <th>Catégorie</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->annonces as $annonce)
                                        <tr>
                                            <td class="fw-bold text-muted">{{ $annonce->id }}</td>
                                            <td>{{ Str::limit($annonce->titre, 30) }}</td>
                                            <td class="fw-bold">{{ number_format($annonce->prix, 2, ',', ' ') }} DH</td>
                                            <td>{{ $annonce->categorie->nom ?? 'N/A' }}</td>
                                            <td>
                                                @if($annonce->statut === 'validee')
                                                    <span class="badge rounded-pill bg-success">Validée</span>
                                                @elseif($annonce->statut === 'en_attente')
                                                    <span class="badge rounded-pill bg-warning text-dark">En attente</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Supprimée</span>
                                                @endif
                                            </td>
                                            <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-sm btn-outline-primary rounded-circle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        <div class="empty-state text-center p-4">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-store-slash"></i>
                            </div>
                            <h6>Aucune annonce trouvée</h6>
                            <p class="text-muted">Cet utilisateur n'a pas encore publié d'annonces.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    /* General styles */
    .mb-2 {
        margin-bottom: 0.5rem;
    }
    
    .mb-3 {
        margin-bottom: 1rem;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .me-1 {
        margin-right: 0.25rem;
    }
    
    .me-2 {
        margin-right: 0.5rem;
    }
    
    .w-100 {
        width: 100%;
    }
    
    .text-center {
        text-align: center;
    }
    
    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }
    
    .p-4 {
        padding: 1.5rem;
    }
    
    /* Admin Card Styles */
    .admin-card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    /* Profile Section */
    .profile-header {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        padding: 1.5rem;
        position: relative;
        height: 80px;
    }
    
    .user-status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: white;
    }
    
    .status-active {
        background-color: rgba(16, 185, 129, 0.9);
    }
    
    .status-pending {
        background-color: rgba(245, 158, 11, 0.9);
    }
    
    .status-inactive {
        background-color: rgba(239, 68, 68, 0.9);
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        background-color: #3b82f6;
        color: white;
        font-size: 28px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .profile-content {
        padding-top: 2rem;
    }
    
    .user-name {
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    /* Contact information section */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .info-icon {
        background-color: #f1f5f9;
        color: #3b82f6;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-content label {
        display: block;
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .info-content p {
        color: #1f2937;
        font-weight: 500;
        margin: 0;
    }
    
    /* Action buttons section */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .action-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .action-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    
    /* Empty state */
    .empty-state {
        padding: 2rem;
        text-align: center;
    }
    
    .empty-state-icon {
        font-size: 2.5rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    /* Table styling */
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
    
    /* Button active states */
    .btn.active {
        opacity: 0.8;
    }
    
    /* For mobile responsiveness */
    @media (max-width: 992px) {
        .admin-table th, .admin-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .user-avatar {
            width: 60px;
            height: 60px;
            font-size: 20px;
        }
    }
    
    @media (max-width: 767px) {
        .profile-header {
            height: 60px;
        }
        
        .user-status-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            font-size: 18px;
        }
        
        .info-icon {
            width: 30px;
            height: 30px;
        }
    }
</style>
@endsection