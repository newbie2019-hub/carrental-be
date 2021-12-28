<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminInfo;
use App\Models\Inquiry;
use App\Models\PaymentType;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'paymenttype']]);
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function update(Request $request, $id) {
        try {
            if($request->img){
                $data = [
                    'image' => $request->img,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                ];
            }
            else {
                $data = [
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                ];
            }

            $user = [
                'email' => $request->email,
            ];

            if($request->password) {
                $user['password'] = Hash::make($request->password);
            }

            $admininfo = AdminInfo::find($id);
            $admininfo->update($data);
            $admin = Admin::find($id);
            $admin->update($user);

           return response()->json(['message' => 'User updated successfully!'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function updateUserAccount(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required',
            'gender' => 'required',
        ]);

        $userinfo = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
        ];

        UserInfo::where('id', $id)->update($userinfo);
        
        User::where('id', $id)->update(['email' => $request->email]);

        $user = User::with(['info'])->where('id', $id)->first();
        return response()->json(['success' => 'Account updated successfuly!', 'user' => $user], 200);
    }

    public function me()
    {
        $account = Admin::with(['info'])->where('id', auth('admin')->user()->id)->first();
        return response()->json($account);
    }

    public function logout()
    {

        auth()->logout();
        return response()->json(['message' => 'User logged out successfully!']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        $account = Admin::with(['info'])->where('id', auth('admin')->user()->id)->first();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $account
        ]);
    }

    public function inquiry(){
    return response()->json(Inquiry::paginate(10));
    }

    public function paymenttype(){
        return response()->json(PaymentType::get());
    }


}
