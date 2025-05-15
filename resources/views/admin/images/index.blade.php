@extends('layouts.admin')

@section('title', 'Gestion des Images')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            Gestion des Images
            @if($annonceId)
                de l'annonce #{{ $annonceId }}
            @endif
        </h1>
        @if($annonceId)
            <a href="{{ route('admin.annonces.show', $annonceId) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour à l'annonce
            </a>
        @else
            <a href="{{ route('admin.annonces') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux annonces
            </a>
        @endif
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Images</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($images as $image)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card {{ $image->principale ? 'border-primary' : '' }}">
                        <img src="{{ asset($image->url) }}" class="card-img-top" alt="Image" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Annonce #{{ $image->id_annonce }}</h5>
                            <p class="card-text">
                                @if($image->principale)
                                    <span class="badge bg-primary">Image principale</span>
                                @else
                                    <span class="badge bg-secondary">Image secondaire</span>
                                @endif
                            </p>
                            <div class="d-flex flex-column gap-2">
                                @if(!$image->principale)
                                <form action="{{ route('admin.images.set-main', $image->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                        <i class="fas fa-star me-1"></i> Définir comme principale
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.images.delete', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                        <i class="fas fa-trash me-1"></i> Supprimer
                                    </button>
                                </form>
                                <a href="{{ route('admin.annonces.show', $image->id_annonce) }}" class="btn btn-sm btn-info w-100">
                                    <i class="fas fa-eye me-1"></i> Voir l'annonce
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p>Aucune image trouvée.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $images->links() }}
            </div>
        </div>
    </div>
</div>
@endsection