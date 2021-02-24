<?php

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