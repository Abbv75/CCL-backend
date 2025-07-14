<?php

namespace Database\Seeders;

use App\Models\TypeAbonnement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeAbonnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nom' => 'Pass Argent', 'prix' => 15000],
            ['nom' => 'Pass Or', 'prix' => 20000],
            ['nom' => 'Pass Diaman', 'prix' => 25000],
        ];
        
        foreach ($data as $item) {
            TypeAbonnement::create($item);
        }
    }
}
