@extends('admin.layouts.app')

@section('title', 'Détails des signalements')

@section('content')
<div class="container-fluid px-4">
    <!-- Header with back button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Signalements - Annonce #{{ $annonce->id }}</h1>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary hover-lift">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- Annonce Info Card -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100 fade-in">
                <!-- Annonce Header -->
                <div class="card-header bg-primary text-white py-3 position-relative">
                    <h5 class="mb-0">Informations sur l'annonce</h5>
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge 
                            @if($annonce->statut === 'validee') bg-success
                            @elseif($annonce->statut === 'en_attente') bg-warning text-dark
                            @else bg-danger @endif px-3 py-2">
                            @if($annonce->statut === 'validee')
                                <i class="fas fa-check-circle me-1"></i> Validée
                            @elseif($annonce->statut === 'en_attente')
                                <i class="fas fa-clock me-1"></i> En attente
                            @else
                                <i class="fas fa-ban me-1"></i> Supprimée
                            @endif
                        </span>
                    </div>
                </div>
                
                <!-- Annonce Image -->
                <div class="position-relative">
                    @if($annonce->images->where('principale', true)->first())
                        <img src="{{ asset($annonce->images->where('principale', true)->first()->url) }}" 
                            class="w-100 hover-zoom-slow" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-secondary"></i>
                        </div>
                    @endif
                    
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge bg-dark px-3 py-2">
                            <i class="fas fa-camera me-1"></i> {{ $annonce->images->count() }} images
                        </span>
                    </div>
                </div>
                
                <!-- Annonce Details -->
                <div class="card-body pt-4">
                    <h4 class="mb-3">{{ $annonce->titre }}</h4>
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="badge bg-primary px-3 py-2 fs-6">
                            {{ number_format($annonce->prix, 0, ',', ' ') }} DH
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger pulse-badge">
                                <i class="fas fa-flag me-1"></i> {{ $totalReports }} signalements
                            </span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Annonce Information -->
                    <div class="mb-4">
                        <h6 class="mb-3 text-uppercase fw-bold text-muted fs-sm">Détails</h6>
                        
                        <div class="row g-3 mb-2">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Catégorie</div>
                                        <div>{{ $annonce->categorie->nom }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Ville</div>
                                        <div>{{ $annonce->ville->nom }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Date</div>
                                        <div>{{ $annonce->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light text-primary me-2">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Vendeur</div>
                                        <div>{{ $annonce->utilisateur->nom }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    @if($pendingReports > 0)
                        <hr>
                        <div class="d-grid gap-2">
                            <form action="{{ route('admin.reports.processAll', $annonce->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="keep">
                                <button type="submit" class="btn btn-success w-100 hover-lift" 
                                        onclick="return confirm('Traiter tous les signalements et garder l\'annonce ?')">
                                    <i class="fas fa-check-circle me-2"></i>Traiter et Garder l'annonce
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.reports.processAll', $annonce->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger w-100 hover-lift" 
                                        onclick="return confirm('Traiter tous les signalements et supprimer l\'annonce ?')">
                                    <i class="fas fa-trash me-2"></i>Traiter et Supprimer l'annonce
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Tous les signalements ont été traités
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Reports Details -->
        <div class="col-xl-8 col-lg-7">
            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4 fade-in">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-file-alt me-2"></i>Description
                    </h5>
                </div>
                
                <div class="card-body">
                    <p class="mb-0">{{ $annonce->description }}</p>
                </div>
            </div>
            
            <!-- Reports Summary -->
            <div class="card border-0 shadow-sm mb-4 fade-in">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-danger">
                        <i class="fas fa-flag me-2"></i>Résumé des signalements
                        <span class="badge bg-danger ms-2">{{ $totalReports }}</span>
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        @foreach($reportTypes as $typeKey => $typeInfo)
                            @if($reports->has($typeKey))
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center p-3 bg-light rounded hover-card-light">
                                        <div class="icon-circle bg-{{ $typeInfo['color'] }} text-white me-3">
                                            <i class="{{ $typeInfo['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $reports[$typeKey]->count() }}</h6>
                                            <small class="text-muted">{{ $typeInfo['name'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Reports by Type -->
            @foreach($reportTypes as $typeKey => $typeInfo)
                @if($reports->has($typeKey))
                    <div class="card border-0 shadow-sm mb-4 fade-in">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-{{ $typeInfo['color'] }}">
                                <i class="{{ $typeInfo['icon'] }} me-2"></i>{{ $typeInfo['name'] }}
                            </h5>
                            <span class="badge bg-{{ $typeInfo['color'] }}">{{ $reports[$typeKey]->count() }}</span>
                        </div>
                        
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3">Signaleur</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reports[$typeKey] as $report)
                                            <tr class="hover-row">
                                                <td class="ps-3">
                                                    @if($report->utilisateur)
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle-sm bg-primary text-white me-2">
                                                                {{ strtoupper(substr($report->utilisateur->nom, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <div>{{ $report->utilisateur->nom }}</div>
                                                                <small class="text-muted">{{ $report->utilisateur->email }}</small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Utilisateur anonyme</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="report-description">
                                                        {{ Str::limit($report->description, 80) }}
                                                        @if(strlen($report->description) > 80)
                                                            <button class="btn btn-sm btn-link p-0 show-more-btn" 
                                                                    onclick="toggleDescription(this)">
                                                                voir plus
                                                            </button>
                                                            <div class="full-description d-none">
                                                                {{ $report->description }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>{{ $report->created_at->format('d/m/Y') }}</div>
                                                    <small class="text-muted">{{ $report->created_at->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @if($report->statut === 'traitee') bg-success
                                                        @elseif($report->statut === 'en_attente') bg-warning text-dark
                                                        @else bg-secondary @endif">
                                                        {{ str_replace('_', ' ', ucfirst($report->statut)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            
            @if($reports->isEmpty())
                <div class="card border-0 shadow-sm mb-4 fade-in">
                    <div class="card-body">
                        <div class="empty-state p-5 text-center">
                            <div class="empty-icon mb-3">
                                <i class="fas fa-flag fa-3x text-muted"></i>
                            </div>
                            <h5>Aucun signalement</h5>
                            <p class="text-muted">Cette annonce n'a pas encore été signalée.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    /* Hover and Animation Effects */
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .hover-card-light {
        transition: all 0.3s ease;
    }
    
    .hover-card-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    
    .hover-row:hover {
        background-color: rgba(0,0,0,0.02);
        transition: background-color 0.2s ease;
    }
    
    .hover-zoom-slow {
        transition: transform 0.5s ease;
    }
    
    .hover-zoom-slow:hover {
        transform: scale(1.05);
    }
    
    /* Pulse Animation */
    .pulse-badge {
        animation: pulseBadge 2s infinite;
    }
    
    @keyframes pulseBadge {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }
    
    /* Fade In Animation */
    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Avatar Styles */
    .avatar-circle-sm {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    .icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    /* Card Styles */
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Table Styles */
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.75rem 0.5rem;
    }
    
    /* Empty State */
    .empty-state {
        padding: 3rem;
    }
    
    .empty-icon {
        opacity: 0.3;
    }
    
    /* Small Font Size */
    .fs-sm {
        font-size: 0.875rem;
    }
    
    /* Report Description */
    .report-description {
        max-width: 300px;
    }
    
    .show-more-btn {
        text-decoration: none !important;
        font-size: 0.8rem;
        color: #0d6efd;
    }
    
    .show-more-btn:hover {
        text-decoration: underline !important;
    }
    
    /* Button Loading State */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('js')
<script>
    // Toggle description visibility
    function toggleDescription(button) {
        const reportDesc = button.closest('.report-description');
        const fullDesc = reportDesc.querySelector('.full-description');
        
        if (fullDesc.classList.contains('d-none')) {
            fullDesc.classList.remove('d-none');
            button.textContent = 'voir moins';
            button.style.animation = 'fadeIn 0.3s ease';
        } else {
            fullDesc.classList.add('d-none');
            button.textContent = 'voir plus';
        }
    }
    
    // Add loading state to form buttons
    document.querySelectorAll('form button[type="submit"]').forEach(button => {
        button.addEventListener('click', function() {
            // Add loading class after a small delay to show the animation
            setTimeout(() => {
                this.classList.add('btn-loading');
                this.disabled = true;
            }, 100);
        });
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add subtle animation to cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all cards for scroll animation
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0.8';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
</script>
@endsection