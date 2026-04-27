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
    Schema::table('listings', function (Blueprint $table) {
        // Ajoute 'location' si elle n'existe pas
        if (!Schema::hasColumn('listings', 'location')) {
            $table->string('location')->nullable()->after('price');
        }
        
        // On vérifie aussi pour 'images' au cas où
        if (!Schema::hasColumn('listings', 'images')) {
            $table->json('images')->nullable()->after('category');
        }
        
        // On vérifie aussi pour 'offer_type'
        if (!Schema::hasColumn('listings', 'offer_type')) {
            $table->string('offer_type')->default('vente')->after('location');
        }
    });
}

public function down(): void
{
    Schema::table('listings', function (Blueprint $table) {
        $table->dropColumn(['location', 'images', 'offer_type']);
    });
}
};
