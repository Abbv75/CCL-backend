<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 'R01', 'nom' => 'Joueur', 'description' => 'Participant au tournoi'],
            ['id' => 'R02', 'nom' => 'Administrateur', 'description' => 'Gère les tournois'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        }
    }
}
