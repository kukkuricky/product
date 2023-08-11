<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $fields = $request->validate([

            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);

        //Check email

        $user= User::where('email', $fields['email'])->first();

        //Check Password
        if(!$user || !Hash::check($fields['password'], $user->password) ){
            return response([
                'message'=>'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $saveToken = User::where(['email' => $fields['email']])->update(["remember_token" => $token]);
        $response= [
            'user' => $user,
            'token'=> $token
        ];

        return response($response, 201);
    }
}
