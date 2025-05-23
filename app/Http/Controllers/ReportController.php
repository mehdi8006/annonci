<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
   /**
    * Show report form for an announcement
    * Note: This method is now protected by middleware, so we know user is authenticated
    */
   public function showReportForm($id)
   {
       $annonce = Annonce::findOrFail($id);
       
       // Check if user has already reported this ad
       $userId = Session::get('user_id');
       $reportCount = Report::where('id_annonce', $id)
           ->where('id_utilisateur', $userId)
           ->count();
       
       if ($reportCount >= 1) {
           return redirect()->route('details', $id)
               ->with('error', 'Vous avez déjà signalé cette annonce. Un seul signalement est autorisé par annonce.');
       }
       
       return view('reports.create', compact('annonce'));
   }

   /**
    * Store a new report
    * Note: This method is now protected by middleware, so we know user is authenticated
    */
   public function storeReport(Request $request, $id)
   {
       $userId = Session::get('user_id');
       
       // Validate input
       $validator = Validator::make($request->all(), [
           'type' => 'required|in:fraude,contenu_inapproprie,produit_interdit,doublon,mauvaise_categorie,autre',
           'description' => 'nullable|string|max:1000',
       ]);

       if ($validator->fails()) {
           return redirect()->back()
               ->withErrors($validator)
               ->withInput();
       }

       // Check if annonce exists
       $annonce = Annonce::findOrFail($id);
       
       // Check if user has already reported this ad
       $reportCount = Report::where('id_annonce', $id)
           ->where('id_utilisateur', $userId)
           ->count();
       
       if ($reportCount >= 1) {
           return redirect()->route('details', $id)
               ->with('error', 'Vous avez déjà signalé cette annonce. Un seul signalement est autorisé par annonce.');
       }

       // Create report
       $report = new Report();
       $report->id_annonce = $annonce->id;
       $report->id_utilisateur = $userId;
       $report->type = $request->type;
       $report->description = $request->description;
       $report->save();
       
       $successMessage = 'Merci d\'avoir signalé cette annonce. Nous allons l\'examiner dans les plus brefs délais.';
       
       return redirect()->route('details', $annonce->id)
           ->with('success', $successMessage);
   }
}