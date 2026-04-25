<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'company_id', 'user_id', 'title', 'description', 
        'price', 'category', 'offer_type', 'features', 'status'
    ];

    // Pour que le champ 'features' (JSON) soit automatiquement transformé en tableau PHP
    protected $casts = [
        'features' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
