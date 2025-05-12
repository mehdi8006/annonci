<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;

class UtilisateurSeeder extends Seeder
{
    public function run()
    {
        // Créer un administrateur principal
        Utilisateur::factory()->admin()->create([
            'nom' => 'Admin Principal',
            'email' => 'admin@annoncia.ma',
            'password' => bcrypt('password'),
            'ville' => 'Casablanca',
        ]);
        
        // Créer des admins supplémentaires (optionnel)
        Utilisateur::factory(2)->admin()->create();

        // Créer des utilisateurs normaux validés
        Utilisateur::factory(40)->validatedNormal()->create();

        // Créer des utilisateurs en attente
        Utilisateur::factory(10)->create([
            'type_utilisateur' => 'normal',
            'statut' => 'en_attente',
        ]);

        // Créer des utilisateurs supprimés (pour les tests)
        Utilisateur::factory(5)->create([
            'type_utilisateur' => 'normal',
            'statut' => 'supprime',
        ]);

        $this->command->info('Utilisateurs créés avec succès :');
        $this->command->info('- Administrateurs : ' . Utilisateur::where('type_utilisateur', 'admin')->count());
        $this->command->info('- Utilisateurs validés : ' . Utilisateur::where('statut', 'valide')->count());
        $this->command->info('- Utilisateurs en attente : ' . Utilisateur::where('statut', 'en_attente')->count());
    }
}