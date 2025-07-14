<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\Statue;
use Illuminate\Database\Seeder;

class StatuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boutiques = Boutique::all();

        foreach ($boutiques as $boutique) {
            for ($i = 0; $i < 10; $i++) {
                Statue::create([
                    "media" => 'statues/' . rand(0, 1) == 1 ? 'img1.png' : 'img2.jpg',
                    'typeMedia' => 'img',
                    'delais' => rand(1, 72),
                    'id_boutique' => $boutique->id,
                ]);
            }
        }
    }
}
