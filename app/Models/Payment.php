<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $guarded = [];

    public function rental(){
        return $this->belongsTo(Rental::class,'rental_id', 'id');
    }
}
