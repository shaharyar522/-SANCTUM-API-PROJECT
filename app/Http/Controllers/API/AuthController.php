<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //regestration
    public function signup(Request $request)
    {
        //now first check the Validate to check 
        // now i am used the cehck the make method this method after validate to to show 
        //erorr  beucase this code is api 
        $ValidateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );
        //agr fail hn gyi request
        if ($ValidateUser->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'invalide users login',
                'error' => $ValidateUser->error()->all(),
            ], 401);
        };
  // otherwise store in db
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
// and return json
        return response()->json([
            'status' => 'true',
            'message' => 'User Login  Created Successfully',
            'user' => $user,
        ], 200);
    }







    //login
    public function login(Request $request)
    {

        $ValidateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($ValidateUser->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'invalide users login',
                'error' => $ValidateUser->error()->all(),
            ], 404);
        };

        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            $authUser = Auth::user();
            return response()->json([
            'status' => 'true',
            'message' => 'User Login  Created Successfully',
            'token' => $authUser->createToken("API Token")->plainTextToken,
            'token_type' => 'bearer', 
        ],200);
        }else{
             return response()->json([
                'status' => 'false',
                'message' => 'Email and password does not match',
            ], 401);
        }
    }



    //logout
    public function logout(Request $request) {
        $user  = $request->user();
        $user()->tokens()->delete();

        return response()->json([
            'status' => 'true',
            'user' => $user,
            'message' => 'User Logout   Successfully',
            
        ], 200);
    }
}
