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

class CostumerService
{
    public function handleCostumerRegister($data, $costumer)
    {
       if($costumer === 'le'){
       
            $company = $this->handleLegalEntityRegister($data->params['form']);    

            if($data->params['form']['company_type'] === 'matriz'){
                        
            }    
            
            if($company !== 'erro'){
                $products   = $this->handleCostumerProductsRegister($data->params['products'], $company->c_id);
                $address    = $this->handleAddressRegister($data->params['address'], $company->c_id);

                if($data->params['form']['company_type'] === 'matriz'){
                    $payment    = $this->handlePaymentRegister($data->params['payment'], $company->c_id);        
                } 
                
                $account    = $this->handleAccountRegister($data->params['form'], $company->c_id, $payment, $address);

                return 'ok';

                if($products <> 'error' && $address <> 'error' && $payment <> 'error' && $account <> 'error' ){
                    
                    return 'ok';

                } else {

                    if($products !== 'error'){
                        $products->delete();
                    }

                    if($address !== 'error'){
                        $address->delete();
                    }

                    if($payment !== 'error'){
                        $payment->delete();
                    }
                    
                    if($account !== 'error'){
                        $account->delete();
                    }                    
                    
                    $company->delete();

                    return 'error';
                } 
            } else {
                return 'error';
            }
       
        } else {
       
            $naturalPerson =  $this->handleNaturalPersonregister($data->params['form']);

            if($naturalPerson !== 'erro'){
                $products   = $this->handleCostumerProductsRegister($data->params['products'], $naturalPerson->c_id);
                $address    = $this->handleAddressRegister($data->params['address'], $naturalPerson->c_id);
                $payment    = $this->handlePaymentRegister($data->params['payment'], $naturalPerson->c_id);
                $account    = $this->handleAccountRegister($data->params['form'], $naturalPerson->c_id, $payment, $address);

                return 'ok';

                if($products <> 'error' && $address <> 'error' && $payment <> 'error' && $account <> 'error' ){
                    return 'ok';
                } else {
                    if($products !== 'error'){
                        $products->delete();
                    }

                    if($address !== 'error'){
                        $address->delete();
                    }

                    if($payment !== 'error'){
                        $payment->delete();
                    }
                    
                    if($account !== 'error'){
                        $account->delete();
                    }                    
                    
                    $naturalPerson->delete();

                    return 'error';
                } 
            } else {
                return 'error';
            }
        }
    }

    public function handlePaymentDefinition($data)
    {
        $pay = [];
        switch($data['term']){
            case 'anticipated':
                $pay['payment_code']                    = 1;
                $pay['account']                         = $data['account'];
                $pay['payment_description']             = 'ANTECIPADO | TRANSFERÊNCIA';
            break;

            case 'cashPay':
                switch($data['method']){
                    case 'cash':
                        $pay['payment_code']            = 21;
                        $pay['payment_description']     = 'À VISTA | DINHEIRO';
                    break;

                    case 'check':
                        $pay['payment_code']            = 22;
                        $pay['payment_description']     = 'À VISTA | CHEQUE';
                    break;

                    case 'debitCard':
                        $pay['payment_code']            = 23;
                        $pay['payment_description']     = 'À VISTA | CARTÃO DE DÉBITO';
                    break;

                    case 'creditCard':
                        $pay['payment_code']            = 24;
                        $pay['payment_description']     = 'À VISTA | CARTÃO DE CRÉDITO';
                    break;
                }
            break;

            case 'credit':
                switch($data['method']){
                    case 'bankSlip':
                        $pay['payment_code']            = 31;
                        $pay['term']                    =  collect($data['methodTerm'])->implode(',');
                        $pay['payment_description']     = 'À PRAZO | BOLETO BANCÁRIO';
                    break;

                    case 'check':
                        $pay['payment_code']            = 32;
                        $pay['term']                    = collect($data['methodTerm'])->implode(',');
                        $pay['payment_description']     = 'À PRAZO | CHEQUE';
                    break;

                    case 'bankTransfer':
                        $pay['payment_code']            = 33;
                        $pay['term']                    = collect($data['methodTerm'])->implode(',');
                        $pay['account']                 = $data['account'];
                        $pay['contract']                = $data['contract'];
                        $pay['payment_description']     = 'À PRAZO | TRANSFERÊNCIA';
                    break;
                    
                    case 'monthlyPayment':
                        $pay['payment_code']            = 34;
                        $pay['close_date']              = $data['account'];
                        $pay['payment_date']            = $data['contract'];
                        $pay['payment_description']     = 'À PRAZO | PÓS-PAGO';
                    break;
                }
            break;
        }
        
        return $pay;
    }

    private function handleNaturalPersonregister($data)
    {
        $person = new NaturalPerson();

        $person->cpf                    = $data['cpf'];
        $person->name                   = $data['name'];
        $person->birthdate              = Carbon::createFromFormat('d/m/Y',$data['birthdate']);
        $person->company_name           = $data['company_name'];
        $person->register_situation     = $data['register_situation'];
        $person->email                  = collect($data['email'])->implode('; ');
        $person->main_activity          = $data['main_activity'];

        $phones = $data['phones'];
        $total = count($phones);

        for($i=1; $i <= $total; $i++){
            if(count($phones[$i -1]) === 2){
                switch($i){
                    case '1':
                        $person->phone_1    = $phones[0]['phone'];
                        $person->phone_1zap = $phones[0]['whats'];
                    break;
        
                    case '2':
                        $person->phone_2    = $phones[1]['phone'];
                        $person->phone_2zap =$phones[1]['whats'];
                    break;
        
                    case '3':
                        $person->phone_3    = $phones[2]['phone'];
                        $person->phone_3zap = $phones[2]['whats'];
                    break;
        
                    case '4':
                        $person->phone_4    = $phones[3]['phone'];
                        $person->phone_4zap = $phones[3]['whats'];
                    break;
        
                    case '5':
                        $person->phone_5    = $phones[4]['phone'];
                        $person->phone_5zap = $phones[4]['whats'];
                    break;
                }
            }
        }
        
        $person->save();
        $person->c_id = 'np_' . $person->id;
        
        $person->save();
        
        if($person->id){
            return $person;
        } else {
            return 'error';
        }
    }
    
    private function handleLegalEntityRegister($data)
    {
        $company = new LegalEntity();
        $company->cnpj                  = $data['cnpj'];
        $company->ie                    = $data['ie'];
        $company->company_name          = $data['company_name'];
        $company->corporate_name        = $data['corporate_name'];
        $company->register_situation    = $data['register_situation'];
        $company->company_type          = $data['company_type'];
        $company->main_activity         = $data['main_activity'];
        $company->contact               = $data['contact'];
        $company->email                 = collect($data['email'])->implode('; ');

        $phones = $data['phone'];
        $total = count($phones);

        for($i=1; $i <= $total; $i++){
            if(count($phones[$i -1]) === 2){
                switch($i){
                    case '1':
                        $company->phone_1 = $phones[0]['phone'];
                        $company->phone_1zap = $phones[0]['whats'];
                    break;
        
                    case '2':
                        $company->phone_2 = $phones[1]['phone'];
                        $company->phone_2zap = $phones[1]['whats'];
                    break;
        
                    case '3':
                        $company->phone_3 = $phones[2]['phone'];
                        $company->phone_3zap = $phones[2]['whats'];
                    break;
        
                    case '4':
                        $company->phone_4 = $phones[3]['phone'];
                        $company->phone_4zap = $phones[3]['whats'];
                    break;
        
                    case '5':
                        $company->phone_5 = $phones[4]['phone'];
                        $company->phone_5zap = $phones[4]['whats'];
                    break;
                }
            }
        }
        
        $company->save();

        // insert costumer id = c_id and parent_id if company_type == 'filial'
        $company->c_id = 'le_' . $company->id;
        
        if($company->company_type == 'filial'){
            $company->parent_id = $data['parent_id'];
        }
        $company->save();

        if($company->id){
            return $company;
        } else {
            return 'error';
        }
    }
    
    private function handlePaymentRegister($data, $c_id)
    {
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

        if($pay->id){
            return $pay;
        } else {
            return 'error';
        }
    }

    private function handleAddressRegister($data, $c_id)
    {
        if($data[1]['street'] === null){
            $total = 1;
        } else {
            $total = 2;
        }
        
        for($i=0; $i < $total; $i++){
            $address = new Address;
            
            $address->c_id              = $c_id;
            $address->street            = $data[$i]['street'];
            $address->number            = $data[$i]['number'];
            $address->complement        = $data[$i]['complement'];
            $address->district          = $data[$i]['district'];
            $address->city              = $data[$i]['city'];
            $address->city_code         = $data[$i]['city_code'];
            $address->state             = $data[$i]['state'];
            $address->zip_code          = $data[$i]['zipCode'];
            $address->zone              = $data[$i]['zone'];
            $address->preference_period = $data[$i]['deliveryPeriod'];
            $address->latitude          = $data[$i]['latitude'];
            $address->longitude         = $data[$i]['longitude'];

            $address->save();

        }
        
        if($address->id){
            return $address;
        } else {
            return 'error';
        }
    }

    private function handleCostumerProductsRegister($data, $c_id)
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
            
            if($product['interval'] !== '-'){
                $newProduct->interval       = $product['interval'];
            }
            
            if($product['exactDay'] !== '-'){
                $newProduct->exact_day      = $product['exactDay'];
            }
            
            $newProduct->save();

        }

        if($newProduct->id){
            return $newProduct;
        } else {
            return 'error';
        }
    }


    private function handleAccountRegister($form, $c_id, $payment, $state)
    {
        $account = new Account();
        
        $account->c_id = $c_id;
        $account->nf = $form['nf'];
        $account->payment_method = $payment->payment_code;
        $account->sales_comission = payComission($state);

        $account->save();

        if($account->id){
            return $account;
        } else {
            return 'error';
        }
        
    }
}