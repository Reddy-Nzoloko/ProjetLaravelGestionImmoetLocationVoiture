<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'description',
        'price',
        'location',
        'category',
        'offer_type',    // INDISPENSABLE pour que la location fonctionne
        'images',        // INDISPENSABLE pour les photos
        'features',
        'status'
    ];

    protected $casts = [
        'images' => 'array',   // Transforme le JSON de la base de données en tableau PHP
        'features' => 'array',
    ];
}