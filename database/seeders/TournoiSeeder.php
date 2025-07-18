<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Tournoi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TournoiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        $joueurs = User::where('id_role', 'R01')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $idSatut = Status::inRandomOrder()->first()->id;

            $tournoi = Tournoi::create([
                'id' => (string) Str::uuid(),
                'nom' => 'Tournoi ' . ucfirst($faker->word()) . ' ' . now()->addDays($i)->format('F Y'),
                'date_debut' => now()->addDays(rand(1, 60)),
                'frais_inscription' => $faker->numberBetween(0, 5000),
                'montant_a_gagner' => $faker->numberBetween(5000, 50000),
                'nb_max_participants' => $faker->numberBetween(10, 100),
                'id_status' => $idSatut,
            ]);

            $participants = $faker->randomElements($joueurs, rand(10, 30));

            foreach ($participants as $index => $participantId) {
                $tournoi->participants()->attach($participantId, [
                    'id' => (string) Str::uuid(),
                ]);

                if ($index == 0 && $idSatut == 'S03') {
                    $tournoi->id_gagnant = $participantId;
                    $tournoi->save();
                }
            }
        }
    }
}
