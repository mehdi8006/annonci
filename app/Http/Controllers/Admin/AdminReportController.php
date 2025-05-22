<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Display a listing of pending reports grouped by annonce.
     */
    public function index(Request $request)
    {
        // Get reports with their annonce and user relationships, grouped by annonce
        $reportsQuery = Report::with(['annonce.utilisateur', 'annonce.images', 'utilisateur'])
            ->whereHas('annonce') // Only reports with existing annonces
            ->when($request->statut, function ($query, $statut) {
                return $query->where('statut', $statut);
            })
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            });

        // Default to pending reports only
        if (!$request->has('statut')) {
            $reportsQuery->where('statut', 'en_attente');
        }

        // Group reports by annonce
        $reports = $reportsQuery->get()->groupBy('id_annonce');

        // Convert to collection with additional data
        $groupedReports = $reports->map(function ($annonceReports) {
            return [
                'annonce' => $annonceReports->first()->annonce,
                'reports' => $annonceReports,
                'reports_count' => $annonceReports->count(),
                'types_count' => $annonceReports->groupBy('type')->count()
            ];
        })->sortByDesc('reports_count');

        return view('admin.reports.index', compact('groupedReports'));
    }

    /**
     * Display detailed reports for a specific annonce grouped by type.
     */
    public function show($annonceId)
    {
        // Get the annonce with its relationships
        $annonce = Annonce::with(['utilisateur', 'images', 'ville', 'categorie', 'sousCategorie'])
            ->findOrFail($annonceId);

        // Get all reports for this annonce grouped by type
        $reports = Report::with('utilisateur')
            ->where('id_annonce', $annonceId)
            ->get()
            ->groupBy('type');

        // Report types with their display names and colors
        $reportTypes = [
            'fraude' => ['name' => 'Fraude', 'color' => 'danger', 'icon' => 'fas fa-exclamation-triangle'],
            'contenu_inapproprie' => ['name' => 'Contenu inapproprié', 'color' => 'warning', 'icon' => 'fas fa-eye-slash'],
            'produit_interdit' => ['name' => 'Produit interdit', 'color' => 'dark', 'icon' => 'fas fa-ban'],
            'doublon' => ['name' => 'Doublon', 'color' => 'info', 'icon' => 'fas fa-copy'],
            'mauvaise_categorie' => ['name' => 'Mauvaise catégorie', 'color' => 'secondary', 'icon' => 'fas fa-tags'],
            'autre' => ['name' => 'Autre', 'color' => 'primary', 'icon' => 'fas fa-question-circle']
        ];

        $totalReports = $reports->flatten()->count();
        $pendingReports = $reports->flatten()->where('statut', 'en_attente')->count();

        return view('admin.reports.show', compact(
            'annonce', 
            'reports', 
            'reportTypes', 
            'totalReports', 
            'pendingReports'
        ));
    }

    /**
     * Process all reports for an annonce (keep or delete annonce).
     */
    public function processAllReports(Request $request, $annonceId)
    {
        $request->validate([
            'action' => 'required|in:keep,delete'
        ]);

        $annonce = Annonce::findOrFail($annonceId);
        $action = $request->input('action');

        DB::beginTransaction();
        
        try {
            // Update all pending reports for this annonce to 'traitee'
            Report::where('id_annonce', $annonceId)
                ->where('statut', 'en_attente')
                ->update([
                    'statut' => 'traitee',
                    'date_traitement' => now()
                ]);

            // Update annonce status based on action
            if ($action === 'delete') {
                $annonce->update(['statut' => 'supprimee']);
                $message = 'Tous les signalements ont été traités et l\'annonce a été supprimée.';
            } else {
                // Keep the annonce - ensure it's validated if it was pending
                if ($annonce->statut === 'en_attente') {
                    $annonce->update(['statut' => 'validee']);
                }
                $message = 'Tous les signalements ont été traités et l\'annonce a été conservée.';
            }

            DB::commit();

            return redirect()->route('admin.reports.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite lors du traitement des signalements.');
        }
    }
}