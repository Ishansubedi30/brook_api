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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->foreignId('user_id');
            $table->decimal('percentage_read', 5, 2);
            $table->enum('genres', ['Fiction', 'Non-fiction', 'Fantasy', 'Sci-fi', 'Mystery', 'Romance']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
