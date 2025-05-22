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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_annonce')->constrained('annonces')->onDelete('cascade');
            $table->foreignId('id_utilisateur')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->enum('type', [
                'fraude', 
                'contenu_inapproprie', 
                'produit_interdit', 
                'doublon', 
                'mauvaise_categorie', 
                'autre'
            ]);
            $table->text('description')->nullable();
            $table->enum('statut', ['en_attente', 'traitee', 'rejetee'])->default('en_attente');
            $table->timestamp('date_traitement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};