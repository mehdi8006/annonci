<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Annonce;
use App\Models\Review;
use App\Models\Report;
use App\Models\Categorie;
use App\Models\Ville;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get basic statistics
        $stats = $this->getBasicStats();
        
        // Get chart data
        $chartData = $this->getChartData();
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity();
        
        // Get alerts and notifications
        $alerts = $this->getAlerts();
        
        return view('admin.dashboard', compact('stats', 'chartData', 'recentActivity', 'alerts'));
    }
    
    /**
     * Get basic statistics for dashboard cards
     */
    private function getBasicStats()
    {
        return [
            'users' => [
                'total' => Utilisateur::count(),
                'active' => Utilisateur::where('statut', 'valide')->count(),
                'pending' => Utilisateur::where('statut', 'en_attente')->count(),
                'inactive' => Utilisateur::where('statut', 'supprime')->count(),
                'this_month' => Utilisateur::whereMonth('created_at', Carbon::now()->month)->count(),
                'last_month' => Utilisateur::whereMonth('created_at', Carbon::now()->subMonth()->month)->count(),
            ],
            'annonces' => [
                'total' => Annonce::count(),
                'published' => Annonce::where('statut', 'validee')->count(),
                'pending' => Annonce::where('statut', 'en_attente')->count(),
                'deleted' => Annonce::where('statut', 'supprimee')->count(),
                'this_month' => Annonce::whereMonth('created_at', Carbon::now()->month)->count(),
                'last_month' => Annonce::whereMonth('created_at', Carbon::now()->subMonth()->month)->count(),
            ],
            'reviews' => [
                'total' => Review::count(),
                'approved' => Review::where('statut', 'approuve')->count(),
                'pending' => Review::where('statut', 'en_attente')->count(),
                'rejected' => Review::where('statut', 'rejete')->count(),
                'average_rating' => Review::where('statut', 'approuve')->avg('rating') ?: 0,
                'this_month' => Review::whereMonth('created_at', Carbon::now()->month)->count(),
            ],
            'reports' => [
                'total' => Report::count(),
                'pending' => Report::where('statut', 'en_attente')->count(),
                'processed' => Report::where('statut', 'traitee')->count(),
                'rejected' => Report::where('statut', 'rejetee')->count(),
                'critical' => $this->getCriticalReportsCount(),
                'this_month' => Report::whereMonth('created_at', Carbon::now()->month)->count(),
            ],
            'categories' => Categorie::count(),
            'cities' => Ville::count(),
        ];
    }
    
    /**
     * Get data for dashboard charts
     */
    private function getChartData()
    {
        return [
            'userRegistrations' => $this->getUserRegistrationData(),
            'annonceStatus' => $this->getAnnonceStatusData(),
            'reviewsRating' => $this->getReviewsRatingData(),
            'monthlyActivity' => $this->getMonthlyActivityData(),
            'topCategories' => $this->getTopCategoriesData(),
        ];
    }
    
    /**
     * Get user registration data for the last 12 months
     */
    private function getUserRegistrationData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = Utilisateur::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count();
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data,
        ];
    }
    
    /**
     * Get announcement status distribution
     */
    private function getAnnonceStatusData()
    {
        return [
            'labels' => ['Validées', 'En attente', 'Supprimées'],
            'data' => [
                Annonce::where('statut', 'validee')->count(),
                Annonce::where('statut', 'en_attente')->count(),
                Annonce::where('statut', 'supprimee')->count(),
            ],
            'colors' => ['#10b981', '#f59e0b', '#ef4444'],
        ];
    }
    
    /**
     * Get reviews rating distribution
     */
    private function getReviewsRatingData()
    {
        $ratings = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratings[] = Review::where('statut', 'approuve')->where('rating', $i)->count();
        }
        
        return [
            'labels' => ['1 étoile', '2 étoiles', '3 étoiles', '4 étoiles', '5 étoiles'],
            'data' => $ratings,
        ];
    }
    
    /**
     * Get monthly activity data (announcements vs reviews)
     */
    private function getMonthlyActivityData()
    {
        $months = [];
        $annonces = [];
        $reviews = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');
            
            $annonces[] = Annonce::whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month)
                                ->count();
                                
            $reviews[] = Review::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count();
        }
        
        return [
            'labels' => $months,
            'annonces' => $annonces,
            'reviews' => $reviews,
        ];
    }
    
    /**
     * Get top categories by announcement count
     */
    private function getTopCategoriesData()
    {
        $categories = Categorie::withCount('annonces')
                              ->orderBy('annonces_count', 'desc')
                              ->limit(8)
                              ->get();
        
        return [
            'labels' => $categories->pluck('nom')->toArray(),
            'data' => $categories->pluck('annonces_count')->toArray(),
        ];
    }
    
    /**
     * Get recent activity for the dashboard
     */
    private function getRecentActivity()
    {
        return [
            'users' => Utilisateur::latest()->limit(5)->get(),
            'annonces' => Annonce::with(['utilisateur', 'categorie'])
                                ->where('statut', 'en_attente')
                                ->latest()
                                ->limit(5)
                                ->get(),
            'reviews' => Review::with(['utilisateur', 'annonce'])
                              ->where('statut', 'en_attente')
                              ->latest()
                              ->limit(5)
                              ->get(),
            'reports' => Report::with(['utilisateur', 'annonce'])
                              ->where('statut', 'en_attente')
                              ->latest()
                              ->limit(5)
                              ->get(),
        ];
    }
    
    /**
     * Get alerts and notifications
     */
    private function getAlerts()
    {
        $alerts = [];
        
        // Check for pending users
        $pendingUsers = Utilisateur::where('statut', 'en_attente')->count();
        if ($pendingUsers > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fas fa-user-clock',
                'message' => "{$pendingUsers} utilisateur(s) en attente d'approbation",
                'action' => route('admin.users.index', ['statut' => 'en_attente']),
                'action_text' => 'Voir les utilisateurs',
            ];
        }
        
        // Check for pending announcements
        $pendingAnnonces = Annonce::where('statut', 'en_attente')->count();
        if ($pendingAnnonces > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'fas fa-bullhorn',
                'message' => "{$pendingAnnonces} annonce(s) en attente de validation",
                'action' => route('admin.annonces.index', ['statut' => 'en_attente']),
                'action_text' => 'Voir les annonces',
            ];
        }
        
        // Check for pending reviews
        $pendingReviews = Review::where('statut', 'en_attente')->count();
        if ($pendingReviews > 0) {
            $alerts[] = [
                'type' => 'primary',
                'icon' => 'fas fa-star',
                'message' => "{$pendingReviews} avis en attente de modération",
                'action' => route('admin.reviews.index', ['statut' => 'en_attente']),
                'action_text' => 'Modérer les avis',
            ];
        }
        
        // Check for critical reports
        $criticalReports = $this->getCriticalReportsCount();
        if ($criticalReports > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'fas fa-exclamation-triangle',
                'message' => "{$criticalReports} annonce(s) avec signalements multiples",
                'action' => route('admin.annonces.index', ['sort' => 'reports_count', 'direction' => 'desc']),
                'action_text' => 'Voir les signalements',
            ];
        }
        
        return $alerts;
    }
    
    /**
     * Get count of announcements with multiple reports (critical)
     */
    private function getCriticalReportsCount()
    {
        return Annonce::withCount(['reports' => function($query) {
                        $query->where('statut', 'en_attente');
                    }])
                    ->having('reports_count', '>=', 3)
                    ->count();
    }
    
    /**
     * Quick action: Approve all pending users
     */
    public function approveAllPendingUsers()
    {
        $count = Utilisateur::where('statut', 'en_attente')->count();
        Utilisateur::where('statut', 'en_attente')->update(['statut' => 'valide']);
        
        return response()->json([
            'success' => true,
            'message' => "{$count} utilisateur(s) approuvé(s) avec succès",
        ]);
    }
    
    /**
     * Quick action: Approve all pending announcements
     */
    public function approveAllPendingAnnonces()
    {
        $count = Annonce::where('statut', 'en_attente')->count();
        Annonce::where('statut', 'en_attente')->update(['statut' => 'validee']);
        
        return response()->json([
            'success' => true,
            'message' => "{$count} annonce(s) approuvée(s) avec succès",
        ]);
    }
    
    /**
     * Quick action: Auto-moderate reviews using existing OpenRouter service
     */
    public function autoModerateReviews()
    {
        $reviews = Review::where('statut', 'en_attente')->get();
        $approved = 0;
        $rejected = 0;
        
        // Use the existing OpenRouter service from AdminReviewController
        $openRouterService = app(\App\Services\OpenRouterService::class);
        
        foreach ($reviews as $review) {
            try {
                // Skip reviews without comments
                if (empty($review->comment)) {
                    continue;
                }

                $isRespectful = $openRouterService->isRespectful($review->comment);
                
                if ($isRespectful && $review->rating >= 1) {
                    $review->update(['statut' => 'approuve']);
                    $approved++;
                } else {
                    $review->update(['statut' => 'rejete']);
                    $rejected++;
                }
            } catch (\Exception $e) {
                // Log error but continue with other reviews
                \Log::error('Auto-moderation error for review #' . $review->id . ': ' . $e->getMessage());
                
                // Fallback to simple logic if OpenRouter fails
                if ($review->rating >= 3 && str_word_count($review->comment) >= 3) {
                    $review->update(['statut' => 'approuve']);
                    $approved++;
                } else {
                    $review->update(['statut' => 'rejete']);
                    $rejected++;
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "{$approved} avis approuvés, {$rejected} avis rejetés",
        ]);
    }
    
    /**
     * Get dashboard data via AJAX for real-time updates
     */
    public function getDashboardData()
    {
        return response()->json([
            'stats' => $this->getBasicStats(),
            'alerts' => $this->getAlerts(),
        ]);
    }
}