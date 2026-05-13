<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who shared it
            
            $table->morphs('shareable'); // shareable_id, shareable_type (BerkasFolder/BerkasFile)
            
            $table->unsignedBigInteger('shared_with_user_id')->nullable(); // Target user (if specific)
            $table->string('shared_with_role')->nullable(); // Target role (if role-wide)
            
            $table->enum('permission', ['view', 'edit'])->default('view');
            $table->timestamps();
            
            $table->foreign('shared_with_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_shares');
    }
};
