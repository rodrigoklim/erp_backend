<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaturalPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'c_id', 'cpf', 'name', 'company_name','birthdate', 'register_situation',
        'phone_1', 'phone_1zap', 'phone_2', 'phone_2zap', 'phone_3','phone_3zap', 'phone_4', 
        'phone_4zap', 'phone_5', 'phone_5zap',' email', 'main_activity', 'contact'
    ];

    public function address()
    {
        return $this->hasMany(Address::class, 'c_id', 'c_id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'c_id', 'c_id');
    }

    public function payMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'c_id', 'c_id');
    }

    public function products()
    {
        return $this->hasMany(CostumerProducts::class, 'c_id', 'c_id');
    }
}
