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
        Schema::create('instagram_channels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id'); // Foreign key for the creator
            $table->string('profile_url'); // Stores the Instagram profile URL
            $table->integer('followers'); // Number of followers
            $table->timestamps(); // Adds created_at and updated_at columns

            // Define foreign key constraint (adjust 'creators' to your actual table name if different)
            $table->foreign('creator_id')
                  ->references('id')
                  ->on('users') // Replace with 'users' if referencing a users table
                  ->onDelete('cascade'); // Optional: Delete channels if creator is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_channels');
    }
};