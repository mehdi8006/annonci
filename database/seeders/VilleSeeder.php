<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ville;

class VilleSeeder extends Seeder
{
    public function run()
    {
        // Villes et régions du Maroc
        $villesMaroc = [
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

        foreach ($villesMaroc as $nom => $region) {
            Ville::create([
                'nom' => $nom,
                'region' => $region
            ]);
        }

        $this->command->info(count($villesMaroc) . ' villes créées avec succès !');
    }
}