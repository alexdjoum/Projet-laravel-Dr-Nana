<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {

            $table->unsignedInteger('codePro')->unique()->primary();
            $table->string("nomPro", 100);
            $table->decimal("prix", 8, 0, true);
            $table->unsignedInteger('qte');
            $table->string("description", 100);
            $table->string("codeArrivage", 250);
            $table->tinyInteger('actif');

            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories');


            $table->dateTime('dateInsertion');
            $table->decimal("prixAchat", 8, 0, true);
            $table->decimal("pourcentage", 4, 2, true);
            $table->tinyInteger('promo');
            $table->integer('size1');
            $table->integer('size2');
            $table->integer('typeSize');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
