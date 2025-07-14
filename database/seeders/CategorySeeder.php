<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $boutiques = Boutique::all();

        foreach ($boutiques as $boutique) {
            for ($i = 0; $i < 10; $i++) {
                Categorie::create([
                    "nom" => $faker->word,
                    'description' => $faker->sentence,
                    'id_boutique' => $boutique->id,
                ]);
            }
        }
    }
}
