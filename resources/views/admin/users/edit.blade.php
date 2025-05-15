@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier l'utilisateur</h1>
        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Formulaire de modification</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telephon" class="form-label">Téléphone</label>
                        <input type="text" class="form-control @error('telephon') is-invalid @enderror" id="telephon" name="telephon" value="{{ old('telephon', $user->telephon) }}" required>
                        @error('telephon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville" value="{{ old('ville', $user->ville) }}" required>
                        @error('ville')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="type_utilisateur" class="form-label">Type d'utilisateur</label>
                        <select class="form-select @error('type_utilisateur') is-invalid @enderror" id="type_utilisateur" name="type_utilisateur" required>
                            <option value="normal" {{ old('type_utilisateur', $user->type_utilisateur) == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="admin" {{ old('type_utilisateur', $user->type_utilisateur) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('type_utilisateur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                            <option value="en_attente" {{ old('statut', $user->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="valide" {{ old('statut', $user->statut) == 'valide' ? 'selected' : '' }}>Validé</option>
                            <option value="supprime" {{ old('statut', $user->statut) == 'supprime' ? 'selected' : '' }}>Supprimé</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection