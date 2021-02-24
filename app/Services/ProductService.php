<?php

namespace App\Services;

use App\Models\Products;
use Carbon\Carbon;

class ProductService
{
    public function handleNewProductRegister($data)
    {
        $product = new Products();

        $product->product           = $data['product'];
        $product->category          = $data['category'];
        $product->classification    = $data['classification'];
        $product->unity             = $data['unity'];
        $product->ean               = $data['ean'];
        $product->max_price         = clearMoneyMask($data['price']);
        $product->ncm               = $data['ncm'];
        $product->cest              = $data['cest'];
        $product->csosn             = $data['csosn'];
        $product->operation         = $data['operation'];
        $product->weight            = $data['weight'];

        $load_code                  = $this->handleLoadCode($data);
        $product->load_code         = $load_code;
        
        $product->save();
        return 'ok';
    }

    public function handleEditProduct($data)
    {
        $product = Products::find($data['id']);

        $product->product           = $data['product'];
        $product->category          = $data['category'];
        $product->classification    = $data['classification'];
        $product->unity             = $data['unity'];
        $product->ean               = $data['ean'];
        $product->max_price         = clearMoneyMask($data['max_price']);
        $product->ncm               = $data['ncm'];
        $product->cest              = $data['cest'];
        $product->csosn             = $data['csosn'];
        $product->operation         = $data['operation'];
        $product->weight            = $data['weight'];

        $load_code                  = $this->handleLoadCode($data);
        $product->load_code         = $load_code;
        
        $product->save();
        return $product->id;
    }

    private function handleLoadCode($data){

        switch ($data['category']){
            case 'granel':
            $load_code = "1";
            break;
            case 'fracionado':
            $load_code = "2";
            break;
        }
        
        switch ($data['classification']){
            case 'gas':
            $load_code = $load_code . "1";
            break;
            case 'liquido':
            $load_code = $load_code . "2";
            break;
            case 'embalagem':
            $load_code = $load_code . "3";
            break;
            case 'equipamento':
            $load_code = $load_code . "4";
            break;
        
        }
        
        switch ($data['unity']){
            case 'litros':
            $load_code = $load_code . "1";
            break;
            case 'quilos':
            $load_code = $load_code . "2";
            break;
            case 'm3':
            $load_code = $load_code . "3";
            break;
            case 'carga':
            $load_code = $load_code . "4";
            break;
            case 'unidade':
            $load_code = $load_code . "5";
            break;
        }
        if($load_code > 110 && $load_code < 120){
            $response = 'CT1';
        } else if($load_code > 120 && $load_code < 200 || $load_code == 224){
            $response = 'CT2';
        } else if($load_code > 200){
            $response = 'CF2';
        }
      
          return $response;
      }
}