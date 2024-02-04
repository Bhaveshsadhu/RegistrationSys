<?php

namespace App\Models;

// app/Models/User.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'activation_token', 'activated',
        'login_attempts', 'locked_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

