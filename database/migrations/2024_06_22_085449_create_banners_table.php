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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Adding 'title' field of type string
            $table->string('description'); // Adding 'description' field of type string
            $table->string('image'); // Adding 'image' field of type string (for image path)
            $table->boolean('is_active')->default(true); // Adding 'is_active' field of type boolean
            $table->string('created_by'); // Adding 'created_by' field of type string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
