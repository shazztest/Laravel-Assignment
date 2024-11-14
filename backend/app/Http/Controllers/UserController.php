<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function createUser(Request $request){


        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|string:8',
            'phone' => 'required|numeric',
            'address' => 'string',
         ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ],402);
        }

        $password = Hash::make($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        $user->roles()->attach(2);
        $roles = $user->roles()->pluck('name');
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'success' => true,
            'messages' => 'User Register Successfully',
            'data' => [
                'user' =>$user,
                'token' => $token,
                'role' => $roles,
            ]
        ],201);
    }

    public function check(){
        return 'chekckkk1';
    }

    public function loginUser(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' =>'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'messages' => 'Validation failed',
                'errors' => $validator->errors(),
            ],401);
        }

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $roles = $user->roles()->pluck('name');
            $token = $user->createToken('API Token')->accessToken;
            return response()->json(['token'=>$token,'user'=>$user,'role'=>$roles]);
        }else{
            return response()->json(['error'=>'Unauthorized'],401);        }
    }
}
