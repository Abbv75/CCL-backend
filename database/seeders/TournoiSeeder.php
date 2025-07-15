<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Tournoi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TournoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            Tournoi::create([
                'id' => (string) Str::uuid(),
                'nom' => 'Tournoi ' . ucfirst($faker->word()) . ' ' . now()->addDays($i)->format('F Y'),
                'description' => $faker->sentence(10),
                'date_debut' => now()->addDays(rand(1, 60)),
                'frais_inscription' => $faker->numberBetween(0, 5000),
                'montant_a_gagner' => $faker->numberBetween(5000, 50000),
                'nb_max_participants' => $faker->randomElement([50, 100, 150, 200]),
                'id_status' => $faker->randomElement(Status::inRandomOrder()->first()->id),
            ]);
        }
    }
}
