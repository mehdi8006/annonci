<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Utilisateur;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminStatisticController extends Controller
{
    /**
     * Display the statistics dashboard
     */
    public function index(Request $request)
    {
        // Get date range from request or set defaults
        $startDate = $request->get('start_date', Carbon::now()->subYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Get all statistics
        $statistics = [
            'announcements_by_city' => $this->getAnnouncementsByCity($startDate, $endDate),
            'announcements_by_category' => $this->getAnnouncementsByCategory($startDate, $endDate),
            'announcements_by_subcategory' => $this->getAnnouncementsBySubcategory($startDate, $endDate),
            'announcements_by_period' => $this->getAnnouncementsByPeriod(),
            'top_users_by_favorites' => $this->getTopUsersByFavorites(),
            'top_users_by_announcements' => $this->getTopUsersByAnnouncements(),
            'summary_stats' => $this->getSummaryStats(),
            'monthly_trend' => $this->getMonthlyTrend($startDate, $endDate),
        ];
        
        return view('admin.statistics.index', compact('statistics', 'startDate', 'endDate'));
    }
    
    /**
     * Get announcements grouped by city
     */
    private function getAnnouncementsByCity($startDate, $endDate)
    {
        return Annonce::select('villes.nom as ville_nom', DB::raw('COUNT(*) as total'))
            ->join('villes', 'annonces.id_ville', '=', 'villes.id')
            ->whereBetween('annonces.created_at', [$startDate, $endDate])
            ->groupBy('villes.id', 'villes.nom')
            ->orderBy('total', 'desc')
            ->limit(15)
            ->get();
    }
    
    /**
     * Get announcements grouped by category
     */
    private function getAnnouncementsByCategory($startDate, $endDate)
    {
        return Annonce::select('categories.nom as categorie_nom', DB::raw('COUNT(*) as total'))
            ->join('categories', 'annonces.id_categorie', '=', 'categories.id')
            ->whereBetween('annonces.created_at', [$startDate, $endDate])
            ->groupBy('categories.id', 'categories.nom')
            ->orderBy('total', 'desc')
            ->get();
    }
    
    /**
     * Get announcements grouped by subcategory
     */
    private function getAnnouncementsBySubcategory($startDate, $endDate)
    {
        return Annonce::select(
                'sous_categories.nom as sous_categorie_nom', 
                'categories.nom as categorie_nom',
                DB::raw('COUNT(*) as total')
            )
            ->join('sous_categories', 'annonces.id_sous_categorie', '=', 'sous_categories.id')
            ->join('categories', 'annonces.id_categorie', '=', 'categories.id')
            ->whereBetween('annonces.created_at', [$startDate, $endDate])
            ->whereNotNull('annonces.id_sous_categorie')
            ->groupBy('sous_categories.id', 'sous_categories.nom', 'categories.nom')
            ->orderBy('total', 'desc')
            ->limit(20)
            ->get();
    }
    
    /**
     * Get announcements by different time periods
     */
    private function getAnnouncementsByPeriod()
    {
        $now = Carbon::now();
        
        return [
            '1_day' => Annonce::where('created_at', '>=', $now->copy()->subDay())->count(),
            '1_week' => Annonce::where('created_at', '>=', $now->copy()->subWeek())->count(),
            '1_month' => Annonce::where('created_at', '>=', $now->copy()->subMonth())->count(),
            '6_months' => Annonce::where('created_at', '>=', $now->copy()->subMonths(6))->count(),
            '1_year' => Annonce::where('created_at', '>=', $now->copy()->subYear())->count(),
        ];
    }
    
    /**
     * Get top users by number of favorites received
     */
    private function getTopUsersByFavorites()
    {
        return Utilisateur::select(
                'utilisateurs.nom', 
                'utilisateurs.email',
                'utilisateurs.created_at',
                DB::raw('COUNT(favorites.id) as total_favorites')
            )
            ->join('annonces', 'utilisateurs.id', '=', 'annonces.id_utilisateur')
            ->join('favorites', 'annonces.id', '=', 'favorites.id_annonce')
            ->groupBy('utilisateurs.id', 'utilisateurs.nom', 'utilisateurs.email', 'utilisateurs.created_at')
            ->orderBy('total_favorites', 'desc')
            ->limit(10)
            ->get();
    }
    
    /**
     * Get top users by number of announcements
     */
    private function getTopUsersByAnnouncements()
    {
        return Utilisateur::select(
                'utilisateurs.nom', 
                'utilisateurs.email',
                'utilisateurs.created_at',
                DB::raw('COUNT(annonces.id) as total_annonces')
            )
            ->join('annonces', 'utilisateurs.id', '=', 'annonces.id_utilisateur')
            ->groupBy('utilisateurs.id', 'utilisateurs.nom', 'utilisateurs.email', 'utilisateurs.created_at')
            ->orderBy('total_annonces', 'desc')
            ->limit(10)
            ->get();
    }
    
    /**
     * Get summary statistics
     */
    private function getSummaryStats()
    {
        return [
            'total_announcements' => Annonce::count(),
            'total_users' => Utilisateur::count(),
            'total_favorites' => Favorite::count(),
            'total_cities' => Ville::count(),
            'total_categories' => Categorie::count(),
            'total_subcategories' => SousCategorie::count(),
            'active_announcements' => Annonce::where('statut', 'validee')->count(),
            'pending_announcements' => Annonce::where('statut', 'en_attente')->count(),
            'active_users' => Utilisateur::where('statut', 'valide')->count(),
            'avg_announcements_per_user' => round(Annonce::count() / max(Utilisateur::count(), 1), 2),
        ];
    }
    
    /**
     * Get monthly trend data
     */
    private function getMonthlyTrend($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $months = [];
        $announcements = [];
        $users = [];
        
        // Generate monthly data
        $current = $start->copy()->startOfMonth();
        while ($current <= $end) {
            $months[] = $current->format('M Y');
            
            $announcements[] = Annonce::whereYear('created_at', $current->year)
                ->whereMonth('created_at', $current->month)
                ->count();
                
            $users[] = Utilisateur::whereYear('created_at', $current->year)
                ->whereMonth('created_at', $current->month)
                ->count();
                
            $current->addMonth();
        }
        
        return [
            'labels' => $months,
            'announcements' => $announcements,
            'users' => $users,
        ];
    }
    
    /**
     * Export statistics to CSV
     */
    public function exportCsv(Request $request)
    {
        $type = $request->get('type', 'cities');
        $startDate = $request->get('start_date', Carbon::now()->subYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $filename = "statistiques_{$type}_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            switch ($type) {
                case 'cities':
                    fputcsv($file, ['Ville', 'Nombre d\'annonces']);
                    $data = $this->getAnnouncementsByCity($startDate, $endDate);
                    foreach ($data as $item) {
                        fputcsv($file, [$item->ville_nom, $item->total]);
                    }
                    break;
                    
                case 'categories':
                    fputcsv($file, ['Catégorie', 'Nombre d\'annonces']);
                    $data = $this->getAnnouncementsByCategory($startDate, $endDate);
                    foreach ($data as $item) {
                        fputcsv($file, [$item->categorie_nom, $item->total]);
                    }
                    break;
                    
                case 'subcategories':
                    fputcsv($file, ['Sous-catégorie', 'Catégorie', 'Nombre d\'annonces']);
                    $data = $this->getAnnouncementsBySubcategory($startDate, $endDate);
                    foreach ($data as $item) {
                        fputcsv($file, [$item->sous_categorie_nom, $item->categorie_nom, $item->total]);
                    }
                    break;
                    
                case 'users_favorites':
                    fputcsv($file, ['Utilisateur', 'Email', 'Nombre de favoris']);
                    $data = $this->getTopUsersByFavorites();
                    foreach ($data as $item) {
                        fputcsv($file, [$item->nom, $item->email, $item->total_favorites]);
                    }
                    break;
                    
                case 'users_announcements':
                    fputcsv($file, ['Utilisateur', 'Email', 'Nombre d\'annonces']);
                    $data = $this->getTopUsersByAnnouncements();
                    foreach ($data as $item) {
                        fputcsv($file, [$item->nom, $item->email, $item->total_annonces]);
                    }
                    break;
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Get statistics data via AJAX
     */
    public function getData(Request $request)
    {
        $type = $request->get('type');
        $startDate = $request->get('start_date', Carbon::now()->subYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        switch ($type) {
            case 'cities':
                return response()->json($this->getAnnouncementsByCity($startDate, $endDate));
            case 'categories':
                return response()->json($this->getAnnouncementsByCategory($startDate, $endDate));
            case 'subcategories':
                return response()->json($this->getAnnouncementsBySubcategory($startDate, $endDate));
            case 'trend':
                return response()->json($this->getMonthlyTrend($startDate, $endDate));
            default:
                return response()->json(['error' => 'Type not found'], 404);
        }
    }
}