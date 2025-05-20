<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Utilisateur;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition()
    {
        $reportTypes = ['fraude', 'contenu_inapproprie', 'produit_interdit', 'doublon', 'mauvaise_categorie', 'autre'];
        $statuses = ['en_attente', 'traitee', 'rejetee'];
        
        return [
            'id_annonce' => Annonce::factory(),
            'id_utilisateur' => Utilisateur::factory(),
            'type' => $this->faker->randomElement($reportTypes),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'statut' => $this->faker->randomElement($statuses),
            'date_traitement' => $this->faker->optional(0.5)->dateTimeBetween('-3 months', 'now'),
        ];
    }

    /**
     * Configure the model factory to create a pending report.
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'en_attente',
                'date_traitement' => null,
            ];
        });
    }

    /**
     * Configure the model factory to create a processed report.
     */
    public function processed()
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'traitee',
                'date_traitement' => $this->faker->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }

    /**
     * Configure the model factory to create a rejected report.
     */
    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'rejetee',
                'date_traitement' => $this->faker->dateTimeBetween('-1 month', 'now'),
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

    /**
     * Configure the model factory for a specific report type.
     */
    public function ofType($type)
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'type' => $type,
            ];
        });
    }
}