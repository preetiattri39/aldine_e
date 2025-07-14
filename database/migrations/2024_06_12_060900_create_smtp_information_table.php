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
        Schema::create('smtp_information', function (Blueprint $table) {
            $table->id();
            $table->string('from_email');
            $table->string('host');
            $table->string('port');
            $table->string('password');
            $table->string('username');
            $table->string('from_name');
            $table->string('encryption');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp_information');
    }
};
