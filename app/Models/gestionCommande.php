<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class gestionCommande extends Model
{
    use HasFactory;

    protected $fillable = [
        "etat"
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(commande::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
