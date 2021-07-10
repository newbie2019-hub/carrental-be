<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrands;
use App\Models\Inquiry;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function summary(){
        $inquiry = Inquiry::count();
        $car = Car::count();
        $payment = Payment::count();
        $client = User::count();
        $brand = CarBrands::count();
        $rental = Rental::count();

        return response()->json([
            'inquiry' => $inquiry,
            'car' => $car,
            'payment' => $payment,
            'client' => $client,
            'brand' => $brand,
            'rental' => $rental
        ], 200);
    }
}
