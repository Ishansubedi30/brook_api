<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'countrycode',
        'mobile_number',
    ];

    // Additional model relationships or methods can be defined here
}