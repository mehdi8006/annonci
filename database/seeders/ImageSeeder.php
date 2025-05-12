<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Annonce;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    public function run()
    {
        // Get all annonces that don't have images yet
        $annonces = Annonce::doesntHave('images')->get();
        
        $totalImages = 0;
        
        foreach ($annonces as $annonce) {
            // Create between 1 and 5 images for each annonce
            $nombreImages = rand(1, 5);
            
            for ($j = 0; $j < $nombreImages; $j++) {
                Image::create([
                    'id_annonce' => $annonce->id,
                    'url' => '/images/annonce_' . $annonce->id . '_image_' . ($j + 1) . '.jpg',
                    'principale' => $j === 0, // First image is principale
                ]);
                $totalImages++;
            }
        }

        $this->command->info($totalImages . ' images créées avec succès !');
    }
}