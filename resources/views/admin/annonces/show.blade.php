<!-- resources/views/admin/annonces/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Détails de l\'annonce')

@section('content')
    <div class="admin-header">
        <h1>Détails de l'annonce</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.annonces.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Informations générales</h2>
                    <span class="admin-badge 
                        @if($annonce->statut === 'validee') admin-badge-success
                        @elseif($annonce->statut === 'en_attente') admin-badge-warning
                        @else admin-badge-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $annonce->statut)) }}
                    </span>
                </div>
                
                <div class="admin-product-details">
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">ID</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->id }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Titre</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->titre }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Prix</div>
                        <div class="col-md-9 admin-detail-value">{{ number_format($annonce->prix, 2, ',', ' ') }} DH</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Catégorie</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->categorie->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Sous-catégorie</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->sousCategorie->nom ?? 'Non spécifiée' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Ville</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->ville->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Date de création</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Description</div>
                        <div class="col-md-9 admin-detail-value">{{ $annonce->description }}</div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Images</h2>
                </div>
                
                <div class="admin-product-images">
                    @if($annonce->images->count() > 0)
                        <div class="row">
                            @foreach($annonce->images as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="admin-image-card">
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="Image de l'annonce" class="admin-product-image">
                                        @if($image->principale)
                                            <span class="admin-image-badge">Principale</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Aucune image disponible</p>
                    @endif
                </div>
            </div>
            
            @if($annonce->reports->count() > 0)
                <div class="admin-card mt-4">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Signalements</h2>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Utilisateur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($annonce->reports as $report)
                                    <tr>
                                        <td>{{ $report->id }}</td>
                                        <td>
                                            @switch($report->type)
                                                @case('fraude')
                                                    <span class="admin-badge admin-badge-danger">Fraude</span>
                                                    @break
                                                @case('contenu_inapproprie')
                                                    <span class="admin-badge admin-badge-danger">Contenu inapproprié</span>
                                                    @break
                                                @case('produit_interdit')
                                                    <span class="admin-badge admin-badge-danger">Produit interdit</span>
                                                    @break
                                                @case('doublon')
                                                    <span class="admin-badge admin-badge-warning">Doublon</span>
                                                    @break
                                                @case('mauvaise_categorie')
                                                    <span class="admin-badge admin-badge-warning">Mauvaise catégorie</span>
                                                    @break
                                                @default
                                                    <span class="admin-badge admin-badge-secondary">Autre</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $report->utilisateur ? $report->utilisateur->nom : 'Anonyme' }}</td>
                                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($report->statut === 'traitee')
                                                <span class="admin-badge admin-badge-success">Traité</span>
                                            @elseif($report->statut === 'en_attente')
                                                <span class="admin-badge admin-badge-warning">En attente</span>
                                            @else
                                                <span class="admin-badge admin-badge-danger">Rejeté</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report->id) }}" class="admin-button">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Informations vendeur</h2>
                </div>
                
                <div class="admin-user-details">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr($annonce->utilisateur->nom, 0, 1)) }}
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Nom</div>
                        <div class="admin-detail-value">{{ $annonce->utilisateur->nom }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Email</div>
                        <div class="admin-detail-value">{{ $annonce->utilisateur->email }}</div>
                    </div>
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Téléphone</div>
                        <div class="admin-detail-value">{{ $annonce->utilisateur->telephon }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Ville</div>
                        <div class="admin-detail-value">{{ $annonce->utilisateur->ville }}</div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Statut</div>
                        <div class="admin-detail-value">
                            @if($annonce->utilisateur->statut === 'valide')
                                <span class="admin-badge admin-badge-success">Actif</span>
                            @elseif($annonce->utilisateur->statut === 'en_attente')
                                <span class="admin-badge admin-badge-warning">En attente</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Supprimé</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.users.show', $annonce->utilisateur->id) }}" class="admin-button w-100">
                            <i class="fas fa-user-edit"></i> Voir profil vendeur
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Changer le statut</h2>
                </div>
                
                <div class="admin-actions-container">
                    <form action="{{ route('admin.annonces.updateStatus', $annonce->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="admin-button-group">
                            <button type="submit" name="statut" value="validee" class="admin-button admin-button-success w-100 mb-2 @if($annonce->statut === 'validee') admin-button-active @endif">
                                <i class="fas fa-check"></i> Approuver l'annonce
                            </button>
                            
                            <button type="submit" name="statut" value="en_attente" class="admin-button admin-button-warning w-100 mb-2 @if($annonce->statut === 'en_attente') admin-button-active @endif">
                                <i class="fas fa-clock"></i> Mettre en attente
                            </button>
                            
                            <button type="submit" name="statut" value="supprimee" class="admin-button admin-button-danger w-100 mb-3 @if($annonce->statut === 'supprimee') admin-button-active @endif">
                                <i class="fas fa-trash"></i> Supprimer l'annonce
                            </button>
                        </div>
                    </form>
                    
                    <a href="{{ route('details', $annonce->id) }}" target="_blank" class="admin-button w-100">
                        <i class="fas fa-external-link-alt"></i> Voir sur le site
                    </a>
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
    
    .mt-3 {
        margin-top: 1rem;
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
    
    .admin-product-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .admin-image-card {
        position: relative;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .admin-image-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #3b82f6;
        color: white;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 3px;
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
    }
    
    .admin-detail-row .admin-detail-value {
        flex: 2;
    }
    
    .admin-actions-container {
        padding: 15px 0;
    }
    
    .admin-button-group {
        display: flex;
        flex-direction: column;
    }
    
    .admin-button-active {
        opacity: 0.7;
        cursor: default;
    }
</style>
@endsection
                    
                  