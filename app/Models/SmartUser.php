<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SmartUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'smart_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'birth_date',
        'gender',
        'newsletter',
        'accepted_terms',
        'role', // npr. 'admin' ili 'kupac'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'newsletter' => 'boolean',
        'accepted_terms' => 'boolean',
        'birth_date' => 'date',
    ];
}
