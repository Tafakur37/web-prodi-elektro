<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->string('name');
            $table->string('file_path');
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();
            $table->softDeletes(); // For Trash feature

            $table->foreign('folder_id')->references('id')->on('berkas_folders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_files');
    }
};
