<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Exception;
use Illuminate\Http\Request;
use Stripe;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['checkout']]);
    }

    public function checkout(Request $request)
    { 
        $response = '';
        if($request->payment_type == 1){
            try {
                $stripe = new \Stripe\StripeClient('sk_test_51KAQ3ADoJANsLvgsci2nG46EFVHLQbFxS6qfZ8UEpGl1ffYIVcDBsHOOKu7SVI9MBTCjBm43dSu8oKhQSSsK1uaF00ivv1r0U3');

                $token = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                    ],
                ]);
        
                $stripecharge = new \Stripe\StripeClient('sk_test_51KAQ3ADoJANsLvgsci2nG46EFVHLQbFxS6qfZ8UEpGl1ffYIVcDBsHOOKu7SVI9MBTCjBm43dSu8oKhQSSsK1uaF00ivv1r0U3');
                $stripecharge->charges->create([
                        "amount" => $request->payment_fee * 100,
                        "currency" => "php",
                        "source" => $token,
                        "description" => "Car rental payment" 
                ]);
                
            }catch(Exception $e){
                return response()->json(['msg' => $e->getMessage()], 422);
            }

            Rental::create([
                'car_id' => $request->car_id,
                'pickup_date' => $request->pickup,
                'dropoff_date' => $request->dropoff,
                'with_driver' => $request->with_driver,
                'user_id' => $request->user_id,
                'total_payment' => $request->payment_fee,
                'payment_type_id' => $request->payment_type,
                'status' => 'Paid',
                'rental_status' => 'on-going',
                'additional_instructions' => $request->additionalinstruction
            ]);

            Car::where('id', $request->car_id)->update(['status' => 'rented']);

            return response()->json(['res' => $response, 'msg' => 'Rental created successfully'], 200);
        }
        else {

            Rental::create([
                'car_id' => $request->car_id,
                'pickup_date' => $request->pickup,
                'dropoff_date' => $request->dropoff,
                'with_driver' => $request->with_driver,
                'user_id' => $request->user_id,
                'total_payment' => $request->payment_fee,
                'payment_type_id' => $request->payment_type,
                'status' => 'For payment',
                'additional_instructions' => $request->additionalinstruction
            ]);

            return response()->json(['msg' => 'Rental created successfully'], 200);
        }
        return response()->json(['msg' => 'Success'], 200);
    }

    public function index(){
        return response()->json(Rental::where('user_id', auth('api')->user()->id)->with(['car', 'car.brand', 'payment', 'car.transmission'])->get());
    }
}
