<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name');  // Nom de l'agence
        $table->string('logo')->nullable(); // URL ou chemin du logo
        $table->string('whatsapp_number'); // Le numéro central pour les boutons
        $table->string('city'); // Goma, Bukavu, etc.
        $table->boolean('is_active')->default(true); // Contrôle du SuperAdmin
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
