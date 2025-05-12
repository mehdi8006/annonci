<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annoncia - Connexion/Inscription</title>
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
    }
 
    /* Navigation entre formulaires */
    .auth-tabs {
        display: flex;
        margin-bottom: 40px;
        border-bottom: 1px solid #e5e7eb;
    }
 
    .auth-tab {
        flex: 1;
        padding: 16px 24px;
        text-align: center;
        cursor: pointer;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        background: none;
        border: none;
    }
 
    .auth-tab.active {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
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
 
    .phone-input-wrapper {
        display: flex;
        gap: 8px;
    }
 
    .country-code {
        width: 120px;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background-color: #f9fafb;
        font-size: 14px;
        cursor: pointer;
    }
 
    .phone-input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background-color: #f9fafb;
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
 
    .forgot-password {
        text-align: right;
        margin-top: 8px;
    }
 
    .forgot-password-link {
        color: #3b82f6;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
 
    .forgot-password-link:hover {
        text-decoration: underline;
    }
 
    /* Animations */
    .auth-form {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
 
    .auth-form.active {
        display: block;
    }
 
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
    /* Styles pour le checkbox "Se souvenir de moi" */
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 16px;
        }

        .form-checkbox {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            accent-color: #3b82f6;
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 14px;
            color: #4b5563;
            cursor: pointer;
        }
        
        /* Alert messages styling */
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
     
            <!-- Section droite (Formulaires) -->
            <div class="auth-right">
                <div class="auth-header">
                    <h1 class="auth-title">Connectez-vous à Annoncia</h1>
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
     
                <!-- Navigation entre connexion et inscription -->
                <div class="auth-tabs">
                    <button class="auth-tab {{ !session('register') ? 'active' : '' }}" onclick="switchTab('login')">Connexion</button>
                    <button class="auth-tab {{ session('register') ? 'active' : '' }}" onclick="switchTab('register')">Inscription</button>
                </div>
     
                <!-- Formulaire de connexion -->
                <form id="loginForm" class="auth-form {{ !session('register') ? 'active' : '' }}" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input {{ $errors->has('email') && !session('register') ? 'is-invalid' : '' }}" 
                              placeholder="Entrez votre email" value="{{ old('email') }}" required>
                        @if($errors->has('email') && !session('register'))
                            <div class="error-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-input {{ $errors->has('password') && !session('register') ? 'is-invalid' : '' }}" 
                              placeholder="Entrez votre mot de passe" required>
                        @if($errors->has('password') && !session('register'))
                            <div class="error-feedback">{{ $errors->first('password') }}</div>
                        @endif
                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}" class="forgot-password-link">Mot de passe oublié ?</a>
                        </div>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" name="remember" id="remember" class="form-checkbox">
                        <label for="remember" class="checkbox-label">Se souvenir de moi</label>
                    </div>

                    <button type="submit" class="submit-btn">Connexion</button>
                </form>
                
                <!-- Formulaire d'inscription -->
                <form id="registerForm" class="auth-form {{ session('register') ? 'active' : '' }}" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="name" class="form-input {{ $errors->has('name') && session('register') ? 'is-invalid' : '' }}" 
                               placeholder="Entrez votre nom complet" value="{{ old('name') }}" required>
                        @if($errors->has('name') && session('register'))
                            <div class="error-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input {{ $errors->has('email') && session('register') ? 'is-invalid' : '' }}" 
                               placeholder="Entrez votre email" value="{{ old('email') }}" required>
                        @if($errors->has('email') && session('register'))
                            <div class="error-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">Numéro de téléphone</label>
                        <div class="phone-input-wrapper">
                            <input type="tel" name="phone" class="phone-input {{ $errors->has('phone') && session('register') ? 'is-invalid' : '' }}" 
                                  placeholder="Ex: 623332123" value="{{ old('phone') }}" required>
                        </div>
                        @if($errors->has('phone') && session('register'))
                            <div class="error-feedback">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-input {{ $errors->has('password') && session('register') ? 'is-invalid' : '' }}" 
                               placeholder="Créez un mot de passe" required>
                        @if($errors->has('password') && session('register'))
                            <div class="error-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">Confirmez le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-input" 
                               placeholder="Confirmez le mot de passe" required>
                    </div>
                
                    <button type="submit" class="submit-btn">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
     
    <script>
        // Fonction pour basculer entre connexion et inscription
        function switchTab(tab) {
            // Désactiver tous les onglets et formulaires
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
            
            // Activer l'onglet cliqué
            document.querySelectorAll('.auth-tab').forEach(t => {
                if (tab === 'login' && t.textContent.trim() === 'Connexion') {
                    t.classList.add('active');
                } else if (tab === 'register' && t.textContent.trim() === 'Inscription') {
                    t.classList.add('active');
                }
            });
            
            // Activer le formulaire correspondant
            if (tab === 'login') {
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.getElementById('registerForm').classList.add('active');
            }
        }
        
        // Initialiser le bon onglet au chargement
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL parameters for any error indications
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('register')) {
                switchTab('register');
            } else {
                switchTab('login');
            }
        });
    </script>
</body>
</html>