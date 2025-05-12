<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annoncia - Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
    /* Container et Wrapper */
    .auth-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f8f9fa;
        padding: 20px;
    }
 
    .auth-container {
        display: flex;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
    }
 
    /* Section gauche (branding) */
    .auth-left {
        background-color: #f5f9ff;
        padding: 60px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
 
    .brand-logo {
        font-size: 72px;
        color: #3b82f6;
        margin-bottom: 40px;
    }
 
    .brand-title {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        margin-bottom: 16px;
    }
 
    .brand-subtitle {
        font-size: 18px;
        color: #666;
        margin-bottom: 8px;
    }
 
    .brand-caption {
        font-size: 16px;
        color: #888;
    }
 
    .brand-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }
 
    /* Section droite (formulaires) */
    .auth-right {
        flex: 1;
        padding: 60px;
        background-color: white;
    }
 
    .auth-header {
        text-align: center;
        margin-bottom: 40px;
    }
 
    .auth-title {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin-bottom: 12px;
    }
 
    .auth-subtitle {
        font-size: 16px;
        color: #666;
        margin-bottom: 30px;
    }
 
    /* Formulaires */
    .form-group {
        margin-bottom: 24px;
    }
 
    .form-label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }
 
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background-color: #f9fafb;
        transition: all 0.3s ease;
    }
 
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background-color: white;
    }
    
    .form-input.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
 
    /* Boutons */
    .submit-btn {
        width: 100%;
        padding: 14px 24px;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 24px;
    }
 
    .submit-btn:hover {
        background-color: #2563eb;
    }
    
    .back-link {
        display: block;
        text-align: center;
        margin-top: 24px;
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
    }
    
    .back-link:hover {
        color: #3b82f6;
    }
    
    /* Alert messages */
    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .alert-success {
        background-color: #d1fae5;
        border: 1px solid #10b981;
        color: #065f46;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border: 1px solid #ef4444;
        color: #b91c1c;
    }
    
    .error-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
    }
    
    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .auth-form {
        animation: fadeIn 0.3s ease-in-out;
    }
 
    /* Responsive design */
    @media (max-width: 750px) {
        .auth-left {
            display: none;
        }
    }
    
    @media (max-width: 640px) {
        .auth-wrapper {
            padding: 10px;
        }
 
        .auth-right {
            padding: 30px 20px;
        }
 
        .brand-title {
            font-size: 24px;
        }
 
        .auth-title {
            font-size: 28px;
        }
    }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <!-- Section gauche (Branding) -->
            <div class="auth-left">
                <i class="fa-solid fa-bag-shopping brand-logo"></i>
                <h2 class="brand-title">Achetez et vendez facilement</h2>
                <p class="brand-subtitle">Annoncia, votre <a href="#" class="brand-link">plateforme de confiance</a> pour les</p>
                <p class="brand-caption">transactions en ligne sécurisées.</p>
            </div>
     
            <!-- Section droite (Formulaire de réinitialisation) -->
            <div class="auth-right">
                <div class="auth-header">
                    <h1 class="auth-title">Réinitialisation du mot de passe</h1>
                    <p class="auth-subtitle">Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
                </div>
    
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
               
                <!-- Formulaire de réinitialisation -->
                <form id="resetPasswordForm" class="auth-form" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                               placeholder="Entrez votre email" value="{{ old('email') }}" required>
                        @if($errors->has('email'))
                            <div class="error-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
     
                    <button type="submit" class="submit-btn">Envoyer le lien de réinitialisation</button>
                    
                    <a href="{{ route('form') }}" class="back-link">Retour à la page de connexion</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>