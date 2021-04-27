<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Game;
use App\Models\Round;
use App\Models\Package;
use App\Models\WithDraw;
use App\Models\CoinTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $agent['phone'] = $agent->contacts[0]->phone;
            $updatedUser = User::where('email',$request->email)->first();
            $updatedUser['phone'] = $updatedUser->contacts[0]->phone;
            unset($agent->contacts);
            unset($updatedUser->contacts);

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
        

    }
    public function coinsRecord(){
        $coinsTransfer = CoinTransfer::where('sender_id',Auth::user()->id)->where('withdraw',0)->orderBy('created_at', 'desc')->get();
        $arr = [];
        $i = 0;
        foreach($coinsTransfer as $ct){
            
            $user = User::find($ct->receiver_id);
            // return $user->contacts;
            // dd($user,$user->contacts);
           if($user){

            $arr[$i]['record_id'] = $ct->id;
            $arr[$i]['user_name'] = $user->name;
            $arr[$i]['user_email'] = $user->contacts[0]->email;
            $arr[$i]['user_phone'] = $user->contacts[0]->phone;
            $arr[$i]['user_whatsapp'] = $user->contacts[0]->whatsapp;
            $arr[$i]['image'] = $user->images[0]->url;
            $arr[$i]['transferred_coins'] = $ct->sent_coins ;
            $arr[$i]['transfer_date'] = $ct->created_at ;
            $i++;
        }else{
            $arr[$i]['record_id'] = $ct->id;
            $arr[$i]['user_name'] = "User Deleted";
            $arr[$i]['user_email'] = "N/A";
            $arr[$i]['user_phone'] = "N/A";
            $arr[$i]['user_whatsapp'] = "N/A";
            $arr[$i]['image'] = "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png";
            $arr[$i]['transferred_coins'] = $ct->sent_coins ;
            $arr[$i]['transfer_date'] = $ct->created_at ;
            $i++;

        }
        
        }
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Record Retrieved Successfully" ,
            "records" => $arr,

        );
        return response()->json($data,200);
    }
    public function userBetsRecord(){
        $coinsTransfer = CoinTransfer::where('sender_id',Auth::user()->id)->where('withdraw',1)->orderBy('created_at', 'desc')->get();
        $arr = [];
        $i = 0;
        foreach($coinsTransfer as $ct){
            $user = User::find($ct->receiver_id);
           if($user){
            $arr[$i]['record_id'] = $ct->id;
            $arr[$i]['user_name'] = $user->name;
            $arr[$i]['user_email'] = $user->contacts[0]->email;
            $arr[$i]['user_phone'] = $user->contacts[0]->phone;
            $arr[$i]['user_whatsapp'] = $user->contacts[0]->whatsapp;
            $arr[$i]['image'] = $user->images[0]->url;
            $arr[$i]['coins_used'] = $ct->sent_coins ;
            $arr[$i]['bet_date'] = $ct->created_at ;
            $i++;
        }else{
            $arr[$i]['record_id'] = $ct->id;
            $arr[$i]['user_name'] = "User Deleted";
            $arr[$i]['user_email'] = "N/A";
            $arr[$i]['user_phone'] = "N/A";
            $arr[$i]['user_whatsapp'] = "N/A";
            $arr[$i]['image'] = "https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png";
            $arr[$i]['coins_used'] = $ct->sent_coins ;
            $arr[$i]['bet_date'] = $ct->created_at ;
            $i++;
        }
        }
        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Record Retrieved Successfully" ,
            "records" => $arr,

        );
        return response()->json($data,200);
    }

    public function ticketData(Request $request){
        $record_id = $request->record_id;
        $record = CoinTransfer::where('id',$record_id)->first();
        $user = User::find($record->receiver_id);
        $user['phone'] = $user->contacts[0]->phone;
        $agent = User::find($record->sender_id);
        $agent['phone']= $agent->contacts[0]->phone;
        $roundUserRecord = DB::table('round_user')->where('user_id',$record->receiver_id)->where('created_at',$record->created_at)->first();
        $round_id = $roundUserRecord->round_id ;
        $round = Round::find($round_id);
        $packages = $round->packages;
        $games = $round->games;
        $userAnswers = DB::table('bid_results')
                            ->where('user_id', $user->id)
                            ->where('round_id', $round_id)
                            ->where('created_at',$record->created_at)->get();
        $package_id = $userAnswers[0]->package_id; 
        $package = Package::where('id',$package_id)->first();
        
       
        //User's Selected Answer's Array For Response
        $ansArray = [];
        for($k=0;$k<count($userAnswers);$k++){
        $game = Game::where('id',$userAnswers[$k]->game_id)->first();
            
        $ansArray[$k]['id'] = $userAnswers[$k]->id;
        $ansArray[$k]['team_a'] = $game->team_a;
        $ansArray[$k]['team_b'] = $game->team_b;
        $ansArray[$k]['winner'] = $userAnswers[$k]->answer;
        $ansArray[$k]['championship'] = $game->name;
        $ansArray[$k]['happening_date'] = $game->happening_date;

        }




        $completeRound = array(
            'id' => $round->id,
            'name' => $round->name,
            'starting_date' => $round->starting_date,
            'ending_date' => $round->ending_date,
            'created_at' => $round->created_at,
            'updated_at' => $round->updated_at,
            'selected_package' => $package,
            'packages' => $packages,
            'games' => $games,
        );

        $data = array(
            "status" => 200,
            "response" => "true",
            "message" => "Record Retrieved Successfully",
            "bid" => true,
            "bet_date" => $record->created_at,
            "user" => $user,
            "agent" => $agent,
            "round" => $completeRound,
            "userAnswers" => $ansArray,
        );

        return response()->json($data, 200);


    }
    public function userCoinsRecord(){
        $coinsTransfer = CoinTransfer::where('receiver_id',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $arr = [];
        $i = 0;
        foreach($coinsTransfer as $ct){
            $user = User::find($ct->sender_id);
            // dd($user,$user->contacts);
            $arr[$i]['sender_name'] = $user->name;
            $arr[$i]['sender_email'] = $user->contacts[0]->email;
            $arr[$i]['sender_phone'] = $user->contacts[0]->phone;
            $arr[$i]['sender_whatsapp'] = $user->contacts[0]->whatsapp;
            $arr[$i]['sender_image'] = $user->images[0]->url;
            $arr[$i]['received_coins'] = $ct->sent_coins ;
            $arr[$i]['receiving_date'] = $ct->created_at ;
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
