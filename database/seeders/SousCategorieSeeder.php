<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\SousCategorie;

class SousCategorieSeeder extends Seeder
{
    public function run()
    {
        // Sous-catégories par catégorie
        $sousCategories = [
            'Immobilier' => [
                'Appartement à vendre', 'Maison à vendre', 'Appartement à louer',
                'Villa', 'Terrain', 'Bureau', 'Local commercial', 'Studio',
                'Duplex', 'Riad', 'Garage', 'Ferme'
            ],
            'Véhicules' => [
                'Voiture', 'Moto', 'Camion', 'Bus', 'Pièces auto',
                'Scooter', 'Vélo', 'Accessoires auto', 'Tracteur', 'Remorque'
            ],
            'Électronique' => [
                'Smartphone', 'Ordinateur', 'TV', 'Console', 'Caméra',
                'Audio', 'Accessoires', 'Tablette', 'Imprimante', 'Montre connectée'
            ],
            'Maison' => [
                'Meubles', 'Cuisine', 'Électroménager', 'Décoration',
                'Bricolage', 'Jardin', 'Salle de bain', 'Literie', 'Rangement'
            ],
            'Vêtements' => [
                'Homme', 'Femme', 'Enfant', 'Chaussures', 'Accessoires',
                'Montres', 'Bijoux', 'Sacs', 'Lunettes', 'Maroquinerie'
            ],
            'Animaux' => [
                'Chiens', 'Chats', 'Oiseaux', 'Accessoires animalerie',
                'Aquarium', 'Autres animaux', 'Aliments', 'Cages'
            ],
            'Sport' => [
                'Football', 'Basketball', 'Tennis', 'Fitness', 'Vélo',
                'Natation', 'Autres sports', 'Running', 'Yoga', 'Golf'
            ],
            'Autres' => [
                'Services', 'Emploi', 'Livres', 'CD/DVD', 'Instruments musique',
                'Jeux', 'Bébé', 'Mode traditionnelle', 'Artisanat', 'Collection'
            ]
        ];

        $totalSousCategories = 0;

        foreach ($sousCategories as $categorieName => $subCategories) {
            $categorie = Categorie::where('nom', $categorieName)->first();
            
            if ($categorie) {
                foreach ($subCategories as $subCatName) {
                    SousCategorie::create([
                        'nom' => $subCatName,
                        'description' => "Sous-catégorie pour {$categorieName}: {$subCatName}",
                        'id_categorie' => $categorie->id
                    ]);
                    $totalSousCategories++;
                }
            }
        }

        $this->command->info($totalSousCategories . ' sous-catégories créées avec succès !');
    }
}