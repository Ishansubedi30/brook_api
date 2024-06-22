<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_if',
        'is_active',
        'file', // Assuming you're storing file path or blob in another way
        'created_at',
        'updated_at',
    ];

    // Additional model relationships or methods can be defined here
}
