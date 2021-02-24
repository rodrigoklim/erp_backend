<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     *      1 - anticipated ->  / account needed
     *      2 - cashPay 
     *              21 - money 
     *              22 - check
     *              23 - debit card 
     *              24 - credit card
     *      3 - termPayment
     *              31 - bankSlip       -> term needed
     *              32 - check          -> term needed
     *              33 - bankTransfer   -> contract, term and account needed
     *              34 - monthlyPayment -> close date and pay date needed
     */

    protected $fillable = [
        'c_id', 'payment_code', 'contract', 'account', 'close_date', 'payment_date', 'term', 'payment_description'
    ];
}
