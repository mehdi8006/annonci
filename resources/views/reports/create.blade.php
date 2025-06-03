@extends('layouts.masterhome')

@section('main')
<div style="margin-top: 80px;">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white text-center py-4">
                    <h1 class="h3 mb-2">
                        <i class="fas fa-flag me-2"></i>
                        Signaler une annonce
                    </h1>
                    <p class="mb-0 opacity-75">Merci de nous aider à maintenir la qualité des annonces sur Annoncia</p>
                </div>
                
                <div class="card-body p-4">
                    <!-- Ad Information -->
                    <div class="alert alert-light border mb-4">
                        <h5 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            Information sur l'annonce
                        </h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="mb-2"><strong>Titre:</strong> {{ $annonce->titre }}</p>
                                <p class="mb-2"><strong>Prix:</strong> <span class="text-success fw-bold">{{ number_format($annonce->prix, 2, ',', ' ') }} DH</span></p>
                                <p class="mb-0"><strong>Vendeur:</strong> {{ $annonce->utilisateur->nom }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Report Form -->
                    <form action="{{ route('annonces.report.store', $annonce->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="type" class="form-label fw-semibold">
                                Raison du signalement <span class="text-danger">*</span>
                            </label>
                            <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Sélectionnez une raison</option>
                                <option value="fraude" {{ old('type') == 'fraude' ? 'selected' : '' }}>
                                    <i class="fas fa-exclamation-triangle"></i> Arnaque ou fraude
                                </option>
                                <option value="contenu_inapproprie" {{ old('type') == 'contenu_inapproprie' ? 'selected' : '' }}>
                                    Contenu inapproprié
                                </option>
                                <option value="produit_interdit" {{ old('type') == 'produit_interdit' ? 'selected' : '' }}>
                                    Produit interdit à la vente
                                </option>
                                <option value="doublon" {{ old('type') == 'doublon' ? 'selected' : '' }}>
                                    Annonce en double
                                </option>
                                <option value="mauvaise_categorie" {{ old('type') == 'mauvaise_categorie' ? 'selected' : '' }}>
                                    Mauvaise catégorie
                                </option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>
                                    Autre problème
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Détails supplémentaires</label>
                            <textarea id="description" 
                                    name="description" 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    rows="5" 
                                    placeholder="Veuillez fournir plus de détails sur le problème...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Décrivez le problème en détail pour nous aider à mieux comprendre la situation.</div>
                        </div>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-between">
                            <a href="{{ route('details', $annonce->id) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Envoyer le signalement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection