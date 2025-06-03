    <style>
        :root {
            --bs-primary: #3b82f6;
            --bs-primary-rgb: 59, 130, 246;
        }
        
        .b{
            padding-top:80px;
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
<div class="b">
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
                                    <i class="fa-solid fa-key text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h1 class="h3 fw-bold text-dark mb-3">Réinitialisation du mot de passe</h1>
                                <p class="text-muted">
                                    Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
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
                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-floating mb-4">
                                    <input type="email" name="email" 
                                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                           id="email" placeholder="nom@exemple.com" 
                                           value="{{ old('email') }}" required>
                                    <label for="email">
                                        <i class="fa-solid fa-envelope me-2"></i>Email
                                    </label>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-paper-plane me-2"></i>
                                        Envoyer le lien de réinitialisation
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

                    <!-- Additional Help -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fa-solid fa-info-circle me-1"></i>
                            Vérifiez également votre dossier de courrier indésirable si vous ne recevez pas l'e-mail.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
