<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'c_id', 'nf', 'payment_method','sales_comission', 'financial_flag', 'remittance_flag'
    ];

}
