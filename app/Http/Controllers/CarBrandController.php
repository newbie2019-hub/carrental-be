<?php

namespace App\Http\Controllers;

use App\Models\CarBrands;
use App\Models\TransmissionType;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    public function all(){
        return response()->json(CarBrands::get());
    }

    public function index(){
        return response()->json(CarBrands::paginate(10));
    }

    public function store(Request $request){
        CarBrands::create(['brand' => $request->brand]);
        return response()->json(['msg' => 'Car Brand added successfully!'], 200);
    }

    public function searchCarBrand(Request $request){
        $carbrands = CarBrands::where('brand', 'like', '%'.$request->search.'%')->paginate(10);
        return response()->json($carbrands, 200);
    }

    public function destroy($id){
        CarBrands::destroy($id);
        return response()->json(['msg' => 'Deleted successfully!'], 200);
    }

    public function update(Request $request, $id){
        $carbrand = CarBrands::find($id);
        if($carbrand){
           $carbrand->update(['brand' => $request->brand]); 
        }
        return response()->json(['msg' => 'Brand updated successfully!'], 200);
    }

    public function transmission(){
        $trans = TransmissionType::get();
        return response()->json($trans, 200);
    }
}
