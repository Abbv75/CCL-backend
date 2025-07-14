<?php

namespace Database\Seeders;

use Faker\Factory as Faker;

use App\Models\Boutique;
use App\Models\Contact;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $boutiques = Boutique::all();
        foreach ($boutiques as $boutique) {
            $i = 0;
            while($i++ < 10) {
                $contact = Contact::create([
                    'telephone' => $faker->phoneNumber,
                    'email' => rand(0, 1) == 0 ? $faker->unique()->email() : null,
                    'address' => rand(0, 1) == 0 ? $faker->address() : null,
                    'whatsapp' => rand(0, 1) == 0 ? $faker->phoneNumber() : null,
                ]);

                $user = User::create([
                    'nomComplet' => $faker->name,
                    'login' => $faker->unique()->userName(),
                    'password' => bcrypt(12345678),
                    'id_role' => rand(4, 5),
                    'id_contact' => $contact->id,
                ]);

                Employer::create([
                    'id_user' => $user->id,
                    'id_boutique' => $boutique->id,
                ]);
            }
        }
    }
}
