<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        return [
            'codePro' => $faker->unique()->randomNumber(6, true),
            'nomPro' => $faker->name(),
            'prix' => $faker->randomFloat(0, 0, 9999999),
            'qte' => $faker->randomNumber(4, true),
            'description' => str::limit($faker->paragraph(2), 60),
            'codeArrivage' => str::limit($faker->paragraph(2), 200),

            'actif' => $faker->boolean,
            'dateInsertion' => $faker->dateTimeBetween('-1 year'),
            'prixAchat' => $faker->randomFloat(0, 0, 99999999),
            'pourcentage' => $faker->randomFloat(2, 0, 99),
            'promo' => $faker->boolean,
            'size1' => $faker->randomNumber(3, true),
            'size2' => $faker->randomNumber(3, true),
            'typeSize' => $faker->randomNumber(3, true),
        ];
    }
}
