<!-- resources/views/admin/categories/edit.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Modifier la catégorie')

@section('content')
    <div class="admin-header">
        <h1>Modifier la catégorie</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.categories.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="admin-form-group">
                <label for="nom" class="admin-form-label">Nom <span class="required-field">*</span></label>
                <input type="text" id="nom" name="nom" class="admin-form-input @error('nom') is-invalid @enderror" value="{{ old('nom', $category->nom) }}" required>
                @error('nom')
                    <div class="admin-form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label for="description" class="admin-form-label">Description</label>
                <textarea id="description" name="description" class="admin-form-textarea @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="admin-form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.categories.index') }}" class="admin-button admin-button-secondary">
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
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
    
    .required-field {
        color: #ef4444;
    }
</style>
@endsection