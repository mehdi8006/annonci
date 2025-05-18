@extends('layouts.masterhome')

@section('main')
<div class="report-container">
    <div class="report-card">
        <div class="report-header">
            <h1>Signaler une annonce</h1>
            <p>Merci de nous aider à maintenir la qualité des annonces sur Annoncia</p>
        </div>
        
        <div class="report-ad-info">
            <h2>Information sur l'annonce</h2>
            <div class="ad-info">
                <p><strong>Titre:</strong> {{ $annonce->titre }}</p>
                <p><strong>Prix:</strong> {{ number_format($annonce->prix, 2, ',', ' ') }} DH</p>
                <p><strong>Vendeur:</strong> {{ $annonce->utilisateur->nom }}</p>
            </div>
        </div>
        
        <form action="{{ route('annonces.report.store', $annonce->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="type">Raison du signalement <span class="required">*</span></label>
                <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="">Sélectionnez une raison</option>
                    <option value="fraude" {{ old('type') == 'fraude' ? 'selected' : '' }}>Arnaque ou fraude</option>
                    <option value="contenu_inapproprie" {{ old('type') == 'contenu_inapproprie' ? 'selected' : '' }}>Contenu inapproprié</option>
                    <option value="produit_interdit" {{ old('type') == 'produit_interdit' ? 'selected' : '' }}>Produit interdit à la vente</option>
                    <option value="doublon" {{ old('type') == 'doublon' ? 'selected' : '' }}>Annonce en double</option>
                    <option value="mauvaise_categorie" {{ old('type') == 'mauvaise_categorie' ? 'selected' : '' }}>Mauvaise catégorie</option>
                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre problème</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Détails supplémentaires</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Veuillez fournir plus de détails sur le problème...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <a href="{{ route('details', $annonce->id) }}" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-submit">Envoyer le signalement</button>
            </div>
        </form>
    </div>
</div>

<style>
    .report-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 0 15px;
    }
    
    .report-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .report-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .report-header h1 {
        color: #e74c3c;
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .report-header p {
        color: #666;
    }
    
    .report-ad-info {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    
    .report-ad-info h2 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .ad-info p {
        margin: 8px 0;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #3498db;
    }
    
    .form-control.is-invalid {
        border-color: #e74c3c;
    }
    
    .invalid-feedback {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
    }
    
    .required {
        color: #e74c3c;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    
    .btn-cancel, .btn-submit {
        padding: 12px 25px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.3s;
    }
    
    .btn-cancel {
        background: #f1f1f1;
        color: #555;
        border: 1px solid #ddd;
    }
    
    .btn-submit {
        background: #e74c3c;
        color: white;
        border: none;
    }
    
    .btn-cancel:hover {
        background: #e7e7e7;
    }
    
    .btn-submit:hover {
        background: #c0392b;
    }
    
    @media (max-width: 768px) {
        .report-card {
            padding: 20px;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 15px;
        }
        
        .btn-cancel, .btn-submit {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection