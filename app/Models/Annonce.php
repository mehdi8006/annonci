<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annonce extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'annonces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'description',
        'prix',
        'id_utilisateur',
        'id_ville',
        'id_categorie',
        'id_sous_categorie',
        'statut'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'prix' => 'decimal:2',
        'date_publication' => 'datetime',
    ];

    /**
     * Get the utilisateur that owns the annonce.
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
    public function ville(): BelongsTo
{
    return $this->belongsTo(Ville::class, 'id_ville');
}

    /**
     * Get the categorie that owns the annonce.
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    /**
     * Get the sous-categorie that owns the annonce.
     */
    public function sousCategorie(): BelongsTo
    {
        return $this->belongsTo(SousCategorie::class, 'id_sous_categorie');
    }

    /**
     * Get the images for the annonce.
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'id_annonce');
    }

    /**
     * Get the favorites for the annonce.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_annonce');
    }
}