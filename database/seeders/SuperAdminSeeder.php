<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    \App\Models\User::create([
        'name' => 'Reddy Super Admin', // Ton nom de gérant
        'email' => 'superadmin@gmail.com', // Ton email de gérant
        'password' => Hash::make('12345678'), // Change ceci !
        'role' => 'superadmin',
        'company_id' => null, // Le gérant n'appartient à aucune entreprise
    ]);
}
}
