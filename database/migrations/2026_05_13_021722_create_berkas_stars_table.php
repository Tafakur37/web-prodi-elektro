<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas_stars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('starrable'); // starrable_id, starrable_type (BerkasFolder/BerkasFile)
            $table->timestamps();
            
            // A user can only star a specific item once
            $table->unique(['user_id', 'starrable_id', 'starrable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_stars');
    }
};
