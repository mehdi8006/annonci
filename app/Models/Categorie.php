<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'description', // Ajouter ce champ
    ];
    /**
     * Get the sous-categories for the category.
     */
    public function sousCategories()
    {
        return $this->hasMany(SousCategorie::class, 'id_categorie');
    }

    /**
     * Get the annonces for the category.
     */
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'id_categorie');
    }
}