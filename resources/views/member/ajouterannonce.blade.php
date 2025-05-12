@extends('layouts.member')

@section('title', 'Publier une annonce')

@section('content')
    <div class="page-header">
        <h1>Publier une annonce</h1>
        <p>Remplissez le formulaire pour créer votre annonce</p>
    </div>
    
    <div class="form-container55">
        <form action="{{ route('member.annonces.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group55">
                <label for="titre" class="form-label55">
                    Titre <span class="required55">*</span>
                </label>
                <input type="text" 
                       id="titre" 
                       name="titre" 
                       class="form-input55 @error('titre') input-error @enderror" 
                       value="{{ old('titre') }}"
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
                          required>{{ old('description') }}</textarea>
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
                           value="{{ old('prix') }}"
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
                            <option value="{{ $ville->id }}" {{ old('id_ville') == $ville->id ? 'selected' : '' }}>
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
                            <option value="{{ $categorie->id }}" {{ old('id_categorie') == $categorie->id ? 'selected' : '' }}>
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
                                    {{ old('id_sous_categorie') == $sousCategorie->id ? 'selected' : '' }}
                                    style="display: none;">
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
                <h3 class="form-label55" style="margin-bottom: 15px;">Photos de l'annonce</h3>
                <div class="image-grid55">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="image-upload55" id="imageUpload{{ $i }}">
                            <label for="image{{ $i }}" class="image-upload-label55">
                                <img class="image-preview55" id="preview{{ $i }}" style="display: none;">
                                <span class="upload-text55">Cliquez pour ajouter<br>Photo {{ $i }}</span>
                            </label>
                            <input type="file" 
                                   id="image{{ $i }}" 
                                   name="images[]" 
                                   class="file-input55 @error('images.*') input-error @enderror" 
                                   accept="image/*">
                            <button type="button" class="remove-image55" aria-label="Supprimer l'image">×</button>
                        </div>
                    @endfor
                </div>
                @error('images.*')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submit-button55">Publier l'annonce</button>
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

    .image-grid55 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .image-upload55 {
        position: relative;
    }

    .image-upload-label55 {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        border: 2px dashed #ccc;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
        min-height: 150px;
        overflow: hidden;
        position: relative;
    }

    .image-upload-label55:hover {
        border-color: #4CAF50;
        background-color: #f8fdf8;
    }

    .upload-text55 {
        color: #666;
        font-size: 14px;
        text-align: center;
        z-index: 1;
    }

    .file-input55 {
        display: none;
    }

    .image-preview55 {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 6px;
        z-index: 0;
    }

    .image-upload55.has-image .upload-text55 {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 2;
    }

    .remove-image55 {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background-color: rgba(231, 76, 60, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        z-index: 3;
        transition: background-color 0.3s ease;
    }

    .remove-image55:hover {
        background-color: rgba(231, 76, 60, 1);
    }

    .image-upload55.has-image .remove-image55 {
        display: flex;
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

        .image-grid55 {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle image uploads
        const imageUploads = document.querySelectorAll('.image-upload55');
        
        imageUploads.forEach(function(upload) {
            const fileInput = upload.querySelector('.file-input55');
            const preview = upload.querySelector('.image-preview55');
            const uploadText = upload.querySelector('.upload-text55');
            const removeButton = upload.querySelector('.remove-image55');
            
            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        upload.classList.add('has-image');
                        uploadText.textContent = file.name;
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
            
            // Handle image removal
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                fileInput.value = '';
                preview.src = '';
                preview.style.display = 'none';
                upload.classList.remove('has-image');
                uploadText.innerHTML = 'Cliquez pour ajouter<br>Photo ' + upload.id.replace('imageUpload', '');
            });
        });

        // Handle sub-category filtering
        const categorySelect = document.getElementById('id_categorie');
        const subCategorySelect = document.getElementById('id_sous_categorie');
        const subCategoryOptions = subCategorySelect.querySelectorAll('option[data-category]');

        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;
            
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

            // Reset sub-category selection
            subCategorySelect.value = '';
        });

        // Trigger change event on page load to filter sub-categories
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection