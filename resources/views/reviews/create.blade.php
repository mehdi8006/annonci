{{-- resources/views/reviews/create.blade.php --}}
@extends('layouts.masterhome')

@section('main')
<div class="review-container">
    <div class="review-card">
        <div class="review-header">
            <h1>Laisser un avis</h1>
            <p>Partagez votre expérience avec cette annonce</p>
        </div>
        
        <div class="review-ad-info">
            <h2>Information sur l'annonce</h2>
            <div class="ad-info">
                <p><strong>Titre:</strong> {{ $annonce->titre }}</p>
                <p><strong>Prix:</strong> {{ number_format($annonce->prix, 2, ',', ' ') }} DH</p>
                <p><strong>Vendeur:</strong> {{ $annonce->utilisateur->nom }}</p>
            </div>
        </div>
        
        <form action="{{ route('reviews.store', $annonce->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="rating">Notation <span class="required">*</span></label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" {{ old('rating') == 5 ? 'checked' : '' }} />
                    <label for="star5" title="5 étoiles"></label>
                    <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }} />
                    <label for="star4" title="4 étoiles"></label>
                    <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }} />
                    <label for="star3" title="3 étoiles"></label>
                    <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }} />
                    <label for="star2" title="2 étoiles"></label>
                    <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }} />
                    <label for="star1" title="1 étoile"></label>
                </div>
                @error('rating')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="comment">Commentaire</label>
                <textarea id="comment" name="comment" class="form-control @error('comment') is-invalid @enderror" rows="5" placeholder="Partagez votre expérience avec cette annonce ou ce vendeur...">{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <a href="{{ route('details', $annonce->id) }}" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-submit">Envoyer l'avis</button>
            </div>
        </form>
    </div>
</div>

<style>
    .review-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 0 15px;
    }
    
    .review-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .review-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .review-header h1 {
        color: #3498db;
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .review-header p {
        color: #666;
    }
    
    .review-ad-info {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    
    .review-ad-info h2 {
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
        background: #3498db;
        color: white;
        border: none;
    }
    
    .btn-cancel:hover {
        background: #e7e7e7;
    }
    
    .btn-submit:hover {
        background: #2980b9;
    }
    
    /* Star Rating */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .star-rating input {
        display: none;
    }
    
    .star-rating label {
        cursor: pointer;
        width: 40px;
        height: 40px;
        margin-right: 5px;
        position: relative;
        font-size: 40px;
    }
    
    .star-rating label:before {
        content: '★';
        color: #ddd;
        position: absolute;
    }
    
    .star-rating input:checked ~ label:before,
    .star-rating label:hover:before,
    .star-rating label:hover ~ label:before {
        color: #f39c12;
    }
    
    @media (max-width: 768px) {
        .review-card {
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