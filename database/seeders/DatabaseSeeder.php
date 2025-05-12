<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run all seeders in correct order - this ensures proper relationships
        $this->call([
            // First seed cities (villes) since they're referenced by other models
            VilleSeeder::class,
            
            // Then categories and subcategories
            CategorieSeeder::class,
            SousCategorieSeeder::class,
            
            // Then users (utilisateurs)
            UtilisateurSeeder::class,
            
            // Then announcements (annonces) and related data
            AnnonceSeeder::class,
            ImageSeeder::class, // Only if there are announcements without images
            FavoriteSeeder::class,
        ]);

        // Display summary
        $this->command->info('Base de données créée avec succès !');
        $this->command->info('===========================');
        $this->command->info('Villes: ' . \App\Models\Ville::count());
        $this->command->info('Catégories: ' . \App\Models\Categorie::count());
        $this->command->info('Sous-catégories: ' . \App\Models\SousCategorie::count());
        $this->command->info('Utilisateurs: ' . \App\Models\Utilisateur::count());
        $this->command->info('Annonces: ' . \App\Models\Annonce::count());
        $this->command->info('Images: ' . \App\Models\Image::count());
        $this->command->info('Favoris: ' . \App\Models\Favorite::count());
    }
}