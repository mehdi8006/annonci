<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Utilisateur;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'id_utilisateur' => Utilisateur::factory(),
            'id_annonce' => Annonce::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional(0.8)->paragraph(),
            'statut' => $this->faker->randomElement(['en_attente', 'approuve', 'rejete']),
        ];
    }

    /**
     * Configure the model factory to create an approved review.
     */
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'approuve',
            ];
        });
    }

    /**
     * Configure the model factory to create a pending review.
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'en_attente',
            ];
        });
    }

    /**
     * Configure the model factory to create a rejected review.
     */
    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'rejete',
            ];
        });
    }

    /**
     * Configure the model factory for a specific user and announcement.
     */
    public function forUserAndAnnonce($userId, $annonceId)
    {
        return $this->state(function (array $attributes) use ($userId, $annonceId) {
            return [
                'id_utilisateur' => $userId,
                'id_annonce' => $annonceId,
            ];
        });
    }
}