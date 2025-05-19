<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends AdminController
{
    /**
     * Display a listing of the reviews
     */
    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $query = Review::with(['annonce', 'utilisateur']);
        
        // Apply status filter
        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }
        
        // Apply rating filter
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }
        
        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $reviews = $query->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }
    
    /**
     * Show a specific review
     */
    public function show($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $review = Review::with(['annonce', 'utilisateur', 'annonce.images'])->findOrFail($id);
        
        return view('admin.reviews.show', compact('review'));
    }
    
    /**
     * Approve a review
     */
    public function approve($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $review = Review::findOrFail($id);
        
        if ($review->statut !== 'en_attente') {
            return redirect()->route('admin.reviews.index')
                ->with('error', 'Cet avis n\'est pas en attente d\'approbation.');
        }
        
        $review->statut = 'approuve';
        $review->save();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis approuvé avec succès.');
    }
    
    /**
     * Reject a review
     */
    public function reject($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $review = Review::findOrFail($id);
        
        if ($review->statut !== 'en_attente') {
            return redirect()->route('admin.reviews.index')
                ->with('error', 'Cet avis n\'est pas en attente d\'approbation.');
        }
        
        $review->statut = 'rejete';
        $review->save();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis rejeté avec succès.');
    }
}