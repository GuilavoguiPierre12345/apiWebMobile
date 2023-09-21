<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Produit::create([
            'designation'=>'Ordinateur HP',
            'prix'=>10000,
            'qte'=>10000,
            'lienImage'=>'monImage',
            'status'=>true,
            'categorie_id'=>'2',
        ]);
        Produit::create([
            'designation'=>'Ordinateur mac',
            'prix'=>10000,
            'qte'=>10000,
            'lienImage'=>'monImage',
            'status'=>true,
            'categorie_id'=>'2'
        ]);
        Produit::create([
            'designation'=>'tablette mac',
            'prix'=>10000,
            'qte'=>10000,
            'lienImage'=>'monImage',
            'status'=>true,
            'categorie_id'=>'2'
        ]);
    }
}
