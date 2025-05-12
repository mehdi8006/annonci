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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('email', 100)->unique();
            $table->string('telephon', 20);
            $table->string('password', 255);
            $table->string('ville', 100);
            $table->enum('type_utilisateur', ['admin', 'normal'])->default('normal');
            $table->enum('statut', ['en_attente', 'valide', 'supprime'])->default('en_attente');
            $table->timestamp('date_inscription')->useCurrent();
            $table->rememberToken()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};