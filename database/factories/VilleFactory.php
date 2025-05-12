<?php

namespace Database\Factories;

use App\Models\Ville;
use Illuminate\Database\Eloquent\Factories\Factory;

class VilleFactory extends Factory
{
    protected $model = Ville::class;

    // Villes et régions du Maroc (données réelles sans accents)
    private $villesMaroc = [
        'Casablanca' => 'Casablanca-Settat',
        'Rabat' => 'Rabat-Sale-Kenitra',
        'Marrakech' => 'Marrakech-Safi',
        'Fes' => 'Fes-Meknes',
        'Agadir' => 'Souss-Massa',
        'Tanger' => 'Tanger-Tetouan-Al Hoceima',
        'Meknes' => 'Fes-Meknes',
        'Oujda' => 'Oriental',
        'Kenitra' => 'Rabat-Sale-Kenitra',
        'Tetouan' => 'Tanger-Tetouan-Al Hoceima',
        'Safi' => 'Marrakech-Safi',
        'El Hoceima' => 'Tanger-Tetouan-Al Hoceima',
        'Nador' => 'Oriental',
        'Settat' => 'Casablanca-Settat',
        'El Jadida' => 'Casablanca-Settat',
        'Ouarzazate' => 'Draa-Tafilalet',
        'Dakhla' => 'Dakhla-Oued Ed-Dahab',
        'Laayoune' => 'Laayoune-Sakia El Hamra',
        'Berkane' => 'Oriental',
        'Khemisset' => 'Rabat-Sale-Kenitra',
        'Ifrane' => 'Fes-Meknes',
        'Essaouira' => 'Marrakech-Safi',
        'Taounate' => 'Fes-Meknes',
        'Guelmim' => 'Guelmim-Oued Noun',
        'Azrou' => 'Fes-Meknes'
    ];

    public function definition()
    {
        $ville = $this->faker->randomElement(array_keys($this->villesMaroc));
        
        return [
            'nom' => $ville,
            'region' => $this->villesMaroc[$ville],
        ];
    }
    
    // État pour une ville spécifique
    public function named($nom)
    {
        return $this->state(fn () => [
            'nom' => $nom,
            'region' => $this->villesMaroc[$nom] ?? 'Region inconnue',
        ]);
    }
}