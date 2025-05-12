<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'utilisateurs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'email',
        'telephon',
        'password',
        'ville',
        'type_utilisateur',
        'statut'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    /**
     * Get the annonces for the user.
     */
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'id_utilisateur');
    }

    /**
     * Get the favorites for the user.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_utilisateur');
    }
}