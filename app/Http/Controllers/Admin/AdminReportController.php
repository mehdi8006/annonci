<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminReportController extends AdminController
{
    /**
     * Display a listing of the reports
     */
    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $query = Report::with(['annonce', 'utilisateur']);
        
        // Apply status filter
        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }
        
        // Apply type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $reports = $query->paginate(15);
        
        return view('admin.reports.index', compact('reports'));
    }
    
    /**
     * Show a specific report
     */
    public function show($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $report = Report::with(['annonce', 'utilisateur', 'annonce.images'])->findOrFail($id);
        
        return view('admin.reports.show', compact('report'));
    }
    
    /**
     * Mark a report as handled
     */
    public function markAsHandled(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }
        
        $report = Report::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:traitee,rejetee',
            'comment' => 'nullable|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $report->statut = $request->statut;
        $report->date_traitement = now();
        $report->save();
        
        // If the report is accepted and was about an inappropriate listing,
        // we can optionally take action on the announcement itself
        if ($request->statut === 'traitee' && $request->has('action_annonce')) {
            $annonce = $report->annonce;
            
            switch ($request->action_annonce) {
                case 'delete':
                    $annonce->statut = 'supprimee';
                    $annonce->save();
                    break;
                    
                case 'suspend':
                    $annonce->statut = 'en_attente';
                    $annonce->save();
                    break;
            }
        }
        
        return redirect()->route('admin.reports.index')
            ->with('success', 'Signalement traité avec succès.');
    }
}