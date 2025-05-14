{{-- resources/views/components/home/detailscarte.blade.php --}}

<style>
    /* Enhanced CSS for btn-action454 section */
.btn-action454 {
    display: flex;
    gap: 15px;
    margin: 25px 0;
    padding: 0 20px 20px;
    justify-content: center;
}

.btn-action454 a {
    text-decoration: none;
}

.btn-action454 button {
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid;
    font-weight: 500;
    min-width: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-action454 button i {
    font-size: 14px;
}





.btn-action454 .r:last-child {
    background-color: white;
  
    border-color: #e74c3c;
}
.btn-action454 .m:last-child {
    background-color: white;
    color: blue;
    border-color:blue;
}

.btn-action454 .r:last-child:hover {
    background-color: #fde5e5;
    transform: translateY(-2px);
}.btn-action454 .m:last-child:hover {
    background-color: #b9aeff;
    transform: translateY(-2px);
}

/* Responsive styling for small screens */
@media (max-width: 576px) {
    .btn-action454 {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    
    .btn-action454 button {
        width: 100%;
    }
}
   /* Action Buttons Section */

    .container4 {
        max-width: 1200px;
        margin: 0 auto;
    }
    a{
        text-decoration: none;
    }
    .product-detail4 {
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .product-top4 {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    @media (min-width: 768px) {
        .product-top4 {
            flex-direction: row;
        }
    }
    
    /* Gallery Section */
    .product-gallery4 {
        flex: 1;
        padding: 20px;
    }
    
    .main-image4 {
        width: 100%;
        height: 400px;
        border-radius: 8px;
        object-fit: cover;
    }
    
    .thumbnail-container4 {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        overflow-x: auto;
    }
    
    .thumbnail4 {
        width: 80px;
        height: 80px;
        border-radius: 4px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }
    
    .thumbnail4:hover {
        border-color: #3498db;
    }
    
    .thumbnail4.active {
        border-color: #3498db;
    }
    
    /* Info Section */
    .product-info4 {
        flex: 1;
        padding: 20px;
    }
    
    .product-title4 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #2c3e50;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    .product-price4 {
        font-size: 28px;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 15px;
    }
    
    .product-location4 {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        color: #7f8c8d;
    }
    
    .product-location4 i {
        margin-right: 8px;
    }
    
    .product-address4 {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        color: #7f8c8d;
    }
    
    .product-address4 i {
        margin-right: 8px;
    }
    
    .product-date4 {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        color: #7f8c8d;
    }
    
    .product-date4 i {
        margin-right: 8px;
    }
    
    .product-description4 {
        margin-bottom: 20px;
        line-height: 1.7;
    }
    
    .product-description4 h3 {
        margin-bottom: 10px;
        color: #2c3e50;
    }
    
    /* Improved paragraph text wrapping */
    .product-description4 p {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        max-width: 100%;
        hyphens: auto;
    }
    
    /* Seller Section */
    .seller-info4 {
        padding: 20px;
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .seller-avatar4 {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .seller-details4 {
        flex: 1;
    }
    
    .seller-name4 {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .seller-rating4 {
        color: #f39c12;
        margin-bottom: 5px;
    }
    
    .seller-date4 {
        color: #7f8c8d;
        font-size: 14px;
    }
    
    .contact-button4 {
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .contact-button4:hover {
        background-color: #2980b9;
    }
    
    .contact-button4 i {
        margin-right: 5px;
    }
    
    /* Contact Options */
    .contact-options4 {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        min-width: 500px;
        text-align: center;
        max-width: 90%;
    }
    
    .contact-options4.active {
        display: block;
    }
    
    .contact-options4 h2 {
        color: #e74c3c;
        font-size: 24px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    
    .contact-number4 {
        border: 1px solid #3498db;
        color: #3498db;
        background-color: white;
        padding: 10px 20px;
        border-radius: 4px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .contact-number4:hover {
        background-color: #f8f9fa;
    }
    
    .contact-number4 i {
        margin-right: 8px;
    }
    
    .warning-message4 {
        color: #333;
        font-size: 14px;
        margin-top: 20px;
        padding: 0;
        line-height: 1.5;
    }
    
    .close-button4 {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
        padding: 0;
        transition: background-color 0.2s;
    }
    
    .close-button4:hover {
        background-color: #d63031;
    }
    
    .modal-overlay4 {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    
    .modal-overlay4.active {
        display: block;
    }
    
    .call-label4 {
        color: #333;
        font-size: 16px;
        margin-bottom: 10px;
    }
    
    .save-button4 {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        color: #3498db;
        border: 1px solid #3498db;
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        margin-left: 10px;
        transition: all 0.2s;
    }
    
    .save-button4:hover {
        background-color: #f0f7fc;
    }
    
    .actions4 {
        display: flex;
        margin-top: 20px;
        position: relative;
    }
    
    /* Seller's other ads */
    .other-ads4 {
        padding: 20px;
        border-top: 1px solid #eee;
    }
    
    .other-ads4 h3 {
        margin-bottom: 15px;
        color: #2c3e50;
    }
    
    .ads-grid4 {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    
    .product-card4 {
        width: 250px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background-color: white;
        transition: transform 0.3s ease;
        flex: 0 0 auto;
    }
    
    .product-card4:hover {
        transform: translateY(-5px);
    }
    
    .card-header4 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px;
        background-color: #f8f8f8;
    }
    
    .seller4 {
        display: flex;
        align-items: center;
    }
    
    .seller-icon4 {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #3498db;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 5px;
        font-weight: bold;
    }
    .seller4 span{
        color:black;
       font-weight: 500;
    }
    .add-to-cart-icon4 {
        background-color: orange;
        color: white;
        width: 50px;
        height: 30px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .add-to-cart-icon4:hover {
        background-color: blue;
    }
    
    .product-image4 {
        width: 100%;
        height: 200px;
        background-color: #f0f0f0;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
    
    .product-image4 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-details4 {
        padding: 8px;
    }
    
    .product-title4 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
    }
    
    .price-location4 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .location4 {
        display: flex;
        align-items: center;
        color: #777;
        font-size: 14px;
    }
    
    .location4 i {
        margin-right: 5px;
        color: #e74c3c;
    }
    
    .product-price4 {
        font-size: 18px;
        font-weight: bold;
        color: orange;
    }
    
    .publish-date4 {
        font-size: 12px;
        color: #777;
        text-align: right;
        padding: 5px;
        border-top: 1px solid #eee;
    }
   
    .product-price4 span {
        font-size: 13px;
        font-weight: bold;
        color: black;
    }
    
    .seller-avatar-letter4 {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
    }
    
    .favorite-button4 {
        background-color: white;
        color: #e74c3c;
        border: 1px solid #e74c3c;
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        margin-left: 10px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    
    .favorite-button4:hover {
        background-color: #fde5e5;
    }
    
    .favorite-button4.active {
        background-color: #e74c3c;
        color: white;
    }
    
    .favorite-button4 i {
        margin-right: 8px;
    }

    /* Fixed styling for container159 and image not found - UPDATED TO REMOVE SCROLLBARS */
    .container159 {
        max-width: 800px;
        margin: 0 auto;
        padding: 15px;
        overflow: hidden; /* Prevent scrollbars */
    }

    .container159 h1 {
        color: #333;
        text-align: center;
        font-size: 20px;
        margin-bottom: 15px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .image-container {
        position: relative;
        width: 100%;
        min-height: 200px; /* Changed from fixed height to min-height */
        margin: 20px auto;
        border-radius: 8px;
        overflow: hidden; /* Prevent scrollbars */
    }

    .image-not-found {
        width: 100%;
        height: 100%;
        min-height: 200px; /* Use min-height instead of fixed height */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 8px;
        color: #666;
        overflow: hidden; /* Prevent scrollbars */
    }

    .image-not-found svg {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
        fill: #999;
    }

    .image-not-found p {
        margin: 5px 0;
        font-weight: 500;
        font-size: 16px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        text-align: center;
        width: 100%;
        padding: 0 10px;
        box-sizing: border-box;
    }

    @media (max-width: 576px) {
        .container159 {
            padding: 10px;
        }
        
        .image-container {
            min-height: 180px;
        }
        
        .image-not-found svg {
            width: 50px;
            height: 50px;
        }
        
        .container159 h1 {
            font-size: 18px;
        }
    }
</style>
@props(['ads','isFavorite'])
<div class="container4">
    <div class="product-detail4">
        @foreach ($ads as $ad)
        <div class="product-top4">
            <div class="product-gallery4">
                <!-- In the product-gallery4 section, fixing the main image src attribute -->
                @foreach($ad->images as $image)
                    @if($image->principale == 1)
                        <img src="{{ asset('storage/' . $image->url) }}" alt="Main product image" class="main-image4">
                    @endif
                @endforeach
                <div class="thumbnail-container4">
                    @if($ad->images->count() == 0)
                    <div class="container159">
                    <h1>Image Not Found</h1>

                    <div class="image-container image-not-found">
                    <svg viewBox="0 0 24 24">
                    <path d="M21.9 21.9l-8.49-8.49-9.93-9.93-2.83-2.83L.65.65 2.07 2.07l3.13 3.13L5 5.5v2l-3 6.01V16h2.01L8 13l.01-.01 1.7 1.7-.71.71L7.83 17h10.35l2.63 2.63 1.41-1.41-1.41-1.41L21.9 21.9zM2.5 5.5l3.54 3.54L3 13.01l-1 2v-2l1.41-2.83L2.5 5.5zM7 2h10v2h-7.59l-2-2H7zm7 10.5c0-.78.67-1.45 1.45-1.45s1.45.67 1.45 1.45-.67 1.45-1.45 1.45-1.45-.67-1.45-1.45zm6 3.5h-1.59l-3-3 .59-.59 4 4V16zm-1.03-7.59l-9.47-2.35L17 2.53v5.88z"/>
                    </svg>
                    <p>Image Not Available</p>
                    </div>
                    </div>
                    @endif
                    @if($ad->images->count() > 0)
                        <img src="{{ asset('storage/' . $ad->images[0]->url) }}" alt="Thumbnail 1" class="thumbnail4 active" onclick="changeMainImage(this)">
                    @endif
                    @if($ad->images->count() > 1)
                        <img src="{{ asset('storage/' . $ad->images[1]->url) }}" alt="Thumbnail 2" class="thumbnail4" onclick="changeMainImage(this)">
                    @endif
                    @if($ad->images->count() > 2)
                        <img src="{{ asset('storage/' . $ad->images[2]->url) }}" alt="Thumbnail 3" class="thumbnail4" onclick="changeMainImage(this)">
                    @endif
                    @if($ad->images->count() > 3)
                        <img src="{{ asset('storage/' . $ad->images[3]->url) }}" alt="Thumbnail 3" class="thumbnail4" onclick="changeMainImage(this)">
                    @endif
                </div>
            </div>
            
            <div class="product-info4">
                <h1 class="product-title4">{{ $ad->titre }}</h1>
                <div class="product-price4"> {{ $ad->prix }}DH</div>
                <div class="product-location4">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $ad->ville->region }}
                </div>
                <div class="product-address4">
                    <i class="fas fa-home"></i>
                    {{ $ad->ville->nom }}
                </div>
                <div class="product-date4">
                    <i class="fas fa-calendar"></i>
                    Publié le 5 Mai 2025
                </div>
                
                <div class="product-description4">
                    <h3>Description</h3>
                    <p>
                        {{ $ad->description }}
                    </p>
                </div>
                <div class="actions4">
                    <a href="#contact">
                        <button class="contact-button4" type="button" onclick="showContactModal()">
                            <i class="fas fa-phone"></i>
                            Contacter le vendeur
                        </button>
                    </a>
                    <div class="modal-overlay4"></div>
                    <div class="contact-options4">
                        <button class="close-button4" type="button" onclick="closeContactModal()">×</button>
                        <h2>Attention !</h2>
                        <div class="warning-message4">
                            Il ne faut jamais envoyer de l'argent à l'avance au vendeur.
                        </div>
                        <div class="call-label4">Contacter le vendeur pour négocier </div>
                        <div class="contact-number4">
                            <i class="fas fa-phone"></i> {{ $ad->utilisateur->telephon }}
                        </div>
                    </div>
                    
                    @if(session()->has('user_id'))
                        @if($isFavorite)
                            <form action="{{ route('favorites.remove', $ad->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="favorite-button4 active">
                                    <i class="fas fa-heart"></i>
                                    Retirer des favoris
                                </button>
                            </form>
                        @else
                            <form action="{{ route('favorites.add', $ad->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="favorite-button4">
                                    <i class="far fa-heart"></i>
                                    Ajouter aux favoris
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('form') }}">
                            <button class="favorite-button4">
                                <i class="far fa-heart"></i>
                                Connectez-vous pour ajouter aux favoris
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="seller-info4">
            <div class="seller-avatar-letter4">{{ substr($ad->utilisateur->nom, 0, 1) }}</div>
            <div class="seller-details4">
                <div class="seller-name4">{{$ad->utilisateur->nom}}</div>
                <div class="seller-date4">Membre depuis January 2022</div>
            </div>
        </div>
        @endforeach
       
    </div>
   <!-- Updated btn-action454 section with better text and Font Awesome icons -->
<div class="btn-action454">
    <a href="{{ url()->previous() }}">
        <button class="r">
            <i class="fas fa-arrow-left"></i>
            Retour
        </button>
    </a>
    <a href="{{ route('member.annonces.edit',$ad->id) }}">
         <button class="m">
            <i class="fas fa-edit"></i>
            Modifier l'annonce
         </button>
    </a>
</div>

</div>

<script>
    // Keep minimal JavaScript only for UI interactions, not for favorites
    function showContactModal() {
        document.querySelector('.contact-options4').classList.add('active');
        document.querySelector('.modal-overlay4').classList.add('active');
    }
    
    function closeContactModal() {
        document.querySelector('.contact-options4').classList.remove('active');
        document.querySelector('.modal-overlay4').classList.remove('active');
    }
    
    // For the image gallery functionality
    function changeMainImage(thumbnail) {
        // Update main image
        document.querySelector('.main-image4').src = thumbnail.src;
        
        // Update active thumbnail
        var thumbnails = document.querySelectorAll('.thumbnail4');
        thumbnails.forEach(function(t) {
            t.classList.remove('active');
        });
        thumbnail.classList.add('active');
    }
    
    // Add event listener to close modal when overlay is clicked
    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.querySelector('.modal-overlay4');
        if (overlay) {
            overlay.addEventListener('click', closeContactModal);
        }
    });
</script>