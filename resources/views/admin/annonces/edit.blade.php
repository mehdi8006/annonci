@extends('layouts.admin')

@section('title', 'Modifier l\'annonce')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier l'annonce</h1>
        <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Formulaire de modification</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.annonces.update', $annonce->id) }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $annonce->titre) }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="prix" class="form-label">Prix (DH)</label>
                        <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $annonce->prix) }}" required>
                        @error('prix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $annonce->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="id_categorie" class="form-label">Catégorie</label>
                        <select class="form-select @error('id_categorie') is-invalid @enderror" id="id_categorie" name="id_categorie" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ old('id_categorie', $annonce->id_categorie) == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="id_sous_categorie" class="form-label">Sous-catégorie</label>
                        <select class="form-select @error('id_sous_categorie') is-invalid @enderror" id="id_sous_categorie" name="id_sous_categorie">
                            <option value="">Sélectionner une sous-catégorie</option>
                            @foreach($sousCategories as $sousCategorie)
                                <option value="{{ $sousCategorie->id }}" {{ old('id_sous_categorie', $annonce->id_sous_categorie) == $sousCategorie->id ? 'selected' : '' }}>
                                    {{ $sousCategorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_sous_categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="id_ville" class="form-label">Ville</label>
                        <select class="form-select @error('id_ville') is-invalid @enderror" id="id_ville" name="id_ville" required>
                            <option value="">Sélectionner une ville</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}" {{ old('id_ville', $annonce->id_ville) == $ville->id ? 'selected' : '' }}>
                                    {{ $ville->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_ville')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                        <option value="en_attente" {{ old('statut', $annonce->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="validee" {{ old('statut', $annonce->statut) == 'validee' ? 'selected' : '' }}>Validée</option>
                        <option value="supprimee" {{ old('statut', $annonce->statut) == 'supprimee' ? 'selected' : '' }}>Supprimée</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Images Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold">Images de l'annonce</h6>
            <a href="{{ route('admin.images', $annonce->id) }}" class="btn btn-primary">
                <i class="fas fa-images me-1"></i> Gérer les images
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($images as $image)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card {{ $image->principale ? 'border-primary' : '' }}">
                            <img src="{{ asset($image->url) }}" class="card-img-top" alt="Image" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                @if($image->principale)
                                    <span class="badge bg-primary">Image principale</span>
                                @else
                                    <form action="{{ route('admin.images.set-main', $image->id) }}" method="POST" class="mb-2">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Définir comme principale</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.images.delete', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p>Aucune image disponible pour cette annonce.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Category change event to load subcategories
    $(document).ready(function() {
        $('#id_categorie').change(function() {
            var categorieId = $(this).val();
            if(categorieId) {
                $.ajax({
                    url: '/admin/get-sous-categories/' + categorieId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#id_sous_categorie').empty();
                        $('#id_sous_categorie').append('<option value="">Sélectionner une sous-catégorie</option>');
                        $.each(data, function(key, value) {
                            $('#id_sous_categorie').append('<option value="' + value.id + '">' + value.nom + '</option>');
                        });
                    }
                });
            } else {
                $('#id_sous_categorie').empty();
                $('#id_sous_categorie').append('<option value="">Sélectionner une sous-catégorie</option>');
            }
        });
    });
</script>
@endsection