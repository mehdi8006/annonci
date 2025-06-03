    <style>
        :root {
            --bs-primary: #3b82f6;
            --bs-primary-rgb: 59, 130, 246;
        }
        .a{
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
        
        .password-toggle {
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--bs-primary);
        }
        
        .auth-card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .nav-pills .nav-link {
            color: #6c757d;
            border-radius: 0;
            border-bottom: 2px solid transparent;
            background: none;
            padding: 1rem 1.5rem;
        }
        
        .nav-pills .nav-link.active {
            background: none;
            color: var(--bs-primary);
            border-bottom-color: var(--bs-primary);
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
        
        @media (max-width: 991.98px) {
            .brand-section {
                display: none !important;
            }
        }
    </style>
<div class="a">
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
                                <h1 class="h3 fw-bold text-dark">Connectez-vous à Annoncia</h1>
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

                            <!-- Navigation Tabs -->
                            <ul class="nav nav-pills nav-justified border-bottom mb-4" id="authTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ !session('register') ? 'active' : '' }}" id="login-tab" 
                                            data-bs-toggle="pill" data-bs-target="#login" type="button" role="tab">
                                        Connexion
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ session('register') ? 'active' : '' }}" id="register-tab" 
                                            data-bs-toggle="pill" data-bs-target="#register" type="button" role="tab">
                                        Inscription
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="authTabContent">
                                <!-- Login Form -->
                                <div class="tab-pane fade {{ !session('register') ? 'show active' : '' }}" id="login" role="tabpanel">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <!-- Email -->
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" 
                                                   class="form-control {{ $errors->has('email') && !session('register') ? 'is-invalid' : '' }}" 
                                                   id="loginEmail" placeholder="nom@exemple.com" 
                                                   value="{{ old('email') }}" required>
                                            <label for="loginEmail">Email</label>
                                            @if($errors->has('email') && !session('register'))
                                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>

                                        <!-- Password -->
                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" 
                                                   class="form-control {{ $errors->has('password') && !session('register') ? 'is-invalid' : '' }}" 
                                                   id="loginPassword" placeholder="Mot de passe" required>
                                            <label for="loginPassword">Mot de passe</label>
                                            <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('loginPassword', this)"></i>
                                            </div>
                                            @if($errors->has('password') && !session('register'))
                                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>

                                        <!-- Remember Me & Forgot Password -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                                <label class="form-check-label" for="remember">
                                                    Se souvenir de moi
                                                </label>
                                            </div>
                                            <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">
                                                Mot de passe oublié ?
                                            </a>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-sign-in-alt me-2"></i>
                                            Connexion
                                        </button>
                                    </form>
                                </div>

                                <!-- Register Form -->
                                <div class="tab-pane fade {{ session('register') ? 'show active' : '' }}" id="register" role="tabpanel">
                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <!-- Name -->
                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" 
                                                   class="form-control {{ $errors->has('name') && session('register') ? 'is-invalid' : '' }}" 
                                                   id="registerName" placeholder="Nom complet" 
                                                   value="{{ old('name') }}" required>
                                            <label for="registerName">Nom complet</label>
                                            @if($errors->has('name') && session('register'))
                                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>

                                        <!-- Email -->
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" 
                                                   class="form-control {{ $errors->has('email') && session('register') ? 'is-invalid' : '' }}" 
                                                   id="registerEmail" placeholder="nom@exemple.com" 
                                                   value="{{ old('email') }}" required>
                                            <label for="registerEmail">Email</label>
                                            @if($errors->has('email') && session('register'))
                                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>

                                        <!-- Phone -->
                                        <div class="form-floating mb-3">
                                            <input type="tel" name="phone" 
                                                   class="form-control {{ $errors->has('phone') && session('register') ? 'is-invalid' : '' }}" 
                                                   id="registerPhone" placeholder="Numéro de téléphone" 
                                                   value="{{ old('phone') }}" required>
                                            <label for="registerPhone">Numéro de téléphone</label>
                                            @if($errors->has('phone') && session('register'))
                                                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>

                                        <!-- Password -->
                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" 
                                                   class="form-control {{ $errors->has('password') && session('register') ? 'is-invalid' : '' }}" 
                                                   id="registerPassword" placeholder="Mot de passe" required>
                                            <label for="registerPassword">Mot de passe</label>
                                            <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('registerPassword', this)"></i>
                                            </div>
                                            @if($errors->has('password') && session('register'))
                                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="form-floating mb-4">
                                            <input type="password" name="password_confirmation" 
                                                   class="form-control" id="confirmPassword" 
                                                   placeholder="Confirmez le mot de passe" required>
                                            <label for="confirmPassword">Confirmez le mot de passe</label>
                                            <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('confirmPassword', this)"></i>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-user-plus me-2"></i>
                                            S'inscrire
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        // Initialize correct tab on page load
        document.addEventListener('DOMContentLoaded', function() {
            const registerSession = {{ session('register') ? 'true' : 'false' }};
            
            if (registerSession) {
                const registerTab = new bootstrap.Tab(document.getElementById('register-tab'));
                registerTab.show();
            }
        });
    </script>
</div>
