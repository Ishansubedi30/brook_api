<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'percentage_read',
        'genres',
    ];

    // Additional model relationships or methods can be defined here
}
