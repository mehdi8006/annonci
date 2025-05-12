<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategorie extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sous_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'id_categorie',
        'description', // Ajouter ce champ
        
    ];

    /**
     * Get the category that owns the sous-category.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    /**
     * Get the annonces for the sous-category.
     */
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'id_sous_categorie');
    }
}