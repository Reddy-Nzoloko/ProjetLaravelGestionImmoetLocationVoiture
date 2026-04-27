<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    // Autoriser le remplissage de ces champs
    //protected $fillable = ['name', 'logo', 'whatsapp_number', 'city', 'is_active'];
protected $fillable = [
    'name',
    'activity_sector', 
    'whatsapp_number',
    'city',
    'is_active'
];
    // Une entreprise a plusieurs utilisateurs (Admins/Agents)
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Une entreprise a plusieurs annonces
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
