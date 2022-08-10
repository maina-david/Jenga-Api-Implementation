<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JengaAccount extends Model
{
    protected $fillable = [
        'merchant_code',
        'consumer_secret',
        'api_key',
        'active',
    ];
}
