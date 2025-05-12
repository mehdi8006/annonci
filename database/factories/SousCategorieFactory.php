<?php

namespace Database\Factories;

use App\Models\SousCategorie;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class SousCategorieFactory extends Factory
{
    protected $model = SousCategorie::class;

    // Sous-catégories par catégorie
    private $sousCategories = [
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

    public function definition()
    {
        return [
            'nom' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'id_categorie' => Categorie::factory(),
        ];
    }
    
    // État pour créer une sous-catégorie spécifique
    public function forCategory($categorieNom)
    {
        return $this->state(function () use ($categorieNom) {
            if (isset($this->sousCategories[$categorieNom])) {
                $sousCat = $this->faker->randomElement($this->sousCategories[$categorieNom]);
                return [
                    'nom' => $sousCat,
                    'description' => "Sous-catégorie pour {$categorieNom}: {$sousCat}",
                ];
            }
            return [];
        });
    }
}