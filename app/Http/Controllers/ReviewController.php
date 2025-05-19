<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create($id)
    {
        // Check if user is logged in
        if (!Session::has('user_id')) {
            return redirect()->route('form')->with('error', 'Veuillez vous connecter pour laisser un avis.');
        }
        
        $userId = Session::get('user_id');
        $annonce = Annonce::findOrFail($id);
        
        // Check if user has already reviewed this annonce
        $existingReview = Review::where('id_utilisateur', $userId)
            ->where('id_annonce', $id)
            ->first();
            
        if ($existingReview) {
            return redirect()->route('details', $id)->with('error', 'Vous avez déjà laissé un avis pour cette annonce.');
        }
        
        // Check if user is the owner of the annonce
        if ($annonce->id_utilisateur == $userId) {
            return redirect()->route('details', $id)->with('error', 'Vous ne pouvez pas laisser un avis sur votre propre annonce.');
        }
        
        return view('reviews.create', compact('annonce'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, $id)
    {
        // Check if user is logged in
        if (!Session::has('user_id')) {
            return redirect()->route('form')->with('error', 'Veuillez vous connecter pour laisser un avis.');
        }
        
        $userId = Session::get('user_id');
        $annonce = Annonce::findOrFail($id);
        
        // Check if user has already reviewed this annonce
        $existingReview = Review::where('id_utilisateur', $userId)
            ->where('id_annonce', $id)
            ->first();
            
        if ($existingReview) {
            return redirect()->route('details', $id)->with('error', 'Vous avez déjà laissé un avis pour cette annonce.');
        }
        
        // Check if user is the owner of the annonce
        if ($annonce->id_utilisateur == $userId) {
            return redirect()->route('details', $id)->with('error', 'Vous ne pouvez pas laisser un avis sur votre propre annonce.');
        }
        
        // Validate input
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create new review
        $review = new Review();
        $review->id_utilisateur = $userId;
        $review->id_annonce = $id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->statut = 'en_attente'; // Reviews are pending approval by default
        $review->save();
        
        return redirect()->route('details', $id)->with('success', 'Votre avis a été soumis avec succès et est en attente d\'approbation.');
    }

    /**
     * Show all reviews for a specific annonce.
     */
    public function showAnnonceReviews($id)
    {
        $annonce = Annonce::with(['utilisateur', 'reviews' => function($query) {
            $query->where('statut', 'approuve')
                  ->with('utilisateur')
                  ->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        return view('reviews.show', compact('annonce'));
    }
}