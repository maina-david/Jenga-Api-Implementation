<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JengaToken extends Model
{
    protected $fillable = [
        'merchant_code',
        'access_token',
        'refresh_token',
        'expires_in',
        'issued_at',
        'token_type',
    ];
}
