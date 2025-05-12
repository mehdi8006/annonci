@extends('layouts.member')

@section('title', 'Mes Annonces')

@section('content')
    <div class="page-header">
        <div class="header-content">
            <div class="header-text">
                <h1>Mes Annonces</h1>
                <p>Gérez toutes vos annonces en un seul endroit</p>
            </div>
            <a href="{{ route('member.annonces.create') }}" class="publish-btn">
                <i class="fas fa-plus"></i>
                Publier une annonce
            </a>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-info">
                <h3>Total</h3>
                <p>{{ $annonces->count() }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>En Attente</h3>
                <p>{{ $annonces->where('statut', 'en_attente')->count() }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon accepted">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-info">
                <h3>Validées</h3>
                <p>{{ $annonces->where('statut', 'validee')->count() }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon deleted">
                <i class="fas fa-trash"></i>
            </div>
            <div class="stat-info">
                <h3>Supprimées</h3>
                <p>{{ $annonces->where('statut', 'supprimee')->count() }}</p>
            </div>
        </div>
    </div>
    
    <!-- Announcements Table -->
    <div class="announcements-table">
        @if($annonces->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annonces as $annonce)
                        <tr>
                            <td>
                                @if($annonce->images->count() > 0)
                                    <img src="{{ asset('storage/' . $annonce->images->first()->url) }}" 
                                         alt="{{ $annonce->titre }}" 
                                         class="announcement-image">
                                @else
                                    <img src="/api/placeholder/60/60" 
                                         alt="{{ $annonce->titre }}" 
                                         class="announcement-image">
                                @endif
                            </td>
                            <td>{{ $annonce->titre }}</td>
                            <td>{{ $annonce->categorie->nom ?? 'Non catégorisée' }}</td>
                            <td>{{ number_format($annonce->prix, 2, ',', ' ') }} DH</td>
                            <td>
                                <span class="status status-{{ $annonce->statut }}">
                                    {{ ucfirst(str_replace('_', ' ', $annonce->statut)) }}
                                </span>
                            </td>
                            <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('details', $annonce->id) }}" class="btn btn-view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('member.annonces.edit', $annonce->id) }}" class="btn btn-edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('member.annonces.delete', $annonce->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" title="Supprimer" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 60px 20px; background-color: #fff; border-radius: 8px;">
                <i class="fas fa-folder-open" style="font-size: 48px; color: #cbd5e0; margin-bottom: 16px;"></i>
                <p style="color: #718096; font-size: 18px; margin-bottom: 20px;">
                    Vous n'avez pas encore d'annonces
                </p>
                <a href="{{ route('member.annonces.create') }}" class="publish-btn">
                    <i class="fas fa-plus"></i>
                    Publier votre première annonce
                </a>
            </div>
        @endif
    </div>
@endsection

@section('styles')
<style>
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .header-text h1 {
        margin-bottom: 5px;
    }
    
    .publish-btn {
        background-color: #4299e1;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s;
        text-decoration: none;
    }
    
    .publish-btn:hover {
        background-color: #3182ce;
    }
    
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
    
    .announcements-table {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background-color: #f8fafc;
        color: #4a5568;
        font-weight: 600;
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    
    td {
        padding: 12px 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
    }
    
    tr:hover {
        background-color: #f7fafc;
    }
    
    .announcement-image {
        width: 60px;
        height: 60px;
        border-radius: 4px;
        object-fit: cover;
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
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px;
        border-radius: 4px;
        transition: background-color 0.3s;
        font-size: 16px;
        color: #4a5568;
    }
    
    .btn:hover {
        background-color: #edf2f7;
    }
    
    .btn-view {
        color: #4299e1;
    }
    
    .btn-edit {
        color: #ecc94b;
    }
    
    .btn-delete {
        color: #e53e3e;
    }
    
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        table, tbody, tr, td {
            display: block;
            width: 100%;
        }
        
        thead {
            display: none;
        }
        
        tr {
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        td {
            padding: 10px 15px;
            position: relative;
            padding-left: 50%;
            border: none;
        }
        
        td:before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #4a5568;
        }
    }
</style>
@endsection