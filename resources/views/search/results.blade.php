@extends('layouts.masterhome')
<!-- Bootstrap 5 CSS -->

@section('main')
<div class="search-results-container">
    <!-- Display search filters -->
    @include('search.filters', [
        'categories' => $categories,
        'villes' => $villes,
        'sousCategories' => $sousCategories ?? [],
        'searchParams' => $searchParams ?? []
    ])
    <!-- Inside search/results.blade.php, update the search results count section -->
<div class="search-results-count">
    <h2>{{ $annonces->total() }} annonce(s) trouvée(s)</h2>
    @if(isset($searchTerm))
        <p>Résultats pour : "{{ $searchTerm }}"</p>
    @elseif(isset($categoryName))
        <p>Annonces dans la catégorie : "{{ $categoryName }}"</p>
    @elseif(isset($cityName))
        <p>Annonces à : "{{ $cityName }}"</p>
    @endif
</div>
   
    
    <!-- Display search results using pagecarte component -->
    <div class="search-results">
        @if($annonces->count() > 0)
            @include('search.resultscard', ['annonces' => $annonces])
        @else
            <div class="no-results">
                <p>Aucune annonce trouvée. Essayez avec d'autres critères de recherche.</p>
            </div>
        @endif
    </div>
    
    <!-- Pagination links -->
    <div class="pagination-container">
        {{ $annonces->appends(request()->query())->links() }}
    </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .search-results-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .search-results-count {
        margin: 20px 0;
        padding: 10px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .search-results-count h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
    }
    
    .search-results-count p {
        font-size: 1rem;
        color: #6b7280;
        margin-top: 5px;
    }
    
    .no-results {
        padding: 40px;
        text-align: center;
        background-color: #f9fafb;
        border-radius: 8px;
        margin: 20px 0;
    }
    
    .no-results p {
        font-size: 1.1rem;
        color: #6b7280;
    }
    
    .pagination-container {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    
    /* For the reset button */
    .btn-reset {
        display: inline-block;
        background-color: transparent;
        color: #666;
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
    }
</style>
@endsection