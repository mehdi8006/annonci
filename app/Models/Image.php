<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_annonce',
        'url',
        'principale'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'principale' => 'boolean',
    ];

    /**
     * Get the annonce that owns the image.
     */
    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'id_annonce');
    }
}