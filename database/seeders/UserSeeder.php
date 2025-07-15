<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $contact = Contact::create([
            'id' => (string) Str::uuid(),
            'telephone' => $faker->phoneNumber(),
            'email' => 'bore.younous59@gmail.com',
            'adresse' => $faker->optional(0.8)->address(),
            'whatsapp' => $faker->optional(0.8)->e164PhoneNumber(),
        ]);

        User::create([
            'id' => (string) Str::uuid(),
            'nomComplet' => 'Administrateur Principal',
            'login' => 'admin',
            'motDePasse' => bcrypt('admin123'),
            'idCOD' => null,
            'id_role' => 'R02',
            'id_contact' => $contact->id,
        ]);

        for ($i = 1; $i <= 50; $i++) {
            $contact = Contact::create([
                'id' => (string) Str::uuid(),
                'telephone' => $faker->phoneNumber(),
                'email' => $faker->optional(0.5)->unique()->safeEmail(),
                'adresse' => $faker->optional(0.5)->address(),
                'whatsapp' => $faker->optional(0.5)->e164PhoneNumber(),
            ]);

            User::create([
                'id' => (string) Str::uuid(),
                'nomComplet' => $faker->name(),
                'login' => $faker->unique()->userName(),
                'motDePasse' => bcrypt('player123'),
                'idCOD' => strtoupper(Str::random(8)),
                'id_role' => 'R01',
                'id_contact' => $contact->id,
            ]);
        }
    }
}
