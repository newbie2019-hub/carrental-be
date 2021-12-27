<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i A',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

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
