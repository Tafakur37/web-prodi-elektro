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
        Schema::table('chats', function (Blueprint $table) {
            $table->boolean('deleted_by_sender')->default(false)->after('is_read');
            $table->boolean('deleted_by_receiver')->default(false)->after('deleted_by_sender');
            $table->boolean('is_deleted_for_everyone')->default(false)->after('deleted_by_receiver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['deleted_by_sender', 'deleted_by_receiver', 'is_deleted_for_everyone']);
        });
    }
};
