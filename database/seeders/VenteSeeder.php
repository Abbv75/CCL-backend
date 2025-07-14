<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Produit;
use App\Models\Vente;
use App\Models\VenteProduit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $boutiques = Boutique::all();

        foreach ($boutiques as $boutique) {
            for ($i = 0; $i < 5; $i++) {
                $contact = Contact::create([
                    'telephone' => $faker->phoneNumber,
                    'email' => rand(0, 1) == 0 ? $faker->unique()->email() : null,
                    'address' => rand(0, 1) == 0 ? $faker->address() : null,
                    'whatsapp' => rand(0, 1) == 0 ? $faker->phoneNumber() : null,
                ]);

                $client = Client::create([
                    'nomComplet' => $faker->lastName . ' ' . $faker->firstName,
                    'id_contact' => $contact->id
                ]);

                $vente = Vente::create([
                    'id_boutique' => $boutique->id,
                    'id_client' => $client->id
                ]);

                $montant = 0;

                for ($i = 0; $i < rand(1, 5); $i++) {
                    $produit = Produit::inRandomOrder()->first();

                    VenteProduit::create([
                        'montant' => $produit->prixVenteDetails,
                        'quantite' => rand(1, 15),
                        'id_produit' => $produit->id,
                        'id_vente' => $vente->id
                    ]);

                    $montant += $produit->prixVenteDetails;
                }

                $vente->montant = $montant;
                $vente->save();
            }
        }
    }
}
