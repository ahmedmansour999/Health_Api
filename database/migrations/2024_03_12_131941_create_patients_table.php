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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('gender');
            $table->string('age');
            $table->string('bloodgroup')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->string('disease')->nullable();
            $table->string('doctor')->nullable();
            $table->string('admit_date')->nullable();
            $table->string('discharge_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
