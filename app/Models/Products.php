<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    /*
    category = granel | fracionado
    classification = gas | liquido | m3 | embalagem | equipamento
    unity = litros | quilos | carga | m3 | unidade 
    operation = venda | comodato | locação | outro
    */
    protected $fillable = [
        'product', 'classification', 'category', 'unity', 'ean', 'max_price', 'ncm', 'cest' , 'csosn', 'operation', 'weight', 'load_code'
    ];
}
