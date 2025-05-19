{{-- resources/views/reviews/show.blade.php --}}
@extends('layouts.masterhome')

@section('main')
<div class="reviews-container">
    <div class="reviews-header">
        <div class="reviews-title">
            <h1>Avis pour l'annonce: {{ $annonce->titre }}</h1>
            <div class="reviews-summary">
                <div class="rating-average">
                    <span class="rating-value">{{ number_format($annonce->average_rating, 1) }}</span>
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($annonce->average_rating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $annonce->average_rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="reviews-count">{{ $annonce->reviews_count }} avis</span>
                </div>
                
                <div class="rating-breakdown">
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $annonce->reviews->where('rating', $i)->count();
                            $percentage = $annonce->reviews_count > 0 ? ($count / $annonce->reviews_count) * 100 : 0;
                        @endphp
                        <div class="rating-bar">
                            <span class="star-label">{{ $i }} <i class="fas fa-star"></i></span>
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="count">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        
        <div class="reviews-actions">
            @if(session()->has('user_id') && $annonce->id_utilisateur != session('user_id'))
                <a href="{{ route('reviews.create', $annonce->id) }}" class="write-review-btn">
                    <i class="fas fa-edit"></i> Écrire un avis
                </a>
            @endif
            <a href="{{ route('details', $annonce->id) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Retour à l'annonce
            </a>
        </div>
    </div>
    
    <div class="reviews-list">
        @if($annonce->reviews->count() > 0)
            @foreach($annonce->reviews as $review)
                <div class="review-item">
                    <div class="review-user">
                        <div class="user-avatar">
                            {{ substr($review->utilisateur->nom, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ $review->utilisateur->nom }}</div>
                            <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="review-content">
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        
                        @if($review->comment)
                            <div class="review-comment">
                                {{ $review->comment }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-reviews">
                <i class="far fa-comment-dots"></i>
                <p>Aucun avis pour le moment.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .reviews-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 15px;
    }
    
    .reviews-header {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 20px;
    }
    
    .reviews-title h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }
    
    .reviews-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .rating-average {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-right: 30px;
        border-right: 1px solid #eee;
    }
    
    .rating-value {
        font-size: 48px;
        font-weight: bold;
        color: #333;
    }
    
    .stars {
        font-size: 24px;
        color: #f39c12;
        margin: 10px 0;
    }
    
    .reviews-count {
        color: #666;
    }
    
    .rating-breakdown {
        flex: 1;
    }
    
    .rating-bar {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .star-label {
        width: 60px;
        font-size: 14px;
        color: #666;
    }
    
    .progress-bar {
        flex: 1;
        height: 8px;
        background-color: #eee;
        border-radius: 4px;
        margin: 0 10px;
        overflow: hidden;
    }
    
    .progress {
        height: 100%;
        background-color: #f39c12;
    }
    
    .count {
        width: 30px;
        text-align: right;
        font-size: 14px;
        color: #666;
    }
    
    .reviews-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
        justify-content: flex-end;
    }
    
    .write-review-btn, .back-btn {
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .write-review-btn {
        background-color: #3498db;
        color: white;
    }
    
    .back-btn {
        background-color: #f1f1f1;
        color: #555;
    }
    
    .write-review-btn:hover {
        background-color: #2980b9;
    }
    
    .back-btn:hover {
        background-color: #e7e7e7;
    }
    
    .reviews-list {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    
    .review-item {
        display: flex;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .review-item:last-child {
        border-bottom: none;
    }
    
    .review-user {
        margin-right: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .user-avatar {
        width: 60px;
        height: 60px;
        background-color: #3498db;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: bold;
    }
    
    .user-info {
        margin-top: 10px;
        text-align: center;
    }
    
    .user-name {
        font-weight: 600;
        font-size: 14px;
    }
    
    .review-date {
        font-size: 12px;
        color: #666;
        margin-top: 3px;
    }
    
    .review-content {
        flex: 1;
    }
    
    .review-rating {
        font-size: 18px;
        color: #f39c12;
        margin-bottom: 10px;
    }
    
    .review-comment {
        color: #333;
        line-height: 1.6;
    }
    
    .no-reviews {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 0;
        color: #666;
    }
    
    .no-reviews i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #ccc;
    }
    
    @media (max-width: 768px) {
        .reviews-header {
            padding: 20px;
        }
        
        .reviews-summary {
            flex-direction: column;
            gap: 20px;
        }
        
        .rating-average {
            border-right: none;
            border-bottom: 1px solid #eee;
            padding-right: 0;
            padding-bottom: 20px;
        }
        
        .reviews-actions {
            flex-direction: column;
        }
        
        .write-review-btn, .back-btn {
            width: 100%;
            justify-content: center;
        }
        
        .review-item {
            flex-direction: column;
        }
        
        .review-user {
            flex-direction: row;
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .user-info {
            margin-top: 0;
            margin-left: 15px;
            text-align: left;
        }
    }
</style>
@endsection