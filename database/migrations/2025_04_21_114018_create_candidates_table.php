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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');

            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');

            $table->date('birth')->nullable();

            $table->string('city')->nullable();
            $table->string('country', 3)->nullable();

            $table->enum('gender', ['male', 'female'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
