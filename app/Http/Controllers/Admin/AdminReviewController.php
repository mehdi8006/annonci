<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    protected $openRouterService;

    public function __construct(OpenRouterService $openRouterService)
    {
        $this->openRouterService = $openRouterService;
    }

    /**
     * Display a listing of the reviews.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Review::with(['utilisateur', 'annonce'])
            ->whereIn('statut', ['en_attente', 'rejete']);

        // Apply filters if provided
        if ($request->has('statut') && $request->statut) {
            $query->where('statut', $request->statut);
        }

        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'LIKE', "%{$search}%")
                  ->orWhereHas('utilisateur', function($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('annonce', function($q) use ($search) {
                      $q->where('titre', 'LIKE', "%{$search}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified review.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $review = Review::with(['utilisateur', 'annonce.utilisateur', 'annonce.images'])
            ->findOrFail($id);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->statut = 'approuve';
        $review->save();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'L\'avis a été approuvé avec succès.');
    }

    /**
     * Reject a review.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->statut = 'rejete';
        $review->save();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'L\'avis a été rejeté avec succès.');
    }

    /**
     * Auto-review comments using OpenRouter.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function autoReview(Request $request)
    {
        $reviews = Review::where('statut', 'en_attente')->get();
        $processedCount = 0;

        foreach ($reviews as $review) {
            try {
                // Skip reviews without comments
                if (empty($review->comment)) {
                    continue;
                }

                $result = $this->checkReviewWithAI($review->comment);
                
                if ($result['appropriate']) {
                    $review->statut = 'approuve';
                    $review->save();
                    $processedCount++;
                } else {
                    $review->statut = 'rejete';
                    $review->save();
                    $processedCount++;
                }
            } catch (\Exception $e) {
                // Log error but continue with other reviews
                \Log::error('Error processing review #' . $review->id . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.reviews.index')
            ->with('success', $processedCount . ' avis ont été traités automatiquement.');
    }

    /**
     * Delete all rejected reviews.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAllRejected(Request $request)
    {
        try {
            $deletedCount = Review::where('statut', 'rejete')->delete();

            return redirect()->route('admin.reviews.index')
                ->with('success', $deletedCount . ' avis rejetés ont été supprimés avec succès.');
        } catch (\Exception $e) {
            \Log::error('Error deleting rejected reviews: ' . $e->getMessage());
            
            return redirect()->route('admin.reviews.index')
                ->with('error', 'Une erreur est survenue lors de la suppression des avis rejetés.');
        }
    }

    /**
     * Check if a review comment is appropriate using OpenRouter.
     *
     * @param string $comment
     * @return array
     */
    private function checkReviewWithAI($comment)
    {
        try {
            $isRespectful = $this->openRouterService->isRespectful($comment);

            return [
                'appropriate' => $isRespectful,
                'response' => $isRespectful ? 'Respectful' : 'Not respectful'
            ];
        } catch (\Exception $e) {
            \Log::error('OpenRouter API Error: ' . $e->getMessage());
            // Default to manual review if API fails
            return [
                'appropriate' => false,
                'response' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}