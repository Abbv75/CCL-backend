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
            [
                'id' => 1,
                'nom' => 'admin',
                'description' => 'Administrateur du système',
            ],
            [
                'id' => 2,
                'nom' => 'propriétaire',
                'description' => 'Propriétaire de boutique',
            ],
            [
                'id' => 3,
                'nom' => 'mobile user',
                'description' => 'Utilisateur mobile',
            ],
            [
                'id' => 4,
                'nom' => 'vendeur',
                'description' => 'Vendeur dans les boutiques',
            ],
            [
                'id' => 5,
                'nom' => 'livreur',
                'description' => 'Livreur de la plateforme',
            ],
            [
                'id' => 6,
                'nom' => 'super admin',
                'description' => 'Super administrateur du système',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
