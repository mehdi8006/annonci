<!-- resources/views/admin/users/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
    <div class="admin-header">
        <h1>Détails de l'utilisateur</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.users.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Informations générales</h2>
                    <span class="admin-badge 
                        @if($user->statut === 'valide') admin-badge-success
                        @elseif($user->statut === 'en_attente') admin-badge-warning
                        @else admin-badge-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $user->statut)) }}
                    </span>
                </div>
                
                <div class="admin-user-details">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr($user->nom, 0, 1)) }}
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Nom</div>
                        <div class="admin-detail-value">{{ $user->nom }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Email</div>
                        <div class="admin-detail-value">{{ $user->email }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Téléphone</div>
                        <div class="admin-detail-value">{{ $user->telephon }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Ville</div>
                        <div class="admin-detail-value">{{ $user->ville }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Type</div>
                        <div class="admin-detail-value">
                            @if($user->type_utilisateur === 'admin')
                                <span class="admin-badge admin-badge-primary">Administrateur</span>
                            @else
                                <span class="admin-badge admin-badge-secondary">Utilisateur normal</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Date d'inscription</div>
                        <div class="admin-detail-value">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Actions</h2>
                </div>
                
                <div class="admin-actions-container">
                    <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        
                        <div class="admin-form-group mb-3">
                            <label for="statut" class="admin-form-label">Modifier le statut</label>
                            <div class="admin-button-group">
                                <button type="submit" name="statut" value="valide" class="admin-button admin-button-success w-100 mb-2 @if($user->statut === 'valide') admin-button-active @endif">
                                    <i class="fas fa-check"></i> Activer
                                </button>
                                <button type="submit" name="statut" value="en_attente" class="admin-button admin-button-warning w-100 mb-2 @if($user->statut === 'en_attente') admin-button-active @endif">
                                    <i class="fas fa-clock"></i> Mettre en attente
                                </button>
                                <button type="submit" name="statut" value="supprime" class="admin-button admin-button-danger w-100 @if($user->statut === 'supprime') admin-button-active @endif">
                                    <i class="fas fa-ban"></i> Désactiver
                                </button>
                                <input type="hidden" name="type_utilisateur" value="{{ $user->type_utilisateur }}">
                            </div>
                        </div>
                    </form>
                    
                    <form action="{{ route('admin.users.updateStatusAndType', $user->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        
                        <div class="admin-form-group">
                            <label for="type_utilisateur" class="admin-form-label">Modifier le type</label>
                            <div class="admin-button-group">
                                <button type="submit" name="type_utilisateur" value="normal" class="admin-button admin-button-secondary w-100 mb-2 @if($user->type_utilisateur === 'normal') admin-button-active @endif">
                                    <i class="fas fa-user"></i> Utilisateur normal
                                </button>
                                <button type="submit" name="type_utilisateur" value="admin" class="admin-button admin-button-primary w-100 @if($user->type_utilisateur === 'admin') admin-button-active @endif">
                                    <i class="fas fa-user-shield"></i> Administrateur
                                </button>
                                <input type="hidden" name="statut" value="{{ $user->statut }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Annonces de l'utilisateur</h2>
                </div>
                
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Prix</th>
                                <th>Catégorie</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($user->annonces->count() > 0)
                                @foreach($user->annonces as $annonce)
                                    <tr>
                                        <td>{{ $annonce->id }}</td>
                                        <td>{{ Str::limit($annonce->titre, 50) }}</td>
                                        <td>{{ number_format($annonce->prix, 2, ',', ' ') }} DH</td>
                                        <td>{{ $annonce->categorie->nom ?? 'N/A' }}</td>
                                        <td>
                                            @if($annonce->statut === 'validee')
                                                <span class="admin-badge admin-badge-success">Validée</span>
                                            @elseif($annonce->statut === 'en_attente')
                                                <span class="admin-badge admin-badge-warning">En attente</span>
                                            @else
                                                <span class="admin-badge admin-badge-danger">Supprimée</span>
                                            @endif
                                        </td>
                                        <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                                        <td class="admin-table-actions">
                                            <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="admin-button">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Aucune annonce trouvée</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .mb-2 {
        margin-bottom: 0.5rem;
    }
    
    .mb-3 {
        margin-bottom: 1rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .w-100 {
        width: 100%;
    }
    
    .text-center {
        text-align: center;
    }
    
    .admin-detail-label {
        font-weight: 600;
        color: #6b7280;
    }
    
    .admin-detail-value {
        color: #1f2937;
    }
    
    .admin-user-details {
        padding: 15px 0;
    }
    
    .admin-user-avatar {
        width: 80px;
        height: 80px;
        background-color: #3b82f6;
        color: white;
        font-size: 32px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px;
    }
    
    .admin-detail-row {
        display: flex;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .admin-detail-row:last-child {
        border-bottom: none;
    }
    
    .admin-detail-row .admin-detail-label {
        flex: 1;