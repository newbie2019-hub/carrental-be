<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    public $guarded = [];

    public function car(){
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }

    public function payment(){
        return $this->belongsTo(PaymentType::class, 'payment_type_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
