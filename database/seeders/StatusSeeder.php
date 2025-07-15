<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'id' => 'S01',
                'nom' => 'En attente',
                'description' => 'En cours de préparation',
            ],
            [
                'id' => 'S02',
                'nom' => 'Actif',
                'description' => 'Tournoi ou partie en cours',
            ],
            [
                'id' => 'S03',
                'nom' => 'Terminé',
                'description' => 'Tournoi ou partie terminé',
            ],
            [
                'id' => 'S04',
                'nom' => 'Annulé',
                'description' => 'Tournoi ou partie annulé',
            ],
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate($status);
        }
    }
}
