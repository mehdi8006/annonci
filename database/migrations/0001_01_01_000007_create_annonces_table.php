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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255);
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->timestamp('date_publication')->useCurrent();
            $table->foreignId('id_utilisateur')->constrained('utilisateurs');
            $table->foreignId('id_ville')->constrained('villes');
            $table->foreignId('id_categorie')->constrained('categories');
            $table->foreignId('id_sous_categorie')->nullable()->constrained('sous_categories');
            $table->enum('statut', ['en_attente', 'validee', 'supprimee'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};