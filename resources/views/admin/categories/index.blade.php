<!-- resources/views/admin/categories/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Gestion des catégories')

@section('content')
    <div class="admin-header">
        <h1>Gestion des catégories</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.categories.create') }}" class="admin-button">
                <i class="fas fa-plus"></i> Nouvelle catégorie
            </a>
            <a href="{{ route('admin.subcategories.create') }}" class="admin-button admin-button-secondary">
                <i class="fas fa-plus"></i> Nouvelle sous-catégorie
            </a>
        </div>
    </div>

    <div class="admin-card">
        @foreach($categories as $category)
            <div class="category-item">
                <div class="category-header">
                    <div class="category-title">
                        <h3>{{ $category->nom }}</h3>
                        @if($category->description)
                            <p class="category-description">{{ $category->description }}</p>
                        @endif
                    </div>
                    <div class="category-actions">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="admin-button">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-button admin-button-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie et toutes ses sous-catégories ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                @if($category->sousCategories->count() > 0)
                    <div class="subcategories-container">
                        <h4 class="subcategories-title">Sous-catégories</h4>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->sousCategories as $subcategory)
                                        <tr>
                                            <td>{{ $subcategory->id }}</td>
                                            <td>{{ $subcategory->nom }}</td>
                                            <td>{{ $subcategory->description ?? 'Aucune description' }}</td>
                                            <td class="admin-table-actions">
                                                <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}" class="admin-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-button admin-button-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette sous-catégorie ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p class="no-subcategories">Aucune sous-catégorie pour cette catégorie</p>
                @endif
            </div>
        @endforeach
    </div>
@endsection

@section('css')
<style>
    .category-item {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .category-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .category-title h3 {
        margin: 0;
        font-size: 20px;
        color: #1f2937;
    }
    
    .category-description {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 14px;
    }
    
    .category-actions {
        display: flex;
        gap: 5px;
    }
    
    .subcategories-title {
        font-size: 16px;
        color: #4b5563;
        margin-bottom: 15px;
        padding-left: 10px;
        border-left: 3px solid #3b82f6;
    }
    
    .no-subcategories {
        padding: 10px;
        color: #6b7280;
        font-style: italic;
    }
</style>
@endsection