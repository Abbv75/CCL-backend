<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TypeAbonnementSeeder::class,
            BoutiqueSeeder::class,
            EmployerSeeder::class,
            StatuesSeeder::class,
            CategorySeeder::class,
            ProduitSeeder::class,
            VenteSeeder::class,
        ]);
    }
}
