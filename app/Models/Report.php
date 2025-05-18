<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_annonce',
        'id_utilisateur',
        'type',
        'description',
        'statut',
        'date_traitement'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_traitement' => 'datetime',
    ];

    /**
     * Get the annonce that was reported.
     */
    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'id_annonce');
    }

    /**
     * Get the user who reported the annonce.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}