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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('isbn');
            $table->string('title');
            $table->string('publisher');
            $table->integer('year');
            $table->string('genre');
            $table->string('cover'); // Un lien vers l'image ?
            $table->string('summary');
            $table->timestamps();
        });

        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('street');
            $table->integer('number');
            $table->timestamps();
        });

        // Table d'association - Écriture
        // Il faut mettre la table A au singulier, underscore la table B au singulier, par ordre alphabétique (ici, 'author_work')
        Schema::create('author_work', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained('authors');
            $table->foreignId('work_id')->constrained('works');
            $table->primary(['author_id', 'work_id']);
            $table->timestamps();
        });

        // Table d'association - Réservation
        Schema::create('user_work', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('work_id')->constrained('works');
            $table->primary(['user_id', 'work_id']);
            $table->timestamps();
        });

        Schema::create('examples', function (Blueprint $table) {
            $table->id();
            $table->string('wear');
            $table->foreignId('library_id')->constrained('libraries');
            $table->foreignId('work_id')->constrained('works');
            $table->timestamps();
        });
        
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->date('due_date');
            $table->boolean('returned');
            $table->timestamps();
            $table->date('date');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('example_id')->constrained('examples');
        });

        Schema::create('review', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('work_id')->constrained('works');
            $table->primary(['user_id', 'work_id']);
            $table->enum('rating', [1, 2, 3, 4, 5]);
            $table->string('comment');
            $table->date('date');
            $table->timestamps();
            
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
}; 