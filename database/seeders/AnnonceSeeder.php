<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Annonce;
use App\Models\Utilisateur;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Image;

class AnnonceSeeder extends Seeder
{
    public function run()
    {
        // Obtenir les utilisateurs validés normaux
        $utilisateurs = Utilisateur::where('type_utilisateur', 'normal')
                                 ->where('statut', 'valide')
                                 ->get();

        // Obtenir toutes les villes et catégories
        $villes = Ville::all();
        $categories = Categorie::all();

        $totalAnnonces = 0;
        $totalImages = 0;

        // Créer des annonces pour chaque catégorie
        foreach ($categories as $categorie) {
            // Get subcategories for this category
            $sousCategories = SousCategorie::where('id_categorie', $categorie->id)->get();
            
            // Créer entre 5 et 15 annonces validées par catégorie
            $nombreAnnonces = rand(5, 15);
            
            for ($i = 0; $i < $nombreAnnonces; $i++) {
                // Sélectionner un utilisateur aléatoire
                $utilisateur = $utilisateurs->random();
                
                // Créer l'annonce
                $annonce = Annonce::factory()
                    ->validee()
                    ->withCategorie($categorie->nom)
                    ->create([
                        'id_utilisateur' => $utilisateur->id,
                        'id_ville' => $villes->random()->id,
                    ]);

                // Créer entre 1 et 5 images pour chaque annonce
                $nombreImages = rand(1, 5);
                
                for ($j = 0; $j < $nombreImages; $j++) {
                    Image::create([
                        'id_annonce' => $annonce->id,
                        'url' => '/images/placeholder_' . $annonce->id . '_' . $j . '.jpg',
                        'principale' => $j === 0, // La première image est principale
                    ]);
                    $totalImages++;
                }
                
                $totalAnnonces++;
            }
        }

        // Créer quelques annonces en attente et supprimées
        $annoncesPendantes = 10;
        for ($i = 0; $i < $annoncesPendantes; $i++) {
            $categorie = $categories->random();
            $sousCategories = SousCategorie::where('id_categorie', $categorie->id)->get();
            
            $annonce = Annonce::factory()
                ->create([
                    'id_utilisateur' => $utilisateurs->random()->id,
                    'id_ville' => $villes->random()->id,
                    'id_categorie' => $categorie->id,
                    'id_sous_categorie' => $sousCategories->isNotEmpty() ? 
                                           $sousCategories->random()->id : 
                                           null,
                    'statut' => 'en_attente',
                ]);
                
            // Ajouter une image
            Image::create([
                'id_annonce' => $annonce->id,
                'url' => '/images/placeholder_pending_' . $annonce->id . '.jpg',
                'principale' => true,
            ]);
            $totalImages++;
        }

        $this->command->info($totalAnnonces . ' annonces créées avec succès !');
        $this->command->info($totalImages . ' images créées !');
        $this->command->info('Annonces par statut :');
        $this->command->info('- Validées : ' . Annonce::where('statut', 'validee')->count());
        $this->command->info('- En attente : ' . Annonce::where('statut', 'en_attente')->count());
        $this->command->info('- Supprimées : ' . Annonce::where('statut', 'supprimee')->count());
    }
}