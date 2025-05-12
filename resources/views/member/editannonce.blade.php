@extends('layouts.member')

@section('title', 'Modifier une annonce')

@section('content')
    <div class="page-header">
        <h1>Modifier l'annonce</h1>
        <p>Modifiez les informations de votre annonce</p>
    </div>
    
    <div class="form-container55">
        <form action="{{ route('member.annonces.update', $annonce->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group55">
                <label for="titre" class="form-label55">
                    Titre <span class="required55">*</span>
                </label>
                <input type="text" 
                       id="titre" 
                       name="titre" 
                       class="form-input55 @error('titre') input-error @enderror" 
                       value="{{ old('titre', $annonce->titre) }}"
                       required 
                       maxlength="255">
                @error('titre')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group55">
                <label for="description" class="form-label55">
                    Description <span class="required55">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          class="form-textarea55 @error('description') input-error @enderror" 
                          required>{{ old('description', $annonce->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row55">
                <div class="form-group55">
                    <label for="prix" class="form-label55">
                        Prix (DH) <span class="required55">*</span>
                    </label>
                    <input type="number" 
                           id="prix" 
                           name="prix" 
                           class="form-input55 @error('prix') input-error @enderror" 
                           value="{{ old('prix', $annonce->prix) }}"
                           step="0.01" 
                           min="0" 
                           required>
                    @error('prix')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group55">
                    <label for="id_ville" class="form-label55">
                        Ville <span class="required55">*</span>
                    </label>
                    <select id="id_ville" 
                            name="id_ville" 
                            class="form-select55 @error('id_ville') input-error @enderror" 
                            required>
                        <option value="">Sélectionnez une ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" 
                                    {{ old('id_ville', $annonce->id_ville) == $ville->id ? 'selected' : '' }}>
                                {{ $ville->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_ville')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row55">
                <div class="form-group55">
                    <label for="id_categorie" class="form-label55">
                        Catégorie <span class="required55">*</span>
                    </label>
                    <select id="id_categorie" 
                            name="id_categorie" 
                            class="form-select55 @error('id_categorie') input-error @enderror" 
                            required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" 
                                    {{ old('id_categorie', $annonce->id_categorie) == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_categorie')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group55">
                    <label for="id_sous_categorie" class="form-label55">
                        Sous-catégorie
                    </label>
                    <select id="id_sous_categorie" 
                            name="id_sous_categorie" 
                            class="form-select55 @error('id_sous_categorie') input-error @enderror">
                        <option value="">Sélectionnez une sous-catégorie</option>
                        @foreach($sousCategories as $sousCategorie)
                            <option value="{{ $sousCategorie->id }}" 
                                    data-category="{{ $sousCategorie->id_categorie }}"
                                    {{ old('id_sous_categorie', $annonce->id_sous_categorie) == $sousCategorie->id ? 'selected' : '' }}>
                                {{ $sousCategorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_sous_categorie')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="image-section55">
                <h3 class="form-label55" style="margin-bottom: 15px;">Photos existantes</h3>
                <div class="existing-images">
                    @foreach($annonce->images as $image)
                        <div class="existing-image-item">
                            <img src="{{ asset('storage/' . $image->url) }}" alt="Image">
                            <span class="image-label">Image {{ $loop->iteration }}</span>
                        </div>
                    @endforeach
                </div>
                <p style="color: #666; font-size: 14px; margin-top: 10px;">
                    Note: Pour modifier les images, veuillez supprimer l'annonce et en créer une nouvelle.
                </p>
            </div>

            <button type="submit" class="submit-button55">Mettre à jour l'annonce</button>
        </form>
    </div>
@endsection

@section('styles')
<style>
    .form-container55 {
        max-width: 800px;
        margin: 0 auto;
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group55 {
        margin-bottom: 20px;
    }

    .form-label55 {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        font-size: 16px;
    }

    .form-input55,
    .form-textarea55,
    .form-select55 {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .form-input55:focus,
    .form-textarea55:focus,
    .form-select55:focus {
        outline: none;
        border-color: #4CAF50;
    }

    .form-textarea55 {
        resize: vertical;
        min-height: 120px;
    }

    .form-row55 {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-row55 .form-group55 {
        flex: 1;
        min-width: 250px;
    }

    .image-section55 {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .existing-images {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .existing-image-item {
        text-align: center;
    }

    .existing-image-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .image-label {
        display: block;
        font-size: 14px;
        color: #666;
    }

    .required55 {
        color: #e74c3c;
    }

    .submit-button55 {
        background-color: #4CAF50;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
        margin-top: 20px;
    }

    .submit-button55:hover {
        background-color: #45a049;
    }

    .submit-button55:active {
        transform: translateY(1px);
    }

    .input-error {
        border-color: #e53e3e !important;
    }

    .error-message {
        color: #e53e3e;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    @media (max-width: 600px) {
        .form-container55 {
            padding: 20px;
        }

        .form-row55 {
            flex-direction: column;
        }

        .form-row55 .form-group55 {
            min-width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle sub-category filtering
        const categorySelect = document.getElementById('id_categorie');
        const subCategorySelect = document.getElementById('id_sous_categorie');
        const subCategoryOptions = subCategorySelect.querySelectorAll('option[data-category]');

        function filterSubCategories() {
            const selectedCategory = categorySelect.value;
            
            // Hide all sub-category options
            subCategoryOptions.forEach(option => {
                option.style.display = 'none';
            });

            // Show only sub-categories that belong to the selected category
            if (selectedCategory) {
                subCategoryOptions.forEach(option => {
                    if (option.getAttribute('data-category') === selectedCategory) {
                        option.style.display = 'block';
                    }
                });
            }
        }

        categorySelect.addEventListener('change', filterSubCategories);

        // Filter on page load
        filterSubCategories();
    });
</script>
@endsection