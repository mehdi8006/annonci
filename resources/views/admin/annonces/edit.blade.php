<!-- resources/views/admin/annonces/edit.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Modifier une annonce')

@section('content')
    <div class="admin-header">
        <h1>Modifier une annonce</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle"></i> Note: Les modifications directes du contenu des annonces ne sont pas autorisées pour préserver l'intégrité des annonces. Vous pouvez uniquement changer le statut de l'annonce.
        </div>
        
        <form action="{{ route('admin.annonces.update', $annonce->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="titre" class="admin-form-label">Titre</label>
                        <input type="text" id="titre" name="titre" class="admin-form-input" value="{{ $annonce->titre }}" readonly>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="prix" class="admin-form-label">Prix (DH)</label>
                        <input type="number" id="prix" name="prix" step="0.01" class="admin-form-input" value="{{ $annonce->prix }}" readonly>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="id_categorie" class="admin-form-label">Catégorie</label>
                        <select id="id_categorie" name="id_categorie" class="admin-form-select" disabled>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ $annonce->id_categorie == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="id_sous_categorie" class="admin-form-label">Sous-catégorie</label>
                        <select id="id_sous_categorie" name="id_sous_categorie" class="admin-form-select" disabled>
                            <option value="">Aucune sous-catégorie</option>
                            @foreach($sousCategories as $sousCategorie)
                                <option value="{{ $sousCategorie->id }}" {{ $annonce->id_sous_categorie == $sousCategorie->id ? 'selected' : '' }}>{{ $sousCategorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="id_ville" class="admin-form-label">Ville</label>
                        <select id="id_ville" name="id_ville" class="admin-form-select" disabled>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}" {{ $annonce->id_ville == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="statut" class="admin-form-label">Statut</label>
                        <select id="statut" name="statut" class="admin-form-select @error('statut') is-invalid @enderror" required>
                            <option value="en_attente" {{ $annonce->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="validee" {{ $annonce->statut === 'validee' ? 'selected' : '' }}>Validée</option>
                            <option value="supprimee" {{ $annonce->statut === 'supprimee' ? 'selected' : '' }}>Supprimée</option>
                        </select>
                        @error('statut')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="admin-form-group">
                <label for="description" class="admin-form-label">Description</label>
                <textarea id="description" name="description" class="admin-form-textarea" readonly>{{ $annonce->description }}</textarea>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="admin-button admin-button-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" class="admin-button">
                    <i class="fas fa-save"></i> Mettre à jour le statut
                </button>
            </div>
        </form>
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
@endsection

@section('css')
<style>
    .mb-3 {
        margin-bottom: 1rem;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .d-flex {
        display: flex;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .text-center {
        text-align: center;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
    
    .alert {
        position: relative;
        padding: 1rem 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    
    .alert-info {
        color: #055160;
        background-color: #cff4fc;
        border-color: #b6effb;
    }
    
    .alert i {
        margin-right: 0.5rem;
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
</style>
@endsection