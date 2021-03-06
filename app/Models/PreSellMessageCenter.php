<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSellMessageCenter extends Model
{
    use HasFactory;

    /**
     * status 
     *      0 = wait
     *      1 = read
     *      2 = solved
     */
    protected $fillable = [
        'presell_id', 'user', 'message', 'responsible', 'status'
    ];

}
