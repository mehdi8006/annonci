<!-- resources/views/admin/annonces/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Détails de l\'annonce')

@section('content')
    <div class="admin-header">
        <h1>Détails de l'annonce #{{ $annonce->id }}</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.annonces.index') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <a href="{{ route('details', $annonce->id) }}" target="_blank" class="admin-button">
                <i class="fas fa-external-link-alt"></i> Voir sur le site
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Status Card -->
        <div class="col-lg-12 mb-4">
            <div class="admin-card status-dashboard">
                <div class="status-content">
                    <div class="status-info">
                        <span class="status-label">Statut actuel:</span>
                        <span class="status-badge 
                            @if($annonce->statut === 'validee') status-success
                            @elseif($annonce->statut === 'en_attente') status-warning
                            @else status-danger
                            @endif">
                            <i class="status-icon 
                                @if($annonce->statut === 'validee') fas fa-check
                                @elseif($annonce->statut === 'en_attente') fas fa-clock
                                @else fas fa-ban
                                @endif"></i>
                            {{ ucfirst(str_replace('_', ' ', $annonce->statut)) }}
                        </span>
                    </div>
                    <div class="status-actions">
                        <form action="{{ route('admin.annonces.updateStatus', $annonce->id) }}" method="POST" class="status-form">
                            @csrf
                            @method('PUT')
                            <div class="btn-group status-buttons" role="group">
                                <button type="submit" name="statut" value="validee" class="btn {{ $annonce->statut === 'validee' ? 'btn-success active' : 'btn-outline-success' }}">
                                    <i class="fas fa-check"></i> Approuver
                                </button>
                                <button type="submit" name="statut" value="en_attente" class="btn {{ $annonce->statut === 'en_attente' ? 'btn-warning active' : 'btn-outline-warning' }}">
                                    <i class="fas fa-clock"></i> En attente
                                </button>
                                <button type="submit" name="statut" value="supprimee" class="btn {{ $annonce->statut === 'supprimee' ? 'btn-danger active' : 'btn-outline-danger' }}">
                                    <i class="fas fa-ban"></i> Supprimer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Annonce Details -->
        <div class="col-lg-8">
            <!-- Main Info Card -->
            <div class="admin-card mb-4">
                <div class="annonce-header">
                    <div class="annonce-title-wrapper">
                        <h2 class="annonce-title">{{ $annonce->titre }}</h2>
                        <div class="annonce-meta">
                            <span class="annonce-date">
                                <i class="fas fa-calendar-alt"></i> Créée le {{ $annonce->created_at->format('d/m/Y à H:i') }}
                            </span>
                            <span class="annonce-price">
                                <i class="fas fa-tag"></i> {{ number_format($annonce->prix, 2, ',', ' ') }} DH
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="annonce-content">
                    <div class="annonce-category-info">
                        <div class="category-badge">
                            <i class="fas fa-folder"></i> {{ $annonce->categorie->nom }}
                            @if($annonce->sousCategorie)
                                <span class="subcategory">→ {{ $annonce->sousCategorie->nom }}</span>
                            @endif
                        </div>
                        <div class="location-badge">
                            <i class="fas fa-map-marker-alt"></i> {{ $annonce->ville->nom }}
                        </div>
                    </div>
                    
                    <div class="annonce-description">
                        <h3 class="section-title">Description</h3>
                        <div class="description-content">
                            {{ $annonce->description }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Images Card -->
            <div class="admin-card mb-4">
                <h3 class="section-title">Images</h3>
                
                @if($annonce->images->count() > 0)
                    <div class="annonce-images">
                        @foreach($annonce->images as $image)
                            <div class="image-card {{ $image->principale ? 'image-main' : '' }}">
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $image->url) }}" alt="Image de l'annonce" class="annonce-image">
                                    @if($image->principale)
                                        <div class="image-badge">Principale</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-content">
                        <i class="fas fa-images no-content-icon"></i>
                        <p>Aucune image disponible pour cette annonce</p>
                    </div>
                @endif
            </div>
            
            <!-- Reports Card (if any) -->
            @if($annonce->reports->count() > 0)
                <div class="admin-card mb-4">
                    <h3 class="section-title">
                        Signalements
                        <span class="badge rounded-pill bg-danger ms-2">{{ $annonce->reports->count() }}</span>
                    </h3>
                    
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Utilisateur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($annonce->reports as $report)
                                    <tr>
                                        <td>{{ $report->id }}</td>
                                        <td>
                                            @switch($report->type)
                                                @case('fraude')
                                                    <span class="badge bg-danger">Fraude</span>
                                                    @break
                                                @case('contenu_inapproprie')
                                                    <span class="badge bg-danger">Contenu inapproprié</span>
                                                    @break
                                                @case('produit_interdit')
                                                    <span class="badge bg-danger">Produit interdit</span>
                                                    @break
                                                @case('doublon')
                                                    <span class="badge bg-warning text-dark">Doublon</span>
                                                    @break
                                                @case('mauvaise_categorie')
                                                    <span class="badge bg-warning text-dark">Mauvaise catégorie</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">Autre</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $report->utilisateur ? $report->utilisateur->nom : 'Anonyme' }}</td>
                                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($report->statut === 'traitee')
                                                <span class="badge bg-success">Traité</span>
                                            @elseif($report->statut === 'en_attente')
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            @else
                                                <span class="badge bg-danger">Rejeté</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Seller Info Card -->
            <div class="admin-card mb-4">
                <h3 class="section-title">Informations vendeur</h3>
                
                <div class="seller-profile">
                    <div class="seller-avatar">
                        {{ strtoupper(substr($annonce->utilisateur->nom, 0, 1)) }}
                    </div>
                    
                    <div class="seller-name">
                        {{ $annonce->utilisateur->nom }}
                        <span class="seller-status 
                            @if($annonce->utilisateur->statut === 'valide') status-dot-success
                            @elseif($annonce->utilisateur->statut === 'en_attente') status-dot-warning
                            @else status-dot-danger
                            @endif">
                        </span>
                    </div>
                    
                    <div class="seller-contact">
                        <div class="seller-info-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $annonce->utilisateur->email }}</span>
                        </div>
                        <div class="seller-info-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $annonce->utilisateur->telephon }}</span>
                        </div>
                        <div class="seller-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $annonce->utilisateur->ville }}</span>
                        </div>
                        <div class="seller-info-item">
                            <i class="fas fa-user-shield"></i>
                            <span>
                                @if($annonce->utilisateur->type_utilisateur === 'admin')
                                    Administrateur
                                @else
                                    Utilisateur standard
                                @endif
                            </span>
                        </div>
                        <div class="seller-info-item">
                            <i class="fas fa-user-clock"></i>
                            <span>Inscrit le {{ date('d/m/Y', strtotime($annonce->utilisateur->date_inscription)) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.users.show', $annonce->utilisateur->id) }}" class="btn btn-primary w-100 mt-3">
                        <i class="fas fa-user"></i> Voir profil complet
                    </a>
                </div>
            </div>
            
            <!-- Additional Info Card -->
            <div class="admin-card">
                <h3 class="section-title">Actions rapides</h3>
                
                <div class="quick-actions">
                    @php
                        $totalAnnonces = $annonce->utilisateur->annonces->count();
                        $totalValidees = $annonce->utilisateur->annonces->where('statut', 'validee')->count();
                        $totalEnAttente = $annonce->utilisateur->annonces->where('statut', 'en_attente')->count();
                    @endphp
                    
                    <div class="seller-stats mb-3">
                        <div class="stat-item">
                            <div class="stat-value">{{ $totalAnnonces }}</div>
                            <div class="stat-label">Annonces</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $totalValidees }}</div>
                            <div class="stat-label">Validées</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $totalEnAttente }}</div>
                            <div class="stat-label">En attente</div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('details', $annonce->id) }}" target="_blank" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-external-link-alt"></i> Voir sur le site
                        </a>
                        
                        <a href="{{ route('admin.annonces.index') }}?search={{ $annonce->utilisateur->nom }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-search"></i> Voir toutes les annonces de ce vendeur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    /* General */
    .mb-2 {
        margin-bottom: 0.5rem !important;
    }
    
    .mb-3 {
        margin-bottom: 1rem !important;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }
    
    .mt-3 {
        margin-top: 1rem !important;
    }
    
    .ms-2 {
        margin-left: 0.5rem !important;
    }
    
    .w-100 {
        width: 100%;
    }
    
    .d-flex {
        display: flex;
    }
    
    .align-items-center {
        align-items: center;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .text-center {
        text-align: center;
    }
    
    .rounded-pill {
        border-radius: 50rem !important;
    }
    
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    
    .bg-danger {
        background-color: #ef4444 !important;
        color: white;
    }
    
    .bg-success {
        background-color: #10b981 !important;
        color: white;
    }
    
    .bg-warning {
        background-color: #f59e0b !important;
    }
    
    .bg-secondary {
        background-color: #64748b !important;
        color: white;
    }
    
    .bg-primary {
        background-color: #3b82f6 !important;
        color: white;
    }
    
    .text-dark {
        color: #1f2937 !important;
    }
    
    /* Status dashboard */
    .status-dashboard {
        background: linear-gradient(to right, #f9fafb, #f3f4f6);
        border-left: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .status-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .status-info {
        display: flex;
        align-items: center;
    }
    
    .status-label {
        font-size: 16px;
        color: #4b5563;
        margin-right: 10px;
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 14px;
    }
    
    .status-success {
        background-color: #d1fae5;
        color: #059669;
    }
    
    .status-warning {
        background-color: #fef3c7;
        color: #d97706;
    }
    
    .status-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }
    
    .status-icon {
        margin-right: 6px;
    }
    
    .status-actions {
        display: flex;
    }
    
    .status-buttons .btn {
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 0;
        transition: all 0.2s;
    }
    
    .status-buttons .btn:first-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    
    .status-buttons .btn:last-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    
    .status-buttons .btn.active {
        font-weight: 600;
    }
    
    .status-buttons .btn-outline-success:hover {
        background-color: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    .status-buttons .btn-outline-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }
    
    .status-buttons .btn-outline-danger:hover {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
    }
    
    /* Annonce details */
    .annonce-header {
        margin-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 20px;
    }
    
    .annonce-title-wrapper {
        display: flex;
        flex-direction: column;
    }
    
    .annonce-title {
        margin: 0 0 10px 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .annonce-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .annonce-date, .annonce-price {
        font-size: 14px;
        display: flex;
        align-items: center;
    }
    
    .annonce-date i, .annonce-price i {
        margin-right: 5px;
        color: #6b7280;
    }
    
    .annonce-date {
        color: #6b7280;
    }
    
    .annonce-price {
        font-weight: 600;
        color: #2563eb;
    }
    
    .annonce-category-info {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .category-badge, .location-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 5px;
        background-color: #f3f4f6;
        color: #4b5563;
        font-size: 14px;
    }
    
    .category-badge i, .location-badge i {
        margin-right: 5px;
    }
    
    .category-badge {
        background-color: #eff6ff;
        color: #2563eb;
    }
    
    .category-badge .subcategory {
        margin-left: 5px;
        font-weight: 400;
        font-size: 12px;
        opacity: 0.8;
    }
    
    .location-badge {
        background-color: #f3f4f6;
        color: #4b5563;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 15px 0;
        color: #1f2937;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .annonce-description {
        margin-top: 20px;
    }
    
    .description-content {
        color: #4b5563;
        line-height: 1.6;
        white-space: pre-line;
    }
    
    /* Images section */
    .annonce-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }
    
    .image-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    
    .image-card.image-main {
        grid-column: span 2;
        grid-row: span 2;
    }
    
    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .image-wrapper {
        position: relative;
        width: 100%;
        padding-top: 75%; /* 4:3 aspect ratio */
        overflow: hidden;
    }
    
    .annonce-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(37, 99, 235, 0.8);
        color: white;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 3px;
        z-index: 1;
    }
    
    .no-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px;
        color: #9ca3af;
        text-align: center;
    }
    
    .no-content-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }
    
    /* Seller profile */
    .seller-profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px 0;
    }
    
    .seller-avatar {
        width: 80px;
        height: 80px;
        background-color: #3b82f6;
        color: white;
        font-size: 32px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 15px;
    }
    
    .seller-name {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }
    
    .status-dot-success, .status-dot-warning, .status-dot-danger {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-left: 8px;
    }
    
    .status-dot-success {
        background-color: #10b981;
    }
    
    .status-dot-warning {
        background-color: #f59e0b;
    }
    
    .status-dot-danger {
        background-color: #ef4444;
    }
    
    .seller-contact {
        width: 100%;
        margin-top: 15px;
    }
    
    .seller-info-item {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .seller-info-item:last-child {
        border-bottom: none;
    }
    
    .seller-info-item i {
        width: 20px;
        color: #6b7280;
        margin-right: 10px;
    }
    
    .seller-info-item span {
        color: #4b5563;
        word-break: break-all;
    }
    
    /* Stats and quick actions */
    .seller-stats {
        display: flex;
        justify-content: space-between;
        text-align: center;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 15px;
    }
    
    .stat-item {
        flex: 1;
        padding: 10px;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
    }
    
    .stat-item:not(:last-child) {
        border-right: none;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .stat-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }
    
    /* Button styles */
    .btn {
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        transition: color 0.15s, background-color 0.15s, border-color 0.15s, box-shadow 0.15s;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }
    
    .btn-primary {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-primary:hover {
        color: #fff;
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
    
    .btn-outline-primary {
        color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-outline-primary:hover {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-success {
        color: #fff;
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .btn-success:hover {
        color: #fff;
        background-color: #0ca678;
        border-color: #099268;
    }
    
    .btn-outline-success {
        color: #10b981;
        border-color: #10b981;
    }
    
    .btn-outline-success:hover {
        color: #fff;
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .btn-warning {
        color: #000;
        background-color: #f59e0b;
        border-color: #f59e0b;
    }
    
    .btn-warning:hover {
        color: #000;
        background-color: #ffca2c;
        border-color: #ffc720;
    }
    
    .btn-outline-warning {
        color: #f59e0b;
        border-color: #f59e0b;
    }
    
    .btn-outline-warning:hover {
        color: #000;
        background-color: #f59e0b;
        border-color: #f59e0b;
    }
    
    .btn-danger {
        color: #fff;
        background-color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-danger:hover {
        color: #fff;
        background-color: #bb2d3b;
        border-color: #b02a37;
    }
    
    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-outline-danger:hover {
        color: #fff;
        background-color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-group {
        position: relative;
        display: inline-flex;
        vertical-align: middle;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Responsive styles */
    @media (max-width: 992px) {
        .status-content {
            flex-direction: column;
            gap: 15px;
        }
        
        .status-info {
            margin-bottom: 10px;
        }
        
        .seller-avatar {
            width: 70px;
            height: 70px;
            font-size: 28px;
        }
    }
    
    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .admin-header-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            width: 100%;
        }
        
        .admin-header-actions .admin-button {
            flex: 1;
            text-align: center;
        }
        
        .annonce-images {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
        
        .image-card.image-main {
            grid-column: span 1;
            grid-row: span 1;
        }
        
        .seller-stats {
            flex-direction: column;
        }
        
        .stat-item:not(:last-child) {
            border-right: 1px solid #e5e7eb;
            border-bottom: none;
        }
        
        .status-buttons .btn {
            padding: 6px 12px;
            font-size: 14px;
        }
    }
    
    @media (max-width: 576px) {
        .status-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .status-buttons .btn {
            width: 100%;
            margin-bottom: 5px;
            border-radius: 4px !important;
        }
        
        .status-buttons .btn:not(:last-child) {
            margin-bottom: 5px;
        }
        
        .annonce-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .annonce-category-info {
            flex-direction: column;
            gap: 5px;
        }
        
        .annonce-images {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection