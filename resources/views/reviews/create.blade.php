{{-- resources/views/reviews/create.blade.php --}}
@extends('layouts.masterhome')

@section('main')
<div style="margin-top: 80px;">


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="h3 mb-2">
                        <i class="fas fa-star me-2"></i>
                        Laisser un avis
                    </h1>
                    <p class="mb-0 opacity-75">Partagez votre expérience avec cette annonce</p>
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
                    
                    <!-- Review Form -->
                    <form action="{{ route('reviews.store', $annonce->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="rating" class="form-label fw-semibold">
                                Notation <span class="text-danger">*</span>
                            </label>
                            <div class="star-rating d-flex justify-content-center justify-content-md-start">
                                <input type="radio" id="star5" name="rating" value="5" {{ old('rating') == 5 ? 'checked' : '' }} />
                                <label for="star5" title="5 étoiles" class="star-label"></label>
                                <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }} />
                                <label for="star4" title="4 étoiles" class="star-label"></label>
                                <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }} />
                                <label for="star3" title="3 étoiles" class="star-label"></label>
                                <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }} />
                                <label for="star2" title="2 étoiles" class="star-label"></label>
                                <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }} />
                                <label for="star1" title="1 étoile" class="star-label"></label>
                            </div>
                            @error('rating')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Cliquez sur les étoiles pour noter votre expérience</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-semibold">Commentaire</label>
                            <textarea id="comment" 
                                    name="comment" 
                                    class="form-control @error('comment') is-invalid @enderror" 
                                    rows="5" 
                                    placeholder="Partagez votre expérience avec cette annonce ou ce vendeur...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Votre avis aidera d'autres utilisateurs à prendre de meilleures décisions.</div>
                        </div>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-between">
                            <a href="{{ route('details', $annonce->id) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Envoyer l'avis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
/* Custom Star Rating Styles */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating .star-label {
    cursor: pointer;
    font-size: 2rem;
    color: #dee2e6;
    transition: color 0.2s ease-in-out;
    user-select: none;
}

.star-rating .star-label:before {
    content: '★';
}

.star-rating input:checked ~ .star-label,
.star-rating .star-label:hover,
.star-rating .star-label:hover ~ .star-label {
    color: #ffc107;
}

.star-rating .star-label:hover {
    transform: scale(1.1);
}

/* Additional responsive adjustments */
@media (max-width: 768px) {
    .star-rating {
        justify-content: center;
    }
    
    .star-rating .star-label {
        font-size: 1.8rem;
    }
}
</style>
@endsection