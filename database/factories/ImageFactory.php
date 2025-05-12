<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    // List of image categories for better organization
    private $imageCategories = [
        'products', 'transport', 'electronics', 
        'business', 'fashion', 'animals', 
        'sports', 'home', 'real-estate'
    ];

    public function definition()
    {
        // Get random category
        $category = $this->faker->randomElement($this->imageCategories);
        
        // Generate unique image URL
        $imageUrl = '/images/' . $category . '_' . time() . '_' . $this->faker->uuid . '.jpg';
        
        return [
            'id_annonce' => Annonce::factory(),
            'url' => $imageUrl,
            'principale' => $this->faker->boolean(20), // 20% chance d'être l'image principale
        ];
    }

    // État pour image principale
    public function principale()
    {
        return $this->state(fn () => [
            'principale' => true,
        ]);
    }
    
    // État pour image avec URL spécifique
    public function withUrl($url)
    {
        return $this->state(fn () => [
            'url' => $url,
        ]);
    }
    
    // État pour une annonce spécifique
    public function forAnnonce($annonceId)
    {
        return $this->state(fn () => [
            'id_annonce' => $annonceId,
        ]);
    }
    
    // Créer plusieurs images pour une annonce
    public static function createMultipleForAnnonce($annonceId, $count = 3)
    {
        $images = [];
        for ($i = 0; $i < $count; $i++) {
            $image = self::factory()->create([
                'id_annonce' => $annonceId,
                'principale' => $i === 0, // First image is principale
                'url' => '/images/annonce_' . $annonceId . '_image_' . ($i + 1) . '.jpg',
            ]);
            $images[] = $image;
        }
        return $images;
    }
}