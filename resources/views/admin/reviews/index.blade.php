<!-- resources/views/admin/reviews/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion des avis')

@section('content')
    <div class="admin-header">
        <h1>Gestion des avis</h1>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.reviews.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="statut" class="admin-form-label">Statut</label>
                        <select id="statut" name="statut" class="admin-form-select">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="approuve" {{ request('statut') === 'approuve' ? 'selected' : '' }}>Approuvé</option>
                            <option value="rejete" {{ request('statut') === 'rejete' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="rating" class="admin-form-label">Note</label>
                        <select id="rating" name="rating" class="admin-form-select">
                            <option value="">Toutes les notes</option>
                            <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 étoiles</option>
                            <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4 étoiles</option>
                            <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3 étoiles</option>
                            <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2 étoiles</option>
                            <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1 étoile</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label class="admin-form-label">&nbsp;</label>
                        <button type="submit" class="admin-button w-100">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Annonce</th>
                        <th>Utilisateur</th>
                        <th>Note</th>
                        <th>Commentaire</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ Str::limit($review->annonce->titre, 30) }}</td>
                            <td>{{ $review->utilisateur->nom }}</td>
                            <!-- resources/views/admin/reviews/index.blade.php (continued) -->
                            <td>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td>{{ Str::limit($review->comment, 50) ?? 'Pas de commentaire' }}</td>
                            <td>{{ $review->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($review->statut === 'approuve')
                                    <span class="admin-badge admin-badge-success">Approuvé</span>
                                @elseif($review->statut === 'en_attente')
                                    <span class="admin-badge admin-badge-warning">En attente</span>
                                @else
                                    <span class="admin-badge admin-badge-danger">Rejeté</span>
                                @endif
                            </td>
                            <td class="admin-table-actions">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="admin-button">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($review->statut === 'en_attente')
                                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="admin-button admin-button-success" onclick="return confirm('Êtes-vous sûr de vouloir approuver cet avis ?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="admin-button admin-button-danger" onclick="return confirm('Êtes-vous sûr de vouloir rejeter cet avis ?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination mt-4">
            {{ $reviews->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('css')
<style>
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .w-100 {
        width: 100%;
    }
    
    .rating-stars {
        color: #f59e0b;
        font-size: 14px;
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
        border-radius: 0.25rem;
        text-decoration: none;
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
    }
</style>
@endsection