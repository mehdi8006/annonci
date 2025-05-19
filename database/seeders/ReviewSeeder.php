<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Annonce;
use App\Models\Utilisateur;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all valid announcements
        $annonces = Annonce::where('statut', 'validee')->get();
        
        // Get all valid users
        $utilisateurs = Utilisateur::where('statut', 'valide')->get();
        
        $totalReviews = 0;
        
        // For each announcement, create 0-5 random reviews
        foreach ($annonces as $annonce) {
            // Skip some announcements randomly
            if (rand(0, 3) == 0) {
                continue;
            }
            
            // Get random number of reviews for this announcement
            $numReviews = rand(0, 5);
            
            // Get random users excluding the owner of the announcement
            $potentialReviewers = $utilisateurs->where('id', '!=', $annonce->id_utilisateur)->shuffle()->take($numReviews);
            
            foreach ($potentialReviewers as $reviewer) {
                // Check if a review already exists
                $existingReview = Review::where('id_utilisateur', $reviewer->id)
                    ->where('id_annonce', $annonce->id)
                    ->first();
                    
                if ($existingReview) {
                    continue;
                }
                
                // Create the review
                Review::create([
                    'id_utilisateur' => $reviewer->id,
                    'id_annonce' => $annonce->id,
                    'rating' => rand(3, 5), // Most reviews are positive
                    'comment' => $this->getRandomComment(),
                    'statut' => 'approuve' // Auto-approve for seeding
                ]);
                
                $totalReviews++;
            }
        }
        
       $this->command->info($totalReviews . ' reviews created successfully!');
    }
    
    /**
     * Get a random review comment
     */
    private function getRandomComment()
    {
        $comments = [
            'Très bonne expérience d\'achat, je recommande vivement ce vendeur!',
            'Le produit correspond parfaitement à la description. Je suis très satisfait.',
            'Vendeur sérieux et réactif, transaction parfaite.',
            'Bonne communication et envoi rapide. Merci!',
            'Produit de qualité, je suis content de mon achat.',
            'Transaction idéale, rien à redire.',
            'Le vendeur a été très professionnel et attentif à mes questions.',
            'Je recommande ce vendeur pour son sérieux et sa fiabilité.',
            'Livraison rapide et produit conforme à la description.',
            'Très bon rapport qualité/prix, je suis satisfait de mon achat.',
            'Service client au top, merci pour votre réactivité!',
            'Parfait, rien à redire!',
            'Excellente transaction, je recommande!',
            'Tout s\'est bien passé, merci!',
            null, // Some reviews might not have comments
        ];
        
        return $comments[array_rand($comments)];
    }
}