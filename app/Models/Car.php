<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    public $guarded = [];

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
