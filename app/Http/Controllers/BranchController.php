<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index()
    {
        $branch = Branch::get();
        return response()->json(['branch' => $branch]);
    }

    public function store(Request $request)
    {
        $branch = Branch::create([
            // 'user_id' => $request->user_id,
            'name' => $request->name,
            'address' => $request->address
        ]);

        return response()->json(['msg' => 'Branch created successfully!'], 200);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::where('id', $id)->first();
         
        if($branch){
            $branch->update([
                // 'user_id' => $request->user_id,
                'name' => $request->name,
                'address' => $request->address
            ]);
        }

        return response()->json(['msg' => 'Branch updated successfully!'], 200);
    }

    public function destroy($id)
    {
        Branch::destroy($id);
        return response()->json(['msg' => 'Branch deleted successfully!'], 200);
    }
}
