<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\WithDraw;
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
            $com_percentage = $user->comissions[0]->comission_percentage;
            $history5 = CoinTransfer::where('sender_id', '=', $user->id)->get();
            $total_sales5 = 0; 

            $comission5 = 0;
            foreach($history5 as $h5){
            $cc = $h5->sent_coins;
            $ac = ($cc * $com_percentage)/100;
            $comission5 = $comission5 + $ac;
            $comission5 = round($comission5, 1);


            }
            if($user->withdraws == null){
                $withdrawTable = new WithDraw();
                $withdrawTable->total_comission = $comission5;
                $withdrawTable->user_id = $user->id;
                $withdrawTable->save(); 

            }else{
                $withdraw = WithDraw::find($user->withdraws->id);
                $withdraw->total_comission = $comission5;
                $withdraw->user_id = $user->id;
                $withdraw->save(); 

            }
            
            $agent = Auth::user();
            $updatedUser = User::where('email',$request->email)->first();

            $data = array(
                "status" => 200,
                "response" => "true",
                "message" => "Coins Sent Successfully" ,
                "agent" => $agent,
                "user" => $updatedUser,
                "coins_transferred" => $request->coins,
                "transfer_date" => $ct->created_at,
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
        // return $request->all();

    }
    public function coinsRecord(){
        $coinsTransfer = CoinTransfer::where('sender_id',Auth::user()->id)->get();
        $arr = [];
        $i = 0;
        foreach($coinsTransfer as $ct){
            $user = User::find($ct->receiver_id);
            // dd($user,$user->contacts);
            $arr[$i]['user_name'] = $user->name;
            $arr[$i]['user_email'] = $user->contacts[0]->email;
            $arr[$i]['user_phone'] = $user->contacts[0]->phone;
            $arr[$i]['user_whatsapp'] = $user->contacts[0]->whatsapp;
            $arr[$i]['image'] = $user->images[0]->url;
            $arr[$i]['transferred_coins'] = $ct->sent_coins ;
            $arr[$i]['transfer_date'] = $ct->created_at ;
            if($ct->withdraw == 0){
                $arr[$i]['type'] = 0 ;
            }else{
                $arr[$i]['type'] = 1 ;
            }
            $i++;
            

        }
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Record Retrieved Successfully" ,
            "records" => $arr,

        );
        return response()->json($data,200);
    }
}
