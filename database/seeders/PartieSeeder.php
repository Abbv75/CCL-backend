<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partie;
use App\Models\Tournoi;
use App\Models\PartieUser;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PartieSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        $tournois = Tournoi::with('participants')->get();

        foreach ($tournois as $tournoi) {
            $participantIds = $tournoi->participants->pluck('id')->toArray();

            if (empty($participantIds)) {
                continue;
            }

            $nbParties = rand(1, 5);

            for ($i = 1; $i <= $nbParties; $i++) {
                $partie = Partie::create([
                    'id' => (string) Str::uuid(),
                    'dateHeure' => now()->addDays(rand(0, 7)),
                    'id_tournoi' => $tournoi->id,
                    'id_status' => $faker->randomElement(['S01', 'S02', 'S03']), // adapte à tes status réels
                ]);

                $participants = $faker->randomElements($participantIds, min(rand(3, 30), count($participantIds)));

                foreach ($participants as $participantId) {
                    PartieUser::create([
                        'id' => (string) Str::uuid(),
                        'id_partie' => $partie->id,
                        'id_user' => $participantId,
                    ]);
                }

                $partie->id_gagnant = $faker->optional(0.5)->randomElement($participants);
                $partie->save();
            }
        }
    }
}
