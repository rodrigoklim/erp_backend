<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Address;
use App\Models\CostumerProducts;
use App\Models\LegalEntity;
use App\Models\NaturalPerson;
use App\Models\PaymentMethod;
use App\Models\Products;
use Carbon\Carbon;

class EditCostumerService
{
    public function handleEditCostumer($data, $c_id, $company_type)
    {
        
        if($company_type === 'np'){
            $company = NaturalPerson::where('c_id', $c_id)->first();
        } else {
            $company = LegalEntity::where('c_id', $c_id)->first();
        }

        if(isset($data->params['form']['form'])){
            $editRegister   = $this->handleEditCostumerRegister($company, $data->params['form']['form'], $company_type);
        }

        if(isset($data->params['form']['address']) && count($data->params['form']['address']) > 0 ){
            $editAddress    = $this->handleEditCostumerAddress($data->params['form']['address'], $c_id);
        }

        if(isset($data->params['form']['payment']) && count($data->params['form']['payment']) > 0 ){
            return 'ok';
            $editPayment    = $this->handleEditCostumerPayment($data->params['form']['payment'], $c_id);
        }
        
        if(isset($data->params['form']['products']) && count($data->params['form']['products']) > 0 ){
            $editProducts   = $this->handleEditCostumerProducts($data->params['form']['products'], $c_id);
        }
        
        return $editRegister;
    }

    private function handleEditCostumerRegister($company, $data, $cType)
    {
        $company->company_name  = $data['company_name'];

        if($cType === 'le'){
            $company->company_type  = $data['company_type'];
        }

        $company->contact       = $data['contact'];
        $company->email         = collect($data['email'])->implode('; ');

        $phones = $data['phones'];
        $total = count($phones);

        $company->phone_1    = '';
        $company->phone_1zap = '';
        $company->phone_2    = '';
        $company->phone_2zap = '';
        $company->phone_3    = '';
        $company->phone_3zap = '';
        $company->phone_4    = '';
        $company->phone_4zap = '';
        $company->phone_5    = '';
        $company->phone_5zap = '';

        for($i=1; $i <= $total; $i++){
            
            switch($i){
                case '1':
                    $company->phone_1    = $phones[0]['phone'];
                    $company->phone_1zap = $phones[0]['whats'];
                break;
    
                case '2':
                    $company->phone_2    = $phones[1]['phone'];
                    $company->phone_2zap = $phones[1]['whats'];
                break;
    
                case '3':
                    $company->phone_3    = $phones[2]['phone'];
                    $company->phone_3zap = $phones[2]['whats'];
                break;
    
                case '4':
                    $company->phone_4    = $phones[3]['phone'];
                    $company->phone_4zap = $phones[3]['whats'];
                break;
    
                case '5':
                    $company->phone_5    = $phones[4]['phone'];
                    $company->phone_5zap = $phones[4]['whats'];
                break;
            }
        }
        
        $company->save();

        return 'ok';
    }

    private function handleEditCostumerAddress($data, $c_id)
    {
        $delete = Address::where('c_id', $c_id)->delete();
        
        foreach($data as $newAddress){
            $address = new Address;
                
            $address->c_id              = $c_id;
            $address->street            = $newAddress['street'];
            $address->number            = $newAddress['number'];
            $address->complement        = $newAddress['complement'];
            $address->district          = $newAddress['district'];
            $address->city              = $newAddress['city'];
            $address->city_code         = $newAddress['city_code'];
            $address->state             = $newAddress['state'];

            if(isset($newAddress['zip_code'])){
                $address->zip_code          = $newAddress['zip_code'];
                $address->preference_period = $newAddress['preference_period'];
            } else {
                $address->zip_code          = $newAddress['zipCode'];
                $address->preference_period = $newAddress['deliveryPeriod'];
            }
            
            $address->zone              = $newAddress['zone'];
            $address->latitude          = $newAddress['latitude'];
            $address->longitude         = $newAddress['longitude'];

            $address->save();
            
        }


        return $address;
    }

    private function handleEditCostumerPayment($data, $c_id)
    {
        $delete = PaymentMethod::where('c_id', $c_id)->delete();

        $pay = new PaymentMethod;
        $pay->c_id = $c_id;

        switch($data['term']){
            case 'anticipated':
                $pay->payment_code          = 1;
                $pay->account               = $data['account'];
                $pay->payment_description   = 'ANTECIPADO | TRANSFERÊNCIA';
            break;

            case 'cashPay':
                switch($data['method']){
                    case 'cash':
                        $pay->payment_code          = 21;
                        $pay->payment_description   = 'À VISTA | DINHEIRO';
                    break;

                    case 'check':
                        $pay->payment_code          = 22;
                        $pay->payment_description   = 'À VISTA | CHEQUE';
                    break;

                    case 'debitCard':
                        $pay->payment_code          = 23;
                        $pay->payment_description   = 'À VISTA | CARTÃO DE DÉBITO';
                    break;

                    case 'creditCard':
                        $pay->payment_code          = 24;
                        $pay->payment_description   = 'À VISTA | CARTÃO DE CRÉDITO';
                    break;
                }
            break;

            case 'credit':
                switch($data['method']){
                    case 'bankSlip':
                        $pay->payment_code          = 31;
                        $pay->term                  =  collect($data['methodTerm'])->implode(',');
                        $pay->payment_description   = 'Boleto a prazo';
                        $pay->payment_description   = 'À PRAZO | BOLETO BANCÁRIO';
                    break;

                    case 'check':
                        $pay->payment_code          = 32;
                        $pay->term                  =  collect($data['methodTerm'])->implode(',');
                        $pay->payment_description   = 'À PRAZO | CHEQUE';
                    break;

                    case 'bankTransfer':
                        $pay->payment_code  = 33;
                        $pay->term          = collect($data['methodTerm'])->implode(',');
                        $pay->account       = $data['account'];
                        $pay->contract      = $data['contract'];
                        $pay->payment_description   = 'À PRAZO | TRANSFERÊNCIA';
                    break;
                    
                    case 'monthlyPayment':
                        $pay->payment_code  = 34;
                        $pay->close_date    = $data['account'];
                        $pay->payment_date  = $data['contract'];
                        $pay->payment_description   = 'À PRAZO | PÓS-PAGO';
                    break;
                }
            break;
        }
        
        $pay->save();

        return $pay;
    }

    private function handleEditCostumerProducts($data, $c_id)
    {
        foreacH($data as $product){
            $newProduct = new CostumerProducts;

            // find percentage value to register
            $price = clearMoneyMask($product['price']);
            $max_price = Products::find($product['id']);
            $max_price = intval($max_price->max_price);

            $value = $price/$max_price;

            $newProduct->c_id           = $c_id;
            $newProduct->products_id    = $product['id'];
            $newProduct->price          = $value;
            $newProduct->interval       = $product['interval'];
            $newProduct->exact_day      = $product['exactDay'];

            $newProduct->save();

        }

        if($newProduct->id){
            return $newProduct;
        } else {
            return 'error';
        }
    }
}