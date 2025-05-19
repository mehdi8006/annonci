<!-- resources/views/admin/reports/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion des signalements')

@section('content')
    <div class="admin-header">
        <h1>Gestion des signalements</h1>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="statut" class="admin-form-label">Statut</label>
                        <select id="statut" name="statut" class="admin-form-select">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="traitee" {{ request('statut') === 'traitee' ? 'selected' : '' }}>Traité</option>
                            <option value="rejetee" {{ request('statut') === 'rejetee' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="type" class="admin-form-label">Type</label>
                        <select id="type" name="type" class="admin-form-select">
                            <option value="">Tous les types</option>
                            <option value="fraude" {{ request('type') === 'fraude' ? 'selected' : '' }}>Fraude</option>
                            <option value="contenu_inapproprie" {{ request('type') === 'contenu_inapproprie' ? 'selected' : '' }}>Contenu inapproprié</option>
                            <option value="produit_interdit" {{ request('type') === 'produit_interdit' ? 'selected' : '' }}>Produit interdit</option>
                            <option value="doublon" {{ request('type') === 'doublon' ? 'selected' : '' }}>Doublon</option>
                            <option value="mauvaise_categorie" {{ request('type') === 'mauvaise_categorie' ? 'selected' : '' }}>Mauvaise catégorie</option>
                            <option value="autre" {{ request('type') === 'autre' ? 'selected' : '' }}>Autre</option>
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
                        <th>Type</th>
                        <th>Signalé par</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ Str::limit($report->annonce->titre, 30) }}</td>
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
                            <td class="admin-table-actions">
                                <a href="{{ route('admin.reports.show', $report->id) }}" class="admin-button">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination mt-4">
            {{ $reports->appends(request()->query())->links() }}
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