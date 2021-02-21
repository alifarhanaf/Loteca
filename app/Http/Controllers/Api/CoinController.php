<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoinController extends Controller
{
    public function index(Request $request){
        $user =  User::where('email',$request->email)->first();
        if ($user ){
            $user->contacts;
            $user->images;
            $data = array(
            "status"=>200,
            "response"=>"true",
            "message" => "Success",
            "user" => $user,
            );
            return response()->json($data,200);

        }else{
            $data = array(
            "status" => 404,
            "response" => "false",
            "message" => "User Not Found",
            );
            return response()->json($data,200);
        }
        
        
    }
    public function sendCoins(Request $request){
        $user =  Auth::user();
        // return $user->coins;
        if($user->coins >= $request->coins){
            $cc = $user->coins - $request->coins;
            $sender = User::find($user->id);
            $sender->coins = $cc ;
            $sender->save();
            $receiver = User::where('email',$request->email)->first();
            $receiver->coins = $receiver->coins + $request->coins;
            $receiver->save();
            $ct = new CoinTransfer(); 
            $ct->sender_id = $sender->id;
            $ct->receiver_id = $receiver->id;
            $ct->sent_coins = $request->coins;
            $ct->save();

            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Coins Sent Successfully" ,
                );
                return response()->json($data,200);

        }else{
            $data = array(
                "status" => 209,
                "response" => "false",
                "message" => "You Don't have enough coins" ,
                );
                return response()->json($data,209);

        }
        return $request->all();

    }
}
