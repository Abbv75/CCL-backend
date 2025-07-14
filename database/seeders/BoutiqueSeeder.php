<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\Contact;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BoutiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $contact = Contact::create([
                'telephone' => $faker->phoneNumber(),
                'email' => rand(0, 1) == 0 ? $faker->unique()->email() : null,
                'address' => rand(0, 1) == 0 ? $faker->address() : null,
                'whatsapp' => rand(0, 1) == 0 ? $faker->phoneNumber() : null,
            ]);

            $isPartenaire = rand(0, 1) == 1;
            $pourcentageProduit = $isPartenaire ? $faker->randomFloat(2, 0, 100) : null;
            $debutAbonnement = !$isPartenaire ? $faker->dateTimeBetween('-1 year', 'now') : null;
            $finAbonnement = !$isPartenaire ? $faker->dateTimeBetween('now', '+1 year') : null;
            $boutique = Boutique::create([
                'nom' => $faker->name(),
                'image' => null,
                'debutAbonnement' => $debutAbonnement,
                'finAbonnement' => $finAbonnement,
                'isPartenaire' => $isPartenaire,
                'pourcentageProduit' => $pourcentageProduit,
                'id_contact' => $contact->id,
                'id_type_abonnement' => $isPartenaire ? null : rand(1, 3),
            ]);

            Employer::create([
                'id_boutique' => $boutique->id,
                'id_user' => User::where('id_role', 2)->inRandomOrder()->first()->id
            ]);
        }
    }
}
