<?php

namespace App\Services;

use App\Models\Address;
use App\Models\CostumerProducts;
use App\Models\OrderObservation;
use App\Models\PaymentMethod;
use App\Models\PreSell;
use App\Models\PreSellMessageCenter;
use App\Models\PreSellProduct;
use Illuminate\Support\Facades\Auth;

class PreSellService
{
    public function handleObservationRegister($data)
    {
        $obs = new OrderObservation();

        $obs->c_id          = $data['c_id'];
        $obs->title         = $data['title'];
        $obs->destination   = $data['destination']['value'];
        $obs->observation   = $data['observation'];

        $obs->save();

        if($obs->id){
            return 'ok';
        } else {
            return 'error';
        }

    }

    public function handlePreSellRegister($data)
    {
        $presell = new PreSell();

        $presell->c_id              = $data['c_id'];
        $presell->invoice_option    = $data['nf'];
        $presell->invoice_obs       = $data['observation'][0]['invoice'];
        $presell->driver_obs        = $data['observation'][0]['driver'];
        $presell->pay_code          = $data['payment']['payment_code'];
        
        if(!$data['payment']['term']){
            $presell->pay_term          = 1;    
        } else {
            $presell->pay_term          = $data['payment']['term'];
        }
        
        if($data['payment']['contract']){
            $presell->pay_contract          = $data['payment']['contract'];
        }
        
        if($data['observation'][0]['commitment']){
            $presell->pay_commitment_number = $data['observation'][0]['commitment'];
        }
        
        // retrieving zone information from address
        $address = Address::find($data['addressId']);
        
        $presell->zone              = $address->zone;
        $presell->delivery_address  = $address->id;
        $presell->delivery_period   = $data['deliveryPeriod'];
        $presell->delivery_date     = $data['deliveryDate'];

        
        $presell->authorization     = 0;
        $presell->status            = 0;
        
        $presell->save();
        
        if($presell->id){
            $pay_check = $this->handlePreSellPaymentMethodVerification($presell);
            $product_check = $this->handlePreSellProductsVerification($data['products'],$presell->c_id, $presell->id);

            
            if($pay_check === 'ok' && $product_check === 'ok'){
                return 'ok';
            } else {
                return 'error';
            }
        
        } else {
        
            return 'error';
        
        }
    }

    private function handlePreSellPaymentMethodVerification($presell)
    {
         // verify if pay_method choosen is the same as recorded at costumer register

         $pay_code = PaymentMethod::where('c_id', $presell->c_id)->where('payment_code', $presell->pay_code)->count();

         if($pay_code > 0) {
             $presell->authorization = 1;

             return 'ok';

         } else {
             $presell->authorization = 0;
 
             $message = new PreSellMessageCenter();
 
             $message->presell_id    = $presell->id;
             $message->user          = Auth::user()->name;
             $message->message       = 'DIVERGÊNCIA COM FORMA DE PAGAMENTO CADASTRADA';
             $message->status        = 0;
             
             $message->save();

             if($message->id){
                 return 'ok';
             } else {
                 return 'error';
             }
             
         }
 
    }

    private function handlePreSellProductsVerification($data, $c_id, $presell_id)
    {
        
       
        foreach($data as $item){
            
            // check product costumer register
            $product = CostumerProducts::where('c_id', $c_id)->where('products_id', $item['id'])->get();
            
            if($product->count() > 0) {
                // verify price option
                $comparison = priceComparison($item['id'], $product[0]->price, $item['price']);
               
                if($comparison !== true){

                    // send message to admin
                    $message = new PreSellMessageCenter();
 
                    $message->presell_id    = $presell_id;
                    $message->user          = Auth::user()->name;
                    $message->message       = 'DIVERGÊNCIA NO PREÇO DE PRODUTO DA PRÉ-VENDA';
                    $message->status        = 0;
                    
                    $message->save();
                }
            } else {
                 // send message to admin
                 $message = new PreSellMessageCenter();
                
                 $message->presell_id    = $presell_id;
                 $message->user          = Auth::user()->name;
                 $message->message       = 'PRODUTO NÃO CADASTRADO NO CLIENTE';
                 $message->status        = 0;
                 
                 $message->save();
                 
            }
            
             // store product data
                
             $presellProduct = new PreSellProduct();

             $presellProduct->presell_id = $presell_id;
             
             $presellProduct->product_id = $item['id'];
             
             $presellProduct->product_price      = priceCheck($item['id'], $item['price']);
             
             $presellProduct->save();
 
        }

        if($presellProduct->id){
            return 'ok';
        } else {
            return 'error';
        }
    }
}