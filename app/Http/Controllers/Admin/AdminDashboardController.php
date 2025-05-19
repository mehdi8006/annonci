<?php

namespace App\Http\Controllers\Admin;

use App\Models\Annonce;
use App\Models\Utilisateur;
use App\Models\Report;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends AdminController
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        // User statistics
        $totalUsers = Utilisateur::count();
        $activeUsers = Utilisateur::where('statut', 'valide')->count();
        $pendingUsers = Utilisateur::where('statut', 'en_attente')->count();
        $newUsersThisMonth = Utilisateur::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        // Annonce statistics
        $totalAnnonces = Annonce::count();
        $activeAnnonces = Annonce::where('statut', 'validee')->count();
        $pendingAnnonces = Annonce::where('statut', 'en_attente')->count();
        $newAnnoncesThisMonth = Annonce::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        // Report statistics
        $totalReports = Report::count();
        $pendingReports = Report::where('statut', 'en_attente')->count();
        
        // Review statistics
        $totalReviews = Review::count();
        $pendingReviews = Review::where('statut', 'en_attente')->count();
        
        // Get latest activities
        $latestUsers = Utilisateur::latest()->take(5)->get();
        $latestAnnonces = Annonce::with('utilisateur')->latest()->take(5)->get();
        $latestReports = Report::with(['annonce', 'utilisateur'])->latest()->take(5)->get();
        
        // Get monthly user registration stats for chart
        $userRegistrationsChart = $this->getUserRegistrationsChart();
        
        // Get monthly listings stats for chart
        $annonceCreationChart = $this->getAnnonceCreationChart();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'pendingUsers', 'newUsersThisMonth',
            'totalAnnonces', 'activeAnnonces', 'pendingAnnonces', 'newAnnoncesThisMonth',
            'totalReports', 'pendingReports', 'totalReviews', 'pendingReviews',
            'latestUsers', 'latestAnnonces', 'latestReports',
            'userRegistrationsChart', 'annonceCreationChart'
        ));
    }
    
    /**
     * Get monthly user registrations for the last 6 months
     */
    private function getUserRegistrationsChart()
    {
        $months = collect([]);
        $counts = collect([]);
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push($date->format('M'));
            
            $count = Utilisateur::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
                
            $counts->push($count);
        }
        
        return [
            'months' => $months,
            'counts' => $counts
        ];
    }
    
    /**
     * Get monthly annonce creation for the last 6 months
     */
    private function getAnnonceCreationChart()
    {
        $months = collect([]);
        $counts = collect([]);
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push($date->format('M'));
            
            $count = Annonce::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
                
            $counts->push($count);
        }
        
        return [
            'months' => $months,
            'counts' => $counts
        ];
    }
}