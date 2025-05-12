<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Utilisateur;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\SousCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnonceFactory extends Factory
{
    protected $model = Annonce::class;

    // Titres typiques pour différentes catégories
    private $titresParCategorie = [
        'Vehicules' => [
            'Voiture occasion bon etat %s',
            'Voiture neuve en promo %s',
            'SUV 7 places familiale %s',
            'Berline luxe faible kilometrage %s',
            'Moto sportive excellent etat %s'
        ],
        'Electronique' => [
            'Smartphone neuf sous garantie %s',
            'Laptop gaming puissant %s',
            'TV 4K derniere generation %s',
            'Appareil photo professionnel %s',
            'Console de jeux %s'
        ],
        'Immobilier' => [
            'Appartement moderne centre ville %s',
            'Villa avec jardin %s',
            'Studio meuble %s',
            'Bureau spacieux %s',
            'Maison traditionnelle %s'
        ],
        'Maison' => [
            'Meuble TV design moderne %s',
            'Canape cuir 3 places %s',
            'Machine a laver Samsung %s',
            'Refrigerateur LG neuf %s',
            'Lit double avec matelas %s'
        ],
        'Vetements' => [
            'Costume elegant %s',
            'Robe de soiree %s',
            'Chaussures sport Nike %s',
            'Sac a main luxe %s',
            'Montre automatique %s'
        ],
        'Animaux' => [
            'Chaton persan a vendre %s',
            'Chien berger allemand %s',
            'Cage perroquet grande taille %s',
            'Aquarium complet %s',
            'Accessoires chat neufs %s'
        ],
        'Sport' => [
            'Velo VTT professionnel %s',
            'Equipement football complet %s',
            'Raquette tennis Wilson %s',
            'Tapis roulant electrique %s',
            'Home gym complet %s'
        ],
        'Autres' => [
            'Cours particuliers maths physique %s',
            'Livres universitaires %s',
            'Guitare acoustique %s',
            'Service informatique domicile %s',
            'Offre emploi developpeur %s'
        ]
    ];

    // Descriptions typiques
    private $descriptionTemplates = [
        'Excellent etat, utilise rarement, entretenu avec soin.',
        'Neuf, jamais utilise, encore sous garantie constructeur.',
        'Occasion en tres bon etat, bien entretenu et fonctionnel.',
        'Prix negociable, possibilite de livraison dans toute la ville.',
        'A saisir rapidement, prix attractif pour achat rapide.',
        'Belle opportunite, qualite superieure a prix raisonnable.',
        'Urgent a vendre, cause demenagement imminent.',
        'Etat impeccable, pret a etre utilise immediatement.',
        'Derniere generation, toutes options incluses.',
        'Excellent rapport qualite-prix, achat securise.'
    ];

    public function definition()
    {
        // Get random category
        $categorie = Categorie::inRandomOrder()->first();
        
        // Get possible subcategories for this category
        $sousCategories = SousCategorie::where('id_categorie', $categorie->id)->get();
        
        // Generate title based on category
        $titre = $this->getTitreForCategorie($categorie->nom);
        
        return [
            'titre' => $titre,
            'description' => $this->faker->randomElement($this->descriptionTemplates) . "\n\n" . 
                           $this->faker->realText(300),
            'prix' => $this->getPrixParCategorie($categorie->nom),
            'date_publication' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'id_utilisateur' => Utilisateur::factory(),
            'id_ville' => Ville::factory(),
            'id_categorie' => $categorie->id,
            'id_sous_categorie' => $sousCategories->isNotEmpty() ? $sousCategories->random()->id : null,
            'statut' => $this->faker->randomElement(['en_attente', 'validee', 'supprimee']),
        ];
    }

    // État pour annonces validées
    public function validee()
    {
        return $this->state(fn () => [
            'statut' => 'validee',
        ]);
    }
    
    // État pour annonce avec catégorie spécifique
    public function withCategorie($catNom)
    {
        $categorie = Categorie::where('nom', $catNom)->first();
        
        if (!$categorie) {
            return $this->state(fn () => []);
        }

        $sousCategories = SousCategorie::where('id_categorie', $categorie->id)->get();
        
        return $this->state(fn () => [
            'id_categorie' => $categorie->id,
            'id_sous_categorie' => $sousCategories->isNotEmpty() ? $sousCategories->random()->id : null,
            'titre' => $this->getTitreForCategorie($categorie->nom),
            'prix' => $this->getPrixParCategorie($categorie->nom),
        ]);
    }
    
    // Get title based on category
    private function getTitreForCategorie($categorie)
    {
        if (isset($this->titresParCategorie[$categorie])) {
            $titreTemplate = $this->faker->randomElement($this->titresParCategorie[$categorie]);
            $marque = $this->faker->company;
            return sprintf($titreTemplate, "- $marque");
        }
        
        return $this->faker->sentence(5);
    }
    
    // Obtenir un prix réaliste selon la catégorie
    private function getPrixParCategorie($categorie)
    {
        switch ($categorie) {
            case 'Vehicules':
                return $this->faker->numberBetween(20000, 500000);
            case 'Immobilier':
                return $this->faker->numberBetween(500000, 5000000);
            case 'Electronique':
                return $this->faker->numberBetween(500, 50000);
            case 'Maison':
                return $this->faker->numberBetween(1000, 100000);
            case 'Animaux':
                return $this->faker->numberBetween(500, 20000);
            default:
                return $this->faker->numberBetween(100, 50000);
        }
    }
}