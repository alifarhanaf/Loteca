<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoinController extends Controller
{
    public function index(Request $request){
        $user =  User::where('email',$request->email)->first();
        $user->contacts;
        $data = array(
            "status"=>200,
            "response"=>"true",
            "message" => "Success",
            "user" => $user,
            );
            return response()->json($data,200);
        
    }
}
