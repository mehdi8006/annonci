<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annoncia - Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        :root {
            --bs-primary: #3b82f6;
            --bs-primary-rgb: 59, 130, 246;
        }
        .c{
            padding-top:80px; 
        }
        body {
            background-color: #f8f9fa;
        }
        
        .auth-container {
            min-height: 100vh;
        }
        
        .brand-section {
            background: linear-gradient(135deg, #f5f9ff 0%, #e0f2fe 100%);
        }
        
        .brand-logo {
            font-size: 4rem;
            color: var(--bs-primary);
        }
        
        .auth-card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .form-floating > label {
            font-weight: 500;
        }
        
        .password-toggle {
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--bs-primary);
        }
        
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .back-link {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--bs-primary);
        }
        
        @media (max-width: 991.98px) {
            .brand-section {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @include('components.nav')
    <div class="c">
    
    <div class="container-fluid auth-container">
        <div class="row h-100">
            <!-- Branding Section -->
            <div class="col-lg-6 brand-section d-flex align-items-center justify-content-center">
                <div class="text-center p-5">
                    <i class="fa-solid fa-bag-shopping brand-logo mb-4"></i>
                    <h2 class="display-6 fw-bold text-dark mb-3">Achetez et vendez facilement</h2>
                    <p class="lead text-muted mb-2">
                        Annoncia, votre <a href="#" class="text-primary text-decoration-none fw-semibold">plateforme de confiance</a> pour les
                    </p>
                    <p class="text-muted">transactions en ligne sécurisées.</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="w-100" style="max-width: 480px;">
                    <div class="card auth-card">
                        <div class="card-body p-5">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <i class="fa-solid fa-shield-halved text-success" style="font-size: 3rem;"></i>
                                </div>
                                <h1 class="h3 fw-bold text-dark mb-3">Créer un nouveau mot de passe</h1>
                                <p class="text-muted">
                                    Veuillez créer un nouveau mot de passe sécurisé pour votre compte.
                                </p>
                            </div>

                            <!-- Flash Messages -->
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <!-- Reset Password Form -->
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                                
                                <!-- New Password -->
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" 
                                           class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                                           id="newPassword" placeholder="Nouveau mot de passe" required>
                                    <label for="newPassword">
                                        <i class="fa-solid fa-lock me-2"></i>Nouveau mot de passe
                                    </label>
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                        <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('newPassword', this)"></i>
                                    </div>
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-floating mb-4">
                                    <input type="password" name="password_confirmation" 
                                           class="form-control" id="confirmNewPassword" 
                                           placeholder="Confirmez le mot de passe" required>
                                    <label for="confirmNewPassword">
                                        <i class="fa-solid fa-lock me-2"></i>Confirmez le mot de passe
                                    </label>
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                        <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('confirmNewPassword', this)"></i>
                                    </div>
                                </div>

                                <!-- Password Requirements -->
                                <div class="alert alert-info mb-4">
                                    <small>
                                        <i class="fa-solid fa-info-circle me-2"></i>
                                        <strong>Exigences du mot de passe :</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Au moins 8 caractères</li>
                                            <li>Contenir des lettres et des chiffres</li>
                                            <li>Inclure au moins un caractère spécial</li>
                                        </ul>
                                    </small>
                                </div>

                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check me-2"></i>
                                        Réinitialiser le mot de passe
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('form') }}" class="back-link">
                                        <i class="fa-solid fa-arrow-left me-2"></i>
                                        Retour à la page de connexion
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Note -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fa-solid fa-shield-check me-1 text-success"></i>
                            Votre mot de passe sera chiffré et stocké en toute sécurité.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggle
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength indicator (optional enhancement)
        document.getElementById('newPassword').addEventListener('input', function() {
            const password = this.value;
            const requirements = document.querySelectorAll('.alert-info li');
            
            // Check length
            if (password.length >= 8) {
                requirements[0].classList.add('text-success');
            } else {
                requirements[0].classList.remove('text-success');
            }
            
            // Check letters and numbers
            if (/(?=.*[a-zA-Z])(?=.*\d)/.test(password)) {
                requirements[1].classList.add('text-success');
            } else {
                requirements[1].classList.remove('text-success');
            }
            
            // Check special characters
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                requirements[2].classList.add('text-success');
            } else {
                requirements[2].classList.remove('text-success');
            }
        });
    </script>

    @include('components.footer')
</body>
</html>