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
        Schema::create('companies', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->unique();

            $table->string('city')->nullablel();
            $table->string('address')->nulable();
            $table->string('website')->nullable();

            $table->text('description')->nullable();
            $table->string('country', 3)->nullablel();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
