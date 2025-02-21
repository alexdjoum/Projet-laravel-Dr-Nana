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
        Schema::create('commandes', function (Blueprint $table) {

            $table->id("id");
            $table->decimal("montant", 30, 10, true)->nullable();
            $table->string("nomClient", 30);
            $table->string("mobile", 20);
            $table->text("addresse")->nullable();
            $table->text("commentaire")->nullable();
            $table->tinyInteger('livrer')->default(false);
            $table->decimal("avance", 10, 2, true)->nullable();
            $table->decimal("remise", 10, 2, true)->nullable();
            $table->tinyInteger('type')->default(false);

            $table->unsignedBigInteger("ville_id")->nullable();
            $table->foreign("ville_id")->references("id")->on("villes");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
