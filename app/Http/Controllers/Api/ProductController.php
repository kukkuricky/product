<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\product;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
//        dd($request->get('id'));
        $tokenReceived = $request->header('authorization');
        if($tokenReceived){
            $user = \App\Models\User::where('remember_token', $tokenReceived)->first();
            if($user){
                $getList = product::all();
                if($request->get('id')){
                    $getSpecific = product::where("id", $request->get('id'))->get();
                    return response()->json($getSpecific);
                }
                return response()->json($getList);
            }

        }
    }
}
