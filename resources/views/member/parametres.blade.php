@extends('layouts.member')

@section('title', 'Paramètres')

@section('content')
    <div class="page-header">
        <h1>Paramètres du Compte</h1>
        <p>Gérez vos informations personnelles et vos préférences</p>
    </div>
    
    <div class="form-container">
        <div class="form-section">
            <h2>Informations personnelles</h2>
            
            @if (session('success'))
                <div class="message success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('member.parametres.update-profile') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" 
                           id="nom" 
                           name="nom" 
                           value="{{ old('nom', $user->nom) }}" 
                           class="@error('nom') input-error @enderror"
                           required 
                           maxlength="100">
                    @error('nom')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ $user->email }}" 
                           readonly>
                    <small>L'email ne peut pas être modifié.</small>
                </div>
                
                <div class="form-group">
                    <label for="telephon">Téléphone</label>
                    <input type="tel" 
                           id="telephon" 
                           name="telephon" 
                           value="{{ old('telephon', $user->telephon) }}" 
                           class="@error('telephon') input-error @enderror"
                           required 
                           maxlength="20">
                    @error('telephon')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" 
                           id="ville" 
                           name="ville" 
                           value="{{ old('ville', $user->ville) }}" 
                           class="@error('ville') input-error @enderror"
                           required 
                           maxlength="100">
                    @error('ville')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i>
                    Mettre à jour mes informations
                </button>
            </form>
        </div>
        
        <div class="form-section">
            <h2>Changer le mot de passe</h2>
            
            <form action="{{ route('member.parametres.update-password') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="@error('current_password') input-error @enderror"
                           required>
                    @error('current_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           class="@error('new_password') input-error @enderror"
                           required 
                           minlength="8">
                    @error('new_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input type="password" 
                           id="new_password_confirmation" 
                           name="new_password_confirmation" 
                           class="@error('new_password_confirmation') input-error @enderror"
                           required 
                           minlength="8">
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-key"></i>
                    Changer mon mot de passe
                </button>
            </form>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .page-header {
        margin-bottom: 30px;
    }
    
    .form-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .form-section {
        flex: 1;
        min-width: 300px;
    }
    
    h2 {
        color: #333;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #4a5568;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: #4299e1;
    }
    
    input[readonly] {
        background-color: #f7fafc;
        cursor: not-allowed;
    }
    
    small {
        display: block;
        margin-top: 5px;
        color: #718096;
        font-size: 14px;
    }
    
    .btn-submit {
        background-color: #4299e1;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    
    .btn-submit:hover {
        background-color: #3182ce;
    }
    
    .message {
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .success {
        background-color: #f0fdf4;
        color: #065f46;
        border: 1px solid #10b981;
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
    
    @media (max-width: 768px) {
        .form-container {
            flex-direction: column;
            padding: 20px;
        }
        
        .form-section {
            width: 100%;
        }
    }
</style>
@endsection