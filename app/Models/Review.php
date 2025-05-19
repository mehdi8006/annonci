<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_utilisateur',
        'id_annonce',
        'rating',
        'comment',
        'statut'
    ];

    /**
     * Get the utilisateur that owns the review.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    /**
     * Get the annonce that owns the review.
     */
    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'id_annonce');
    }
}