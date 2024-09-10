<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bon_achats', function (Blueprint $table) {
            $table->id();
            
            $table->integer("point", 0, 1)->default(0);
            $table->tinyInteger('actif')->default(true);
            
            $table->decimal("montantGlobal", 10, 2, true);

            $table->unsignedBigInteger("facture_id")->nullable();
            $table->foreign("facture_id")->references("id")->on("factures");

            $table->unsignedInteger("client_carte_matr")->nullable();
            $table->foreign("client_carte_matr")->references("matr")->on("client_cartes")->cascadeOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_achats');
    }
};
