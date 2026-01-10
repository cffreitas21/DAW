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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insere géneros iniciais
        DB::table('genres')->insert([
            ['name' => 'Ação', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aventura', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Animação', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comédia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Crime', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Documentário', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drama', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fantasia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ficção Científica', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guerra', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'História', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Musical', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mistério', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Romance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Terror', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Thriller', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Western', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
