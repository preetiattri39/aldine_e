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
        Schema::table('study_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('max_allowed')->default(10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_rooms', function (Blueprint $table) {
            $table->dropColumn('max_allowed');
        });
    }
};
