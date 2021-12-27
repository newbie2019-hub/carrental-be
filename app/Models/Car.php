<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
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

    public function owner(){
        return $this->hasOneThrough(User::class, CarOwner::class, 'car_id', 'id', '', 'user_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function brand(){
        return $this->belongsTo(CarBrands::class, 'car_brand_id', 'id');
    }

    public function transmission(){
        return $this->belongsTo(TransmissionType::class, 'transmission_type_id', 'id');
    }

    public function rate(){
        return $this->hasOne(RentalRate::class, 'car_id', 'id');
    }
}
