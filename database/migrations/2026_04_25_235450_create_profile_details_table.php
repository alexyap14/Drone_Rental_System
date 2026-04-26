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
        Schema::create('profile_details', function (Blueprint $table) {
            $table->id();
        
            $table->string('full_name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('gender')->nullable();
            $table->string('race')->nullable();
            $table->string('religion')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_details');
    }
};