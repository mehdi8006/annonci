<?php

namespace Database\Factories;

use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    // Noms et prénoms marocains typiques (sans accents)
    private $prenoms = [
        'Mohammed', 'Ahmed', 'Hassan', 'Youssef', 'Karim', 'Omar', 'Ali', 'Hamza',
        'Fatima', 'Khadija', 'Aicha', 'Malika', 'Sanaa', 'Samira', 'Leila', 'Zineb'
    ];

    private $noms = [
        'Bennani', 'Alami', 'Tazi', 'Fassi', 'Marrakchi', 'Berrada', 'Cherkaoui', 
        'Radi', 'Idrissi', 'Lahlou', 'El Hajji', 'El Idrissi', 'Ouazzani', 'Ramdani'
    ];

    // Villes marocaines
    private $villes = [
        'Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Agadir', 'Tanger', 
        'Meknes', 'Oujda', 'Kenitra', 'Tetouan', 'Safi', 'El Hoceima', 
        'Nador', 'Settat', 'El Jadida', 'Ouarzazate', 'Dakhla', 'Laayoune'
    ];

    public function definition()
    {
        // Moroccan phone number format: typically +212 6XX XX XX XX or 06XX XX XX XX
        $telephon = '06' . $this->faker->numberBetween(10000000, 99999999);
        
        return [
            'nom' => $this->faker->randomElement($this->prenoms) . ' ' . $this->faker->randomElement($this->noms),
            'email' => $this->faker->unique()->safeEmail,
            'telephon' => $telephon, // Added the missing telephon field
            'password' => Hash::make('password'), // Mot de passe par défaut pour les tests
            'ville' => $this->faker->randomElement($this->villes),
            'type_utilisateur' => $this->faker->randomElement(['admin', 'normal']),
            'statut' => $this->faker->randomElement(['en_attente', 'valide', 'supprime']),
            'date_inscription' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }

    // État pour créer un admin
    public function admin()
    {
        return $this->state(fn () => [
            'type_utilisateur' => 'admin',
            'statut' => 'valide',
        ]);
    }

    // État pour créer un utilisateur normal validé
    public function validatedNormal()
    {
        return $this->state(fn () => [
            'type_utilisateur' => 'normal',
            'statut' => 'valide',
        ]);
    }
}