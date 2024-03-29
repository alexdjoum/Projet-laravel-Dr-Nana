<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class produit extends Model
{
    use HasFactory;

    protected $primaryKey = 'codePro';
    protected $keyType = 'unsignedInteger';

    protected $casts = [
        'codePro' => 'int',
    ];

    protected $with = [
        'photos'
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(categorie::class);
    }


    public function photos(): HasMany
    {
        return $this->hasMany(photo::class);
    }



}
