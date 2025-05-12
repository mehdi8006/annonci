<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'region',
       
    ];

    /**
     
   
     * Get the annonces for the city.
     */
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'id_ville');
    }
}