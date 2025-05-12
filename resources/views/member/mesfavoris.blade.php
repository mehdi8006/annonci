@extends('layouts.member')

@section('title', 'Mes Favoris')

@section('content')
    <div class="page-header">
        <div class="header-content">
            <h1>Mes Annonces Favorites</h1>
            <div class="favorite-count">
                <span class="favorite-count-icon">❤️</span>
                <span class="favorite-count-number">{{ $favoris->count() }} Annonces</span>
            </div>
        </div>
    </div>
    
    <!-- Table Section -->
    <div class="favorites-table">
        @if($favoris->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Ville</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($favoris as $favorite)
                        <tr>
                            <td data-label="Image">
                                @if($favorite->annonce->images->count() > 0)
                                    <img src="{{ asset('storage/' . $favorite->annonce->images->first()->url) }}" 
                                         alt="{{ $favorite->annonce->titre }}" 
                                         class="ad-image">
                                @else
                                    <img src="/api/placeholder/120/90" 
                                         alt="{{ $favorite->annonce->titre }}" 
                                         class="ad-image">
                                @endif
                            </td>
                            <td data-label="Titre" class="ad-title">{{ $favorite->annonce->titre }}</td>
                            <td data-label="Catégorie">
                                <span class="category-badge">
                                    {{ $favorite->annonce->categorie->nom ?? 'Non catégorisée' }}
                                </span>
                            </td>
                            <td data-label="Prix" class="ad-price">
                                {{ number_format($favorite->annonce->prix, 2, ',', ' ') }} DH
                            </td>
                            <td data-label="Ville">
                                {{ $favorite->annonce->ville->nom ?? 'Non spécifiée' }}
                            </td>
                            <td data-label="Actions" class="actions-cell">
                                <a href="{{ route('details', $favorite->annonce->id) }}" class="view-btn">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <form action="{{ route('member.favoris.remove', $favorite->annonce->id) }}" 
                                      method="POST" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="remove-btn" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir retirer cette annonce de vos favoris ?')">
                                        <i class="fas fa-heart-broken"></i> Retirer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-favorites">
                <i class="fas fa-heart-broken" style="font-size: 48px; color: #cbd5e0; margin-bottom: 16px;"></i>
                <p>Vous n'avez pas encore d'annonces favorites</p>
                <a href="{{ route('homeshow') }}" class="browse-btn">
                    <i class="fas fa-search"></i>
                    Parcourir les annonces
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
    
    .favorite-count {
        display: flex;
        align-items: center;
        background-color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .favorite-count-icon {
        color: #ff4a4a;
        margin-right: 10px;
        font-size: 24px;
    }
    
    .favorite-count-number {
        font-size: 20px;
        font-weight: bold;
    }
    
    /* Table styles */
    .favorites-table {
        width: 100%;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background-color: #f8f8f8;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #555;
        border-bottom: 1px solid #e0e0e0;
    }
    
    td {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: middle;
    }
    
    tr:last-child td {
        border-bottom: none;
    }
    
    tr:hover {
        background-color: #f9f9f9;
    }
    
    /* Ad image */
    .ad-image {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    /* Ad title */
    .ad-title {
        font-weight: 600;
        color: #333;
    }
    
    .ad-price {
        font-weight: 600;
        color: #2563eb;
    }
    
    /* Category badge */
    .category-badge {
        display: inline-block;
        padding: 5px 10px;
        background-color: #e8f4fd;
        color: #0078d7;
        border-radius: 4px;
        font-size: 14px;
    }
    
    /* Buttons */
    .view-btn, .remove-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.2s;
        font-size: 14px;
    }
    
    .view-btn {
        background-color: #0078d7;
        color: white;
    }
    
    .view-btn:hover {
        background-color: #0062b1;
    }
    
    .remove-btn {
        background-color: #e53e3e;
        color: white;
    }
    
    .remove-btn:hover {
        background-color: #c53030;
    }
    
    .actions-cell {
        white-space: nowrap;
    }
    
    /* Empty state */
    .empty-favorites {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-favorites p {
        color: #718096;
        font-size: 18px;
        margin-bottom: 20px;
    }
    
    .browse-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #4299e1;
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    
    .browse-btn:hover {
        background-color: #3182ce;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        thead {
            display: none;
        }
        
        table, tbody, tr, td {
            display: block;
            width: 100%;
        }
        
        tr {
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        td {
            display: flex;
            justify-content: space-between;
            text-align: right;
            padding: 10px 15px;
            position: relative;
        }
        
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #555;
        }
        
        .ad-image {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
        }
        
        td[data-label="Image"] {
            flex-direction: column;
            text-align: center;
        }
        
        td[data-label="Image"]::before {
            display: none;
        }
        
        .actions-cell {
            flex-direction: column;
            gap: 10px;
        }
        
        .view-btn, .remove-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection