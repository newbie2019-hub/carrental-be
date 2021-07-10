<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentalRate;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['getCars']]);
    }

    public function index(){
        $car = Car::with(['brand', 'transmission', 'rate'])->paginate(10);
        return response()->json($car, 200);
    }

    public function getCars(){
        $car = Car::with(['brand', 'transmission', 'rate'])->get();
        return response()->json($car, 200);
    }

    public function searchCar(Request $request){
        $carbrands = Car::whereHas('brand', function ($query) {
            $query->where('brand', 'like', '%'.request()->get('search').'%');
        })->orWhere('model', 'like', '%'.$request->search.'%')
        ->orWhere('year', 'like', '%'.$request->search.'%')
        ->orWhere('seats', 'like', '%'.$request->search.'%')
        ->orWhere('description', 'like', '%'.$request->search.'%')
        ->with(['brand', 'transmission', 'rate'])->paginate(10);
        return response()->json($carbrands, 200);
    }

    public function deleteFileFromServer($filename){
        $filePath = public_path().'/uploads/'.$filename;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function uploadFeaturedImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function store(Request $request){
        $data = [
            'car_brand_id' => $request->brand,
            'model' => $request->model,
            'description' => $request->description,
            'transmission_type_id' => $request->transmission_type,
            'image' => $request->image,
            'year' => $request->year,
            'seats' => $request->seats,
        ];

        $car = Car::create($data);
        
        $ratedata = [
            'car_id' => $car->id,
            'with_driver' => $request->with_driver,
            'per_day' => $request->per_day,
        ];

        RentalRate::create($ratedata);

        return response()->json(['msg' => 'Car saved successfully!'], 200);
    }

    public function update(Request $request, $id){
        $data = [
            'car_brand_id' => $request->brand,
            'model' => $request->model,
            'description' => $request->description,
            'transmission_type_id' => $request->transmission_type,
            'year' => $request->year,
            'seats' => $request->seats,
        ];

        if($request->image){
            $data['image'] = $request->image;
        }

        $car = Car::where('id', $id)->first();
        $car->update($data);

        $rentalrate = RentalRate::where('id', $id)->first();
        $rentalrate->update(['per_day' => $request->per_day, 'with_driver' => $request->with_driver]);

        return response()->json(['msg' => 'Car updated successfully!'], 200);
    }

    public function destroy($id){
        Car::destroy($id);
        return response()->json(['msg' => 'Car deleted successfully!'], 200);

    }
}
