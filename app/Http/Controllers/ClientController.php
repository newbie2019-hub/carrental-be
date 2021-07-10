<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return response()->json(User::with(['info'])->paginate(10));
    }

    public function search(){
        $user = User::whereHas('info', function ($query){
            $query->where('first_name', 'like', '%'.request()->get('search').'%')
            ->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
            ->orWhere('last_name', 'like', '%'.request()->get('search').'%');
        })->with('info')->paginate(10);
        return response()->json($user);
    }

    public function delete($id){
        User::destroy($id);
        return response()->json(['msg' => 'Patient deleted successfully!'], 200);
    }

    public function rentals(){
        return response()->json(Rental::with(['car', 'car.brand', 'payment', 'car.transmission', 'user', 'user.info'])->paginate(10));
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
        return response()->json(Payment::with(['rental', 'rental.user', 'rental.user.info'])->get());
    }
}
