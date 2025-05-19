<!-- resources/views/admin/users/edit.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
    <div class="admin-header">
        <h1>Modifier un utilisateur</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.users.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="nom" class="admin-form-label">Nom</label>
                        <input type="text" id="nom" name="nom" class="admin-form-input @error('nom') is-invalid @enderror" value="{{ old('nom', $user->nom) }}" required>
                        @error('nom')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="email" class="admin-form-label">Email</label>
                        <input type="email" id="email" name="email" class="admin-form-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="telephon" class="admin-form-label">Téléphone</label>
                        <input type="text" id="telephon" name="telephon" class="admin-form-input @error('telephon') is-invalid @enderror" value="{{ old('telephon', $user->telephon) }}" required>
                        @error('telephon')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="ville" class="admin-form-label">Ville</label>
                        <input type="text" id="ville" name="ville" class="admin-form-input @error('ville') is-invalid @enderror" value="{{ old('ville', $user->ville) }}" required>
                        @error('ville')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="statut" class="admin-form-label">Statut</label>
                        <select id="statut" name="statut" class="admin-form-select @error('statut') is-invalid @enderror" required>
                            <option value="en_attente" {{ old('statut', $user->statut) === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="valide" {{ old('statut', $user->statut) === 'valide' ? 'selected' : '' }}>Actif</option>
                            <option value="supprime" {{ old('statut', $user->statut) === 'supprime' ? 'selected' : '' }}>Supprimé</option>
                        </select>
                        @error('statut')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="type_utilisateur" class="admin-form-label">Type d'utilisateur</label>
                        <select id="type_utilisateur" name="type_utilisateur" class="admin-form-select @error('type_utilisateur') is-invalid @enderror" required>
                            <option value="normal" {{ old('type_utilisateur', $user->type_utilisateur) === 'normal' ? 'selected' : '' }}>Utilisateur normal</option>
                            <option value="admin" {{ old('type_utilisateur', $user->type_utilisateur) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                        @error('type_utilisateur')
                            <div class="admin-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="admin-form-group">
                <label for="password" class="admin-form-label">Mot de passe (laisser vide pour ne pas modifier)</label>
                <input type="password" id="password" name="password" class="admin-form-input @error('password') is-invalid @enderror">
                @error('password')
                    <div class="admin-form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.users.index') }}" class="admin-button admin-button-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" class="admin-button">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection

@section('css')
<style>
    .d-flex {
        display: flex;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
</style>
@endsection