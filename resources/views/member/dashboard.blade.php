@extends('layouts.member')

@section('title', 'Tableau de bord')

@section('content')
    <div class="page-header">
        <h1>Tableau de bord</h1>
        <p>Bienvenue dans votre espace membre</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-info">
                <h3>Total Annonces</h3>
                <p>{{ $totalAnnonces }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>En Attente</h3>
                <p>{{ $annoncesEnAttente }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon accepted">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-info">
                <h3>Validées</h3>
                <p>{{ $annoncesValidees }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon deleted">
                <i class="fas fa-trash"></i>
            </div>
            <div class="stat-info">
                <h3>Supprimées</h3>
                <p>{{ $annoncesSupprimees }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon favorites">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-info">
                <h3>Favoris</h3>
                <p>{{ $totalFavoris }}</p>
            </div>
        </div>
    </div>
    
    <!-- Recent Announcements -->
    <div class="content-box" style="margin-top: 30px;">
        <h2 style="margin-bottom: 20px;">Mes annonces récentes</h2>
        
        @if($recentAnnonces->count() > 0)
            <div class="recent-announcements">
                @foreach($recentAnnonces as $annonce)
                    <div class="announcement-card">
                        <div class="announcement-image">
                            @if($annonce->images->count() > 0)
                                <img src="{{ asset('storage/' . $annonce->images->first()->url) }}" alt="{{ $annonce->titre }}">
                            @else
                                <img src="/api/placeholder/120/90" alt="{{ $annonce->titre }}">
                            @endif
                        </div>
                        <div class="announcement-info">
                            <h3>{{ $annonce->titre }}</h3>
                            <p class="price">{{ number_format($annonce->prix, 2, ',', ' ') }} DH</p>
                            <p class="location">
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ $annonce->ville->nom ?? 'Non spécifiée' }}
                            </p>
                            <p class="category">
                                <i class="fas fa-tag"></i> 
                                {{ $annonce->categorie->nom ?? 'Non catégorisée' }}
                            </p>
                            <div class="announcement-status">
                                <span class="status status-{{ $annonce->statut }}">
                                    {{ ucfirst(str_replace('_', ' ', $annonce->statut)) }}
                                </span>
                            </div>
                        </div>
                        <div class="announcement-actions">
                            <a href="{{ route('details', $annonce->id) }}" class="btn-action btn-view" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('member.annonces.edit', $annonce->id) }}" class="btn-action btn-edit" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('member.annonces.delete', $annonce->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: #666; padding: 40px 0;">
                Vous n'avez pas encore d'annonces. 
                <a href="{{ route('member.annonces.create') }}" style="color: #3498db;">
                    Créer votre première annonce
                </a>
            </p>
        @endif
    </div>
@endsection

@section('styles')
<style>
    .stats-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        flex: 1;
        min-width: 200px;
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 20px;
        color: white;
    }
    
    .pending {
        background-color: #f6ad55;
    }
    
    .accepted {
        background-color: #48bb78;
    }
    
    .deleted {
        background-color: #e53e3e;
    }
    
    .total {
        background-color: #4299e1;
    }
    
    .favorites {
        background-color: #ed64a6;
    }
    
    .stat-info h3 {
        font-size: 14px;
        color: #718096;
        margin-bottom: 5px;
    }
    
    .stat-info p {
        font-size: 24px;
        font-weight: 600;
        color: #2d3748;
    }
    
    .recent-announcements {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .announcement-card {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        transition: background-color 0.2s;
    }
    
    .announcement-card:hover {
        background-color: #f7fafc;
    }
    
    .announcement-image {
        width: 120px;
        height: 90px;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .announcement-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .announcement-info {
        flex: 1;
    }
    
    .announcement-info h3 {
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
    }
    
    .announcement-info p {
        margin: 4px 0;
        font-size: 14px;
        color: #4a5568;
    }
    
    .announcement-info .price {
        font-weight: 600;
        color: #2563eb;
    }
    
    .announcement-status {
        margin-top: 8px;
    }
    
    .status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-en_attente {
        background-color: #feebc8;
        color: #c05621;
    }
    
    .status-validee {
        background-color: #c6f6d5;
        color: #2f855a;
    }
    
    .status-supprimee {
        background-color: #fed7d7;
        color: #c53030;
    }
    
    .announcement-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        text-decoration: none;
        transition: background-color 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-view {
        background-color: #ebf4ff;
        color: #3182ce;
    }
    
    .btn-view:hover {
        background-color: #bee3f8;
    }
    
    .btn-edit {
        background-color: #faf089;
        color: #d69e2e;
    }
    
    .btn-edit:hover {
        background-color: #f6e05e;
    }
    
    .btn-delete {
        background-color: #fed7d7;
        color: #c53030;
    }
    
    .btn-delete:hover {
        background-color: #feb2b2;
    }
    
    @media (max-width: 768px) {
        .announcement-card {
            flex-direction: column;
            align-items: stretch;
        }
        
        .announcement-image {
            width: 100%;
            height: 200px;
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .announcement-actions {
            margin-top: 10px;
            justify-content: flex-start;
        }
    }
</style>
@endsection