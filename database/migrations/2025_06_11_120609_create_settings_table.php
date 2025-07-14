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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('side_name');
            $table->string('logo');
            $table->string('favicon');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('linkedin');
            $table->string('youtube');
            $table->string('twitter');
            $table->string('email');
            $table->string('street');
            $table->string('city');
            $table->string('country');
            $table->string('phone')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
