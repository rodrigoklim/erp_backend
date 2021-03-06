<?php

use App\Models\Products;

function clearMoneyMask($value){
    $valor = explode(' ', $value);
    
    if($valor[0] == 'R$'){
      $resultado = str_replace('.', '', $valor[1]);
      $resultado = str_replace(',', '', $resultado);
      $resultado = str_replace('(', '', $resultado);
      $resultado = str_replace(')', '', $resultado);
      $resultado = str_replace('-', '', $resultado);
      $resultado = str_replace('/', '', $resultado);
      $resultado = str_replace(' ', '', $resultado);
    } else {
      $resultado = str_replace('.', '', $value);
      $resultado = str_replace(',', '', $resultado);
      $resultado = str_replace('(', '', $resultado);
      $resultado = str_replace(')', '', $resultado);
      $resultado = str_replace('-', '', $resultado);
      $resultado = str_replace('/', '', $resultado);
      $resultado = str_replace(' ', '', $resultado);
    }
    
    return $resultado;
  }

  function payComission($state){
    
    $northernStates = [
        'AC' , 'AL', 'AP', 'AM', 'BA','CE', 'MA', 'PA',
        'PB', 'PE', 'PI', 'RN', 'RO', 'RR', 'SE', 'TO'
    ];

    foreach($northernStates as $northernState){
        if($state == $northernState){
            return true;
        }
    }

    return false;
  }

  function priceComparison($product_id, $first, $second){
    
    $max_price = Products::find($product_id);
    return $max_price;
    $second = clearMoneyMask($second);

    $valueB = floatval($second/$max_price);

    if($first === $valueB){
      
      return true;

    } else {

      $response = [
        'status'  => false,
        'price'   => $valueB
      ];
      
      return $response;
    }

  }

  function priceCheck($product_id, $second){
    
    $product = Products::find($product_id);
    $second = clearMoneyMask($second);

    $valueB = ($second/$product->max_price);

    return $valueB;
  }
