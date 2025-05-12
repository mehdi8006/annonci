<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    // Catégories prédéfinies (basées sur votre projet)
    private $categories = [
        ['nom' => 'Immobilier', 'description' => 'Ventes, locations, et autres biens immobiliers'],
        ['nom' => 'Véhicules', 'description' => 'Voitures, motos, et autres véhicules'],
        ['nom' => 'Électronique', 'description' => 'Smartphones, ordinateurs, et appareils électroniques'],
        ['nom' => 'Maison', 'description' => 'Meubles, électroménager, et articles pour la maison'],
        ['nom' => 'Vêtements', 'description' => 'Mode, vêtements, et accessoires'],
        ['nom' => 'Animaux', 'description' => 'Animaux de compagnie et accessoires'],
        ['nom' => 'Sport', 'description' => 'Équipements sportifs et loisirs'],
        ['nom' => 'Autres', 'description' => 'Autres articles et services'],
    ];

    public function definition()
    {
        $category = $this->faker->randomElement($this->categories);
        
        return [
            'nom' => $category['nom'],
            'description' => $category['description'],
        ];
    }
    
    // État pour une catégorie spécifique (par nom)
    public function withName($nom)
    {
        $category = collect($this->categories)->firstWhere('nom', $nom);
        
        return $this->state(fn () => [
            'nom' => $category['nom'],
            'description' => $category['description'],
        ]);
    }
}