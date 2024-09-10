<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'nomClient',
        'mobile',
        "addresse",
        "commentaire",
        "avance",
        "remise",
        "ville_id",
        'type',
        'livrer',
        'montantLivraison'
    ];

    protected $with = [
        'ligneCommandes'
    ];

    public function ligneCommandes(): HasMany
    {
        return $this->hasMany(ligneCommande::class);
    }
    public function ville(): BelongsTo
    {
        return $this->belongsTo(ville::class);
    }
    public function facture(): HasOne
    {
        return $this->hasOne(facture::class);
    }
    public function clientCarte(): BelongsTo
    {
        return $this->belongsTo(clientCarte::class);
    }
    public function gestionCommandes(): HasMany
    {
        return $this->HasMany(gestionCommande::class);
    }
}
