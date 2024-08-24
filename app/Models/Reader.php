<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Reader extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'countrycode',
        'mobile_number',
    ];

    protected $hidden = [
        'password', // Hide the password field when serializing the model
    ];

    public function getAuthIdentifierName()
    {
        return 'username'; // Use 'username' as the authentication identifier
    }

    // Additional model relationships or methods can be defined here
}
