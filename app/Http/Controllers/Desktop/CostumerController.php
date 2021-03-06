<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\LegalEntity;
use App\Models\NaturalPerson;
use App\Services\CostumerService;
use App\Services\EditCostumerService;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    public function createLegalEntity(Request $request, CostumerService $costumerService)
    {
        // create costumer on db
        $register = $costumerService->handleCostumerRegister($request, 'le');

        return $register;
    }

    public function createNaturalPerson(Request $request, CostumerService $costumerService)
    {
        $register = $costumerService->handleCostumerRegister($request, 'np');

        return $register;
    }

    public function verifyCostumer(Request $request)
    {
        if(!$request->cnpj){
            $verify = NaturalPerson::where('cpf', $request->cpf)->count();
        } else {
            $verify = LegalEntity::where('cnpj', $request->cnpj)->count();  
        }
        
        if($verify > 0 ){
            return 'error';
        } else {
            return 'go';
        }
    }
    public function listLegalEntities()
    {
        
        $companies = LegalEntity::where('company_type', 'matriz')->get();

        return $companies;
    }

    public function listAllCostumers()
    {
        
        $companies = LegalEntity::get();
        $costumers = [];
        foreach($companies as $company){
            $costumers[] = [
                'c_id'              => $company->c_id,
                'register_number'   => $company->cnpj,
                'company_name'      => $company->company_name,
                'contact'           => $company->contact,
                'zone'              => $company->address[0]->zone,
                'register'          => $company->with(['address', 'payMethod', 'account', 'products', 'observations'])->get()
            ];
        }
        
        $people = NaturalPerson::get();

        foreach($people as $person){
            $costumers[] = [
                'c_id'              => $person->c_id,
                'register_number'   => $person->cpf,
                'company_name'      => $person->company_name,
                'contact'           => $person->name,
                'zone'              => $person->address[0]->zone,
                'register'          => $person->with(['address', 'payMethod', 'account', 'products', 'observations'])->get()
            ];
        }
        return $costumers;
    }

    public function editCostumer(Request $request, EditCostumerService $editCostumerService)
    {
        $company_type = explode('_',$request->params['c_id']);

        $edit = $editCostumerService->handleEditCostumer($request, $request->params['c_id'], $company_type[0]);

        
        return $edit; 
    }

    public function paymentDefinition(Request $request, CostumerService $costumerService)
    {
        $payment = $costumerService->handlePaymentDefinition($request->params);

        return $payment;
    }
}
