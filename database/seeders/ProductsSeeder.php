<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     /*
    category = granel | fracionado
    classification = gas | liquido | m3 | embalagem | equipament o
    unity = litros | quilos | carga | m3 | unidade 
    operation = venda | comodato | locação | outro
    */

    public function run()
    {
        $product = new Products;
        $product->product = 'NITROGENIO LIQUIDO CARGA';
        $product->category = 'fracionado';
        $product->classification = 'liquido';
        $product->unity = 'carga';
        $product->max_price = '11500';
        $product->ncm = '123123';
        $product->cest = '1231231';
        $product->csosn = '1231231';
        $product->operation = 'venda';
        $product->weight = '123';
        $product->load_code = '1231231';
        $product->save();
    }
}
