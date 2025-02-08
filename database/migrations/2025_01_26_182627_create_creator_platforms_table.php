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
        Schema::create('creator_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id'); // Foreign key to creators table
            $table->string('platforms_ids')->nullable(); // Comma-separated platform IDs
            $table->timestamps();

            // Add foreign key constraints if needed
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_platforms');
    }
};
