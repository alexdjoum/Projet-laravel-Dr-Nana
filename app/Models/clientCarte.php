<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientCarte extends Model
{
    use HasFactory;

    protected $primaryKey = 'matr';
    protected $keyType = 'unsignedInteger';
    protected $casts = [
        'matr' => 'int',
    ];
}
