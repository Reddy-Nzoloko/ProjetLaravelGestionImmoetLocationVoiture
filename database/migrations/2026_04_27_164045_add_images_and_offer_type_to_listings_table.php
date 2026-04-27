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
        // On ajoute images en format JSON pour stocker le tableau
        $table->json('images')->after('category')->nullable();
        
        // On s'assure que offer_type existe aussi s'il manquait
        if (!Schema::hasColumn('listings', 'offer_type')) {
            $table->string('offer_type')->after('price')->default('vente');
        }
    });
}

public function down(): void
{
    Schema::table('listings', function (Blueprint $table) {
        $table->dropColumn(['images', 'offer_type']);
    });
}
};
