<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class AdminReviewController extends Controller
{
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
     * Auto-review comments using OpenAI.
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
     * Check if a review comment is appropriate using OpenAI.
     *
     * @param string $comment
     * @return array
     */
    private function checkReviewWithAI($comment)
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Vous êtes un modérateur de contenu. Analysez ce commentaire d\'avis client et déterminez s\'il est approprié pour publication. Répondez uniquement par "oui" si c\'est approprié ou "non" si ce n\'est pas approprié (contient des insultes, langage grossier, contenu inapproprié, etc).'],
                    ['role' => 'user', 'content' => $comment],
                ],
                'temperature' => 0.2,
            ]);

            $aiResponse = $response->choices[0]->message->content;
            $isAppropriate = (strtolower(trim($aiResponse)) === 'oui');

            return [
                'appropriate' => $isAppropriate,
                'response' => $aiResponse
            ];
        } catch (\Exception $e) {
            \Log::error('OpenAI API Error: ' . $e->getMessage());
            // Default to manual review if API fails
            return [
                'appropriate' => false,
                'response' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}