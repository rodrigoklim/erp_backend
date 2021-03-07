<?php

namespace App\Services;

use App\Models\CostumerProducts;
use App\Models\PreSell;
use Carbon\Carbon;

class RouteService
{
    public function handleRouteList()
    {
        // retrieve costumer recurrence
        $products = CostumerProducts::get();
         $agenda = [];

        foreach($products as $product){
            $nickname   = nickname($product->c_id);

            if($product->interval){
                $frequency  = intval(60/$product->interval);    

                // 1. search for last sale when table's ready
        
                for($i=0; $i < $frequency; $i++){

                    $date = Carbon::now()->add(($product->interval * ($i+1)), 'day');
                    
                    $agendadetails = [
                        'label'     => $nickname,
                        'date'      => $date->format('Y-m-d'),
                        'weekday'   => $date->isoWeekDay(),
                        'color'     => 'bg-accent'
                    ];
                    // $agenda[$date->isoWeekDay()][] = $agendadetails; 
                    $agenda[] = $agendadetails;
                }
               $date = "";
            } else if($product->exact_day){
                for($i=0; $i < 2; $i++){
                    $today = Carbon::now();
                    $date = Carbon::createFromDate($today->format('Y'), ($today->add($i, 'month')->format('m')), $product->exact_day);

                    $agendadetails = [
                        'label'     => $nickname,
                        'date'      => $date->format('Y-m-d'),
                        'weekday'   => $date->isoWeekDay(),
                        'color'     => 'bg-accent'
                    ];

                    $agenda[] = $agendadetails;
                }
                $date = "";
            }
        }

        // retrieve PreSell registers

        $presells = PreSell::where('status', '<', 2)->get();
        
        foreach($presells as $presell){
            
            $agendadetails = [
                'label'     => $nickname,
                'date'      => $presell->delivery_date->format('Y-m-d'),
                'weekday'   => $presell->delivery_date->isoWeekDay(),
                'color'     => 'bg-red-6'
            ];

            $agenda[] = $agendadetails;
        }

        return $agenda;
    }
}