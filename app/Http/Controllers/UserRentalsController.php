<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;

class UserRentalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function rentalFinished(Request $request, $id){
        Car::where('id', $request->car['id'])->first()->update(['status' => 'available']);
        Rental::where('id', $id)->first()->update(['rental_status' => 'finished']);
        return response()->json(['msg' => 'Booking successful']);
    }

    public function rentals(){
        $rental = Rental::whereRelation('car.owner', 'user_info_id', auth()->user()->id)->with(['car', 'car.brand', 'payment', 'car.transmission', 'user', 'user.info'])->paginate(10);
        return response()->json($rental);
    }

    public function searchRental(){
        return response()->json(Rental::whereHas('user.info', function ($query){
           $query->where('first_name', 'like', '%'.request()->get('search').'%')
           ->orWhere('last_name', 'like', '%'.request()->get('search').'%'); 
        })->orWhereHas('car', function ($query){
            $query->where('model', 'like', '%'.request()->get('search').'%'); 
        })->orWhereHas('car.brand', function ($query){
            $query->where('brand', 'like', '%'.request()->get('search').'%'); 
        })->with(['car', 'car.brand', 'payment', 'car.transmission', 'user', 'user.info'])->paginate(10)
        );
    }

    public function updateRental(Request $request, $id){
        
        $data = [
            'rental_id' => $id,
            'total_payment' => $request->total_payment,
            'cash_received' => $request->cash_received,
            'change' => $request->change,
        ];

        Payment::create($data);

        $rental = Rental::where('id', $id)->first();

        if($rental){
            $rental->update(['status' => 'Paid']);
        }
        return response()->json(['msg' => 'Payment successful'], 200);
    }

    public function payments(){
        $payments = Payment::whereRelation('rental.car.owner', 'user_info_id', auth()->user()->id)->with(['rental', 'rental.car.owner', 'rental.user', 'rental.user.info'])->get();
        return response()->json($payments);
    }

}
