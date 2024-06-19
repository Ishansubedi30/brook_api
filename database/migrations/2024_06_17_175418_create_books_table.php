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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_name');
            $table->string('author');
            $table->date('published_date');
            $table->binary('file'); // blob type
            $table->enum('genres', ['Fiction', 'Non-fiction', 'Fantasy', 'Sci-fi', 'Mystery', 'Romance']); // enum type
            $table->decimal('rating', 3, 1); // Decimal with 3 digits in total and 1 digit after the decimal point
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
