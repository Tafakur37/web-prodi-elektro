<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop old tables to start clean as agreed
        Schema::dropIfExists('files');
        Schema::dropIfExists('folders');

        Schema::create('berkas_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes(); // For Trash feature
            
            $table->foreign('parent_id')->references('id')->on('berkas_folders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_folders');
    }
};
