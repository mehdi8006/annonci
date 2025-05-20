<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\Annonce;
use App\Models\Utilisateur;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get valid announcements (target for reports)
        $annonces = Annonce::where('statut', 'validee')->get();
        
        // Get all users
        $utilisateurs = Utilisateur::where('statut', 'valide')->get();
        
        $totalReports = 0;
        $reportTypes = ['fraude', 'contenu_inapproprie', 'produit_interdit', 'doublon', 'mauvaise_categorie', 'autre'];
        $reportReasons = [
            'fraude' => [
                'Le vendeur a demandé un paiement anticipé et a disparu',
                'Prix trop bas pour être honnête, probable arnaque',
                'Produit contrefait évident',
                'Le vendeur refuse d\'utiliser le système de paiement sécurisé'
            ],
            'contenu_inapproprie' => [
                'Images inappropriées ou à caractère adulte',
                'Langage offensant dans la description',
                'Contenu discriminatoire',
                'Photos non liées au produit'
            ],
            'produit_interdit' => [
                'Vente de produits pharmaceutiques sans prescription',
                'Produits contrefaits',
                'Articles interdits par la loi',
                'Vente d\'animaux protégés'
            ],
            'doublon' => [
                'Cette annonce est publiée plusieurs fois par le même vendeur',
                'Doublon évident avec l\'annonce #',
                'Même produit affiché dans plusieurs catégories',
                'Annonce republiée quotidiennement pour la remonter'
            ],
            'mauvaise_categorie' => [
                'Cette annonce appartient à la catégorie Véhicules, pas Électronique',
                'Mauvaise sous-catégorie, devrait être dans ',
                'Produit dans la mauvaise section',
                'Annonce de service placée dans produits'
            ],
            'autre' => [
                'Prix affiché incorrect par rapport à la description',
                'Informations de contact manquantes',
                'Annonce trompeuse',
                'Le vendeur ne répond pas aux messages'
            ]
        ];
        
        // Create reports for about 15% of listings
        $annonceSelection = $annonces->random(intval($annonces->count() * 0.15));
        
        foreach ($annonceSelection as $annonce) {
            // Number of reports per announcement (1-3)
            $numReports = rand(1, 3);
            
            for ($i = 0; $i < $numReports; $i++) {
                // Choose a random reporter (exclude the owner of the announcement)
                $reporter = $utilisateurs->where('id', '!=', $annonce->id_utilisateur)->random();
                
                // Choose a random report type
                $reportType = $reportTypes[array_rand($reportTypes)];
                
                // Get a reason based on the report type
                $description = $reportReasons[$reportType][array_rand($reportReasons[$reportType])];
                
                // If it's a duplicate report, add a random announcement number
                if ($reportType == 'doublon') {
                    $otherAnnonceId = $annonces->where('id', '!=', $annonce->id)->random()->id;
                    $description = str_replace('#', $otherAnnonceId, $description);
                }
                
                // If it's a wrong category report, add a random category
                if ($reportType == 'mauvaise_categorie' && str_contains($description, 'devrait être dans')) {
                    $randomSousCategories = \App\Models\SousCategorie::inRandomOrder()->first();
                    $description = str_replace('devrait être dans ', 'devrait être dans ' . $randomSousCategories->nom, $description);
                }
                
                // Determine status (biased towards pending for recent ones, processed for older ones)
                $daysSinceCreation = now()->diffInDays($annonce->created_at);
                
                if ($daysSinceCreation < 7) {
                    // Recent announcements mostly have pending reports
                    $statusProbability = ['en_attente' => 80, 'traitee' => 15, 'rejetee' => 5];
                } else {
                    // Older announcements mostly have processed reports
                    $statusProbability = ['en_attente' => 20, 'traitee' => 60, 'rejetee' => 20];
                }
                
                $statusRoll = rand(1, 100);
                $cumulativeProbability = 0;
                $status = 'en_attente'; // Default
                
                foreach ($statusProbability as $stat => $probability) {
                    $cumulativeProbability += $probability;
                    if ($statusRoll <= $cumulativeProbability) {
                        $status = $stat;
                        break;
                    }
                }
                
                // Determine treatment date for processed reports
                $dateTraitement = null;
                if ($status != 'en_attente') {
                    // Reports are typically processed 1-14 days after creation
                    $dateTraitement = $annonce->created_at->copy()->addDays(rand(1, 14));
                    // Ensure it's not in the future
                    if ($dateTraitement->isAfter(now())) {
                        $dateTraitement = now()->subDays(rand(1, 3));
                    }
                }
                
                // Create the report
                Report::create([
                    'id_annonce' => $annonce->id,
                    'id_utilisateur' => $reporter->id,
                    'type' => $reportType,
                    'description' => $description,
                    'statut' => $status,
                    'date_traitement' => $dateTraitement,
                    'created_at' => $annonce->created_at->copy()->addDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
                
                $totalReports++;
            }
        }
        
        $this->command->info($totalReports . ' reports created successfully!');
        $this->command->info('Reports by status:');
        $this->command->info('- Pending: ' . Report::where('statut', 'en_attente')->count());
        $this->command->info('- Processed: ' . Report::where('statut', 'traitee')->count());
        $this->command->info('- Rejected: ' . Report::where('statut', 'rejetee')->count());
        $this->command->info('Reports by type:');
        foreach ($reportTypes as $type) {
            $this->command->info("- $type: " . Report::where('type', $type)->count());
        }
    }
}