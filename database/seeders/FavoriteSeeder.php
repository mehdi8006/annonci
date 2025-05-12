<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\Utilisateur;
use App\Models\Annonce;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        // Obtenir les utilisateurs validés
        $utilisateurs = Utilisateur::where('type_utilisateur', 'normal')
                                 ->where('statut', 'valide')
                                 ->get();

        // Obtenir toutes les annonces validées
        $annonces = Annonce::where('statut', 'validee')->get();

        $totalFavorites = 0;

        // Créer des favoris pour environ 50% des utilisateurs
        foreach ($utilisateurs->random(min(25, $utilisateurs->count())) as $utilisateur) {
            // Chaque utilisateur favorite entre 1 et 10 annonces
            $nombreFavorites = rand(1, 10);
            
            // Sélectionner des annonces aléatoires (qui ne sont pas les siennes)
            $annoncesPossibles = $annonces->where('id_utilisateur', '!=', $utilisateur->id);
            
            if ($annoncesPossibles->isNotEmpty()) {
                $annonces_favorites = $annoncesPossibles->random(min($nombreFavorites, $annoncesPossibles->count()));
                
                foreach ($annonces_favorites as $annonce) {
                    // Vérifier que le favori n'existe pas déjà pour éviter les doublons
                    if (!Favorite::where('id_utilisateur', $utilisateur->id)
                                ->where('id_annonce', $annonce->id)
                                ->exists()) {
                        Favorite::create([
                            'id_utilisateur' => $utilisateur->id,
                            'id_annonce' => $annonce->id,
                        ]);
                        $totalFavorites++;
                    }
                }
            }
        }

        $this->command->info($totalFavorites . ' favoris créés avec succès !');
        $this->command->info('Statistiques :');
        $this->command->info('- Utilisateurs avec favoris : ' . 
            Favorite::select('id_utilisateur')->distinct()->count());
        $this->command->info('- Annonces mises en favori : ' . 
            Favorite::select('id_annonce')->distinct()->count());
    }
}