<?php

namespace App\Http\Controllers\Api;

use App\Models\Round;
use App\Models\RoundUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Winner;
use Illuminate\Support\Facades\Auth;

class UserDashBoardController extends Controller
{
    public function userDashboard(){
        $user = Auth::user();
        $userDetail = [];
        $userDetail['id'] = $user->id;
        $userDetail['name'] = $user->name;
        $userDetail['email'] = $user->email;
        if($user->email_verified_at == null){
            $userDetail['verified'] = false;
        }else{
            $userDetail['verified'] = true;
        }
        if($user->roles == 2){
            $userDetail['role'] = "agent";
        }else if($user->roles == 1){
            $userDetail['role'] = "user";
        }else if($user->roles == 3){
            $userDetail['role'] = "agent";
        }
        $userDetail['coins_available'] = $user->coins;
        $userDetail['phone'] = $user->contacts[0]->phone;
        $userDetail['whatsapp'] = $user->contacts[0]->whatsapp;
        $userDetail['images'] = $user->images[0]->url;

        // $totalBetsRecords = RoundUser::where('user_id',$user->id)->get();
        $totalBetsRecords = DB::table('round_user')->where('user_id',$user->id)->get();
        $totalBetsPlaced = count($totalBetsRecords);
        // $roundIds = [];
        $active=0;
        $closed=0;

        foreach($totalBetsRecords as $tp){
            $round = Round::where('id',$tp->round_id)->first();
            if($round){
                $winnerCheck = Winner::where('round_id',$round->id)->first();
                if($winnerCheck && $round->status == 2){
                    $closed = $closed+1;

                }else{
                    $active = $active+1;
                }

            }
        }


        $data = array(
            "status"=>200,
            "response"=>"true",
            "message" => "Success",
            "data" => array(
                "totalBetsPlaced" => $totalBetsPlaced,
                "totalActiveBetsPlaced" => $active,
                "totalClosedBetsPlaced" => $closed,
                // "weekly_data" => $weekly_data,
                // "monthly_data" => $monthly_data,
                // "all_time_data" => $all_time_data,
                "user" => $userDetail,
                // "available_for_withdraw" => intval($afw),
    
            )
            );
            return response()->json($data,200);


        $userDetail['id'] = $user->id;
        $userDetail['id'] = $user->id;
        
    }
}
