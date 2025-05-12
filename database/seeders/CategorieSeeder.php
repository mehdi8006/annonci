<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run()
    {
        // Catégories principales du site d'annonces
        $categories = [
            [
                'nom' => 'Immobilier',
                'description' => 'Ventes, locations, et autres biens immobiliers'
            ],
            [
                'nom' => 'Véhicules',
                'description' => 'Voitures, motos, et autres véhicules'
            ],
            [
                'nom' => 'Électronique',
                'description' => 'Smartphones, ordinateurs, et appareils électroniques'
            ],
            [
                'nom' => 'Maison',
                'description' => 'Meubles, électroménager, et articles pour la maison'
            ],
            [
                'nom' => 'Vêtements',
                'description' => 'Mode, vêtements, et accessoires'
            ],
            [
                'nom' => 'Animaux',
                'description' => 'Animaux de compagnie et accessoires'
            ],
            [
                'nom' => 'Sport',
                'description' => 'Équipements sportifs et loisirs'
            ],
            [
                'nom' => 'Autres',
                'description' => 'Autres articles et services'
            ]
        ];

        foreach ($categories as $cat) {
            Categorie::create($cat);
        }

        $this->command->info(count($categories) . ' catégories créées avec succès !');
    }
}