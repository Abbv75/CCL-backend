<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\ProduitImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $boutiques = Boutique::all();

        foreach ($boutiques as $boutique) {
            for ($i = 0; $i < 10; $i++) {
                $prix = $faker->numberBetween(1000, 10000000);
                $produit = Produit::create([
                    'nom' => $faker->word,
                    'prixAchat' => $prix,
                    'prixVenteDetails' => $prix * 1.5,
                    'prixVenteEngros' => $prix * 1.1,
                    'quantite' => $faker->numberBetween(0, 200) * 0,
                    'id_boutique' => $boutique->id,
                    'id_categorie' => Categorie::inRandomOrder()->first()->id,
                ]);
    
                for ($i = 0; $i < 10; $i++) {
                    ProduitImage::create([
                        'file' => 'produit/image/' . rand(0, 1) == 1 ? 'img1.png' : 'img2.jpg',
                        'id_produit' => $produit->id,
                    ]);
                }
            }
        }
    }
}
