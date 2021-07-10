<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'store']]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'middle_name' => 'required',
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
        
        $user = [
            'email' => $request->email
        ];

        if($request->password){
            $user['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($user);

        $user = User::with(['info'])->where('id', $id)->first();
        return response()->json(['success' => 'Account updated successfuly!', 'user' => $user], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required',
            'gender' => 'required',
            'email' => 'unique:users,email'
        ]);

        $userinfo = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
        ];

        $user_created_info = UserInfo::create($userinfo);

        $user = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_info_id' => $user_created_info->id,
        ];
        
        $user = User::create($user);

        $user = User::with(['info'])->where('id', $user->id)->first();
        return response()->json(['success' => 'Account created successfuly!', 'user' => $user], 200);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'User logged out successfully!']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }

    public function me()
    {
        $account = User::with(['info'])->where('id', auth('api')->user()->id)->first();
        return response()->json($account);
    }
}
