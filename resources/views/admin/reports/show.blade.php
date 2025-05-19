<!-- resources/views/admin/reports/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Détails du signalement')

@section('content')
    <div class="admin-header">
        <h1>Détails du signalement</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.reports.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Informations sur le signalement</h2>
                    <span class="admin-badge 
                        @if($report->statut === 'traitee') admin-badge-success
                        @elseif($report->statut === 'en_attente') admin-badge-warning
                        @else admin-badge-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $report->statut)) }}
                    </span>
                </div>
                
                <div class="admin-report-details">
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">ID</div>
                        <div class="col-md-9 admin-detail-value">{{ $report->id }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Type</div>
                        <div class="col-md-9 admin-detail-value">
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
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Signalé par</div>
                        <div class="col-md-9 admin-detail-value">
                            @if($report->utilisateur)
                                {{ $report->utilisateur->nom }} ({{ $report->utilisateur->email }})
                            @else
                                Anonyme
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Date de signalement</div>
                        <div class="col-md-9 admin-detail-value">{{ $report->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Description</div>
                        <div class="col-md-9 admin-detail-value">
                            {{ $report->description ?? 'Aucune description fournie' }}
                        </div>
                    </div>
                    
                    @if($report->statut !== 'en_attente')
                        <div class="row mb-3">
                            <div class="col-md-3 admin-detail-label">Date de traitement</div>
                            <div class="col-md-9 admin-detail-value">{{ $report->date_traitement->format('d/m/Y H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Annonce signalée</h2>
                    <span class="admin-badge 
                        @if($report->annonce->statut === 'validee') admin-badge-success
                        @elseif($report->annonce->statut === 'en_attente') admin-badge-warning
                        @else admin-badge-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $report->annonce->statut)) }}
                    </span>
                </div>
                
                <div class="admin-reported-annonce">
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Titre</div>
                        <div class="col-md-9 admin-detail-value">{{ $report->annonce->titre }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Prix</div>
                        <div class="col-md-9 admin-detail-value">{{ number_format($report->annonce->prix, 2, ',', ' ') }} DH</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Vendeur</div>
                        <div class="col-md-9 admin-detail-value">{{ $report->annonce->utilisateur->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Catégorie</div>
                        <div class="col-md-9 admin-detail-value">{{ $report->annonce->categorie->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Ville</div>
                        <div class="col-md-9 admin-detail-value">{{ $report->annonce->ville->nom }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 admin-detail-label">Description</div>
                        <div class="col-md-9 admin-detail-value">{{ Str::limit($report->annonce->description, 200) }}</div>
                    </div>
                    
                    @if($report->annonce->images->count() > 0)
                        <div class="row mb-3">
                            <div class="col-md-3 admin-detail-label">Images</div>
                            <div class="col-md-9 admin-detail-value">
                                <div class="reported-annonce-images">
                                    @foreach($report->annonce->images as $image)
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="Image de l'annonce" class="reported-annonce-image">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a href="{{ route('admin.annonces.show', $report->annonce->id) }}" class="admin-button">
                                <i class="fas fa-eye"></i> Voir l'annonce complète
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Actions</h2>
                </div>
                
                @if($report->statut === 'en_attente')
                    <form action="{{ route('admin.reports.handle', $report->id) }}" method="POST">
                        @csrf
                        
                        <div class="admin-form-group">
                            <label for="statut" class="admin-form-label">Résolution</label>
                            <select id="statut" name="statut" class="admin-form-select @error('statut') is-invalid @enderror" required>
                                <option value="traitee">Traiter et approuver</option>
                                <option value="rejetee">Rejeter</option>
                            </select>
                            @error('statut')
                                <div class="admin-form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="action_annonce" class="admin-form-label">Action sur l'annonce</label>
                            <select id="action_annonce" name="action_annonce" class="admin-form-select">
                                <option value="">Aucune action</option>
                                <option value="suspend">Suspendre l'annonce</option>
                                <option value="delete">Supprimer l'annonce</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="admin-button w-100 mt-3">
                            <i class="fas fa-check"></i> Confirmer l'action
                        </button>
                    </form>
                @else
                    <div class="report-already-handled">
                        <div class="report-status-icon">
                            @if($report->statut === 'traitee')
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                        </div>
                        <div class="report-status-message">
                            @if($report->statut === 'traitee')
                                Ce signalement a déjà été traité le {{ $report->date_traitement->format('d/m/Y à H:i') }}.
                            @else
                                Ce signalement a été rejeté le {{ $report->date_traitement->format('d/m/Y à H:i') }}.
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    
    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-9 {
        flex: 0 0 75%;
        max-width: 75%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding-right: 15px;
        padding-left: 15px;
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
    
    .admin-detail-label {
        font-weight: 600;
        color: #6b7280;
    }
    
    .admin-detail-value {
        color: #1f2937;
    }
    
    .reported-annonce-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .reported-annonce-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .report-already-handled {
        padding: 20px;
        text-align: center;
    }
    
    .report-status-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }
    
    .report-status-icon .fa-check-circle {
        color: #10b981;
    }
    
    .report-status-icon .fa-times-circle {
        color: #ef4444;
    }
    
    .report-status-message {
        color: #6b7280;
        font-size: 16px;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
</style>
@endsection