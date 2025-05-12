<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Utilisateur;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'id_utilisateur' => Utilisateur::factory(),
            'id_annonce' => Annonce::factory(),
        ];
    }
    
    // État pour favoris avec utilisateur et annonce existants
    public function forUserAndAnnonce($userId, $annonceId)
    {
        return $this->state(fn () => [
            'id_utilisateur' => $userId,
            'id_annonce' => $annonceId,
        ]);
    }
    
    // Créer plusieurs favoris pour un utilisateur
    public function multipleForUser($userId, $annonceIds)
    {
        $instances = [];
        foreach ($annonceIds as $annonceId) {
            $instances[] = $this->state(fn () => [
                'id_utilisateur' => $userId,
                'id_annonce' => $annonceId,
            ]);
        }
        return $instances;
    }
}