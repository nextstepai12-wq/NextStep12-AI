<?php
// app/Models/PasswordResetCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetCode extends Model
{
    protected $fillable = [
        'email', 'code', 'token', 'code_expires_at', 'token_expires_at', 'verified_at',
    ];

    protected $casts = [
        'code_expires_at'  => 'datetime',
        'token_expires_at' => 'datetime',
        'verified_at'      => 'datetime',
    ];
}
