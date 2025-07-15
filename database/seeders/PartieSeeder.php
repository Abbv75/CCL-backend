<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partie;
use App\Models\Tournoi;
use App\Models\User;
use App\Models\PartieUser;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PartieSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        $tournois = Tournoi::all();

        $joueurs = User::where('id_role', 'R01')->pluck('id')->toArray();

        foreach ($tournois as $tournoi) {
            $nbParties = rand(1, 5);

            for ($i = 1; $i <= $nbParties; $i++) {
                $partie = Partie::create([
                    'id' => (string) Str::uuid(),
                    'id_tournoi' => $tournoi->id,
                    'id_status' => $faker->randomElement(['S01', 'S02', 'S03']), // en attente, actif, terminé
                ]);

                $participantsIds = $faker->randomElements($joueurs, rand(3, 30));

                foreach ($participantsIds as $participantId) {
                    PartieUser::create([
                        'id' => (string) Str::uuid(),
                        'id_partie' => $partie->id,
                        'id_user' => $participantId,
                    ]);
                }

                $partie->id_gagnant = $faker->optional(0.5)->randomElement($participantsIds);
                $partie->save();
            }
        }
    }
}
